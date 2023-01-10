<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Livewire\Exceptions\CorruptComponentPayloadException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Illuminate\Http\Response;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        CorruptComponentPayloadException::class
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        if (app()->bound('sentry') && $this->shouldReport($exception)) {
            app('sentry')->captureException($exception);
        }

        parent::report($exception);
    }

    /**
     * Unauthenticated API response
     *
     * @param \Illuminate\Http\Request $request
     * @param AuthenticationException $exception
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('nova.login'));
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
//        if ($exception instanceof CorruptComponentPayloadException) {
//
//        } else {
//            return parent::render($request, $exception);
//        }

        if ($request->expectsJson()) {
            if ($exception instanceof ValidationException) {
                return $this->validationOutput($exception);
            } elseif ($exception instanceof AuthorizationException) {
                return $this->errorOutput($exception->getMessage(), 403);
            } elseif ($exception instanceof NotFoundHttpException) {
                return $this->errorOutput('Not found.', 404);
            }

        }

        return parent::render($request, $exception);
    }

    /**
     * Error response format
     *
     * @param $message
     * @param $code
     * @return Response
     */
    public function errorOutput($message, $code)
    {
        $res =  [
            'error' => [
                [
                    'type' => "general",
                    'field' => null,
                    'message' => $message
                ]
            ]
        ];

        return (new Response($res, $code) )->header('Content-Type', 'application/json');
    }

    /**
     * Validation output response format
     *
     * @param $e
     * @return Response
     */
    public function validationOutput($e)
    {
        $validator = $e->validator;

        $messages = $validator->getMessageBag()->getMessages();

        $res = [
            'error' => [
                [
                    'type' => "validation",
                    'message' => $messages
                ]
            ]
        ];

        return (new Response($res, 422) )->header('Content-Type', 'application/json');
    }
}
