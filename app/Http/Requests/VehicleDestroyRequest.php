<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class VehicleDestroyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();

        $vehicle = $this->route('vehicle');

        if (!$vehicle) {
            abort(404);
        }

        if (!$user->can('modify', $vehicle)) {
            return false;
        }

        return true;
    }

    /**
     * All override
     *
     * @param null $keys
     * @return array|mixed
     */
    public function all($keys = null)
    {
        $request = $this->input();
        $request['vehicle'] = $this->route('vehicle');
        return $request;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

        ];
    }
}
