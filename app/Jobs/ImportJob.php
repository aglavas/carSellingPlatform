<?php

namespace App\Jobs;

use App\Events\ImportFinished;
use App\Exceptions\BrandMappingException;
use App\Exceptions\ImportColumnMissingException;
use App\Exceptions\NCUserBrandMissing;
use App\Exceptions\UserStockTypeMissing;
use App\Exceptions\UserVehicleTypeMissing;
use App\Exceptions\UserWithoutCompanyException;
use App\Mail\ContactForm;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Maatwebsite\Excel\Excel;
use PhpOffice\PhpSpreadsheet\Settings;

class ImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $file;
    private $importClass;
    private $stockList;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($file, $importClass, $stockList)
    {
        $this->file = $file;
        $this->importClass = $importClass;
        $this->stockList = $stockList;
    }

    /**
     * Execute the job.
     *
     * @return bool
     */
    public function handle()
    {
        Settings::setLibXmlLoaderOptions(LIBXML_COMPACT | LIBXML_PARSEHUGE);

        App::instance('vin_candidates', []);
        ini_set('memory_limit', '-1');

        $import = new $this->importClass;

        try {
            $import->import($this->file, 'public');
        } catch (ImportColumnMissingException $exception) {
            return $this->columnMissingError($exception->getMessage());
        } catch (BrandMappingException $exception) {  //@todo check this, possibly deprecated
            return $this->brandMappingError($exception->getMessage());
        } catch (UserVehicleTypeMissing $exception) {
            return $this->userVpvuMissingError();
        } catch (UserStockTypeMissing $exception) {
            return $this->userStockTypeMissingError();
        } catch (NCUserBrandMissing $exception) {
            return $this->NCUserBrandMissingError();
        } catch (UserWithoutCompanyException $exception) {
            return $this->userCompanyMissingError();
        }

        if ($import->errors()->count() > 0) {
            $errors = [];

            foreach ($import->errors() as $error) {
                $errors[] = (string) $error;
            }

            $errors = json_encode($errors);

            Log::error($errors);

            return $this->unknownError();
        } elseif ($import->failures()->count() > 0) {
            $this->stockList->status = 'Error: ' . PHP_EOL;
            $status = [];
            foreach ($import->failures() as $failure) {
                $status[] = 'Line <b>' . $failure->row() . '</b>: ' . implode(", ", $failure->errors());
            }
            $this->stockList->status = implode('<br />', $status);

            if (!$this->stockList->automatic) {
                $message = 'There was an error with following upload: <a href="'.URL::to('/nova/resources/stock-list-uploads/'.$this->stockList->id).'">Stock List '.$this->stockList->id.'</a>';

                Mail::to([
                    'kim.pattynama@emilfrey.ch',
                    'marin.maric@freyservices.hr',
                    'tatjana.sitar@freyservices.hr'
                ])->send(new ContactForm(['message' => $message, 'user' => Auth::user()]));
            }

            $this->stockList->save();
        } else {
            $this->stockList->status = '1';

            $user = request()->user();

            $user->load('company');

            if (!$this->stockList->automatic) {
                Mail::to([
                    'kim.pattynama@emilfrey.ch',
                    'marin.maric@freyservices.hr',
                    'tatjana.sitar@freyservices.hr',
                    $user->email
                ])->send(new ContactForm(['message' => 'Upload was successful. <a href="'.URL::to('/nova/resources/stock-list-uploads/'.$this->stockList->id).'">Stock List '.$this->stockList->id.'</a>', 'user' => $user]));
            }

            $this->stockList->save();

            event(New ImportFinished($user, $this->stockList));
        }
    }

    /**
     * Structure error for missing column
     *
     * @param string $failure
     * @return bool
     */
    private function brandMappingError(string $brand)
    {
        $this->stockList->status = 'Error: ' . PHP_EOL;
        $status = 'Provided brand: <b>' . $brand . '</b> cannot be mapped. Please check correct mapping.';
        $this->stockList->status = $status;

        $this->handleError();
    }

    /**
     * Structure error for missing column
     *
     * @param string $failure
     * @return bool
     */
    private function userVpvuMissingError()
    {
        $this->stockList->status = 'Error: ' . PHP_EOL;
        $status = 'User is missing VPVU information. Upload not possible';
        $this->stockList->status = $status;

        $this->handleError();
    }

    /**
     * Structure error for missing brand (NC users)
     */
    private function NCUserBrandMissingError()
    {
        $this->stockList->status = 'Error: ' . PHP_EOL;
        $status = 'NC User is missing brand information. Upload not possible';
        $this->stockList->status = $status;

        $this->handleError();
    }

    /**
     * Structure error for missing stock type
     */
    private function userStockTypeMissingError()
    {
        $this->stockList->status = 'Error: ' . PHP_EOL;
        $status = 'User is missing Stock Type information. Upload not possible';
        $this->stockList->status = $status;

        $this->handleError();
    }

    /**
     * Structure error for user without company
     */
    private function userCompanyMissingError()
    {
        $this->stockList->status = 'Error: ' . PHP_EOL;
        $status = 'User is missing company information. Upload not possible';
        $this->stockList->status = $status;

        $this->handleError();
    }

    /**
     * Structure error for missing column
     *
     * @param string $failure
     * @return bool
     */
    private function columnMissingError(string $failure)
    {
        $this->stockList->status = 'Error: ' . PHP_EOL;
        $missingColumn = str_replace('Undefined index: ', '', $failure);
        $status = 'List is missing column: <b>' . $missingColumn.'</b>. Please check, that the column '.$missingColumn.' exists in the file. Is the spelling of the column correct?';
        $this->stockList->status = $status;

        $this->handleError();
    }

    /**
     * Structure error for unknown error
     *
     * @param $errors
     */
    private function unknownError()
    {
        $this->stockList->status = "Unexpected error. Please contact system administrator.";

        $this->handleError();
    }

    /**
     * Handle import error
     *
     * @return bool
     */
    private function handleError()
    {
        $message = 'There was an error with following upload: <a href="'.URL::to('/nova/resources/stock-list-uploads/'.$this->stockList->id).'">Stock List '.$this->stockList->id.'</a>';

        Mail::to([
            'kim.pattynama@emilfrey.ch',
            'marin.maric@freyservices.hr',
            'tatjana.sitar@freyservices.hr'
        ])->send(new ContactForm(['message' => $message, 'user' => Auth::user()]));

        $this->stockList->error_code_response = 1;
        $this->stockList->save();

        return true;
    }
}
