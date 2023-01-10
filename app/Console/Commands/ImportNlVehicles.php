<?php

namespace App\Console\Commands;

use App\Exceptions\XmlIOException;
use App\Service\CarUploadService;
use App\Parsers\XmlNlParser;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class ImportNlVehicles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:vehicles:nl';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import vehicles from Holland FTP';

    /**
     * @var CarUploadService
     */
    private $carUpload;

    /**
     * ImportNlUsedCars constructor.
     * @param CarUploadService $carUploadService
     */
    public function __construct(CarUploadService $carUploadService)
    {
        $this->carUpload = $carUploadService;

        parent::__construct();
    }

    /**
     * Handle
     */
    public function handle()
    {
        $mappingArray = config('carmarket.imports.used.nl.mappings');

        $mappingKeys = array_keys($mappingArray);

        foreach ($mappingKeys as $key) {
            $companyId = $mappingArray[$key]['klantnummer'];

            $user = User::where('company_id', $companyId)->whereNotNull('vehicle_type')->first();

            if (!$user) {
                $this->error('Company, user and vehicle type should be preset.');
                return false;
            }

            if (!$user->isSeller()) {
                $this->error('User is not seller.');
                return false;
            }

            if ($user->country != 'NL') {
                $this->error('User is not from NL.');
                return false;
            }

            Auth::loginUsingId($user->id, true);

            $uploadFolder = config('carmarket.imports.used.nl.folders.import') . "/{$key}";

            $files = File::allFiles($uploadFolder);

            foreach ($files as $filename) {

                $extension = File::extension($filename);

                if ($extension === 'xml') {

                    /** @var \SplFileInfo $filename */

                    $name = $filename->getFilename();

                    $filePath = $filename->getPathname();

                    if (file_exists($filePath)) {
                        try {

                            $source = [
                                'path' => $filePath,
                                'file' => $filename->getFilename(),
                                'key' => $key
                            ];

                            $this->carUpload->startUpload($source, CarUploadService::SOURCE_FILE, XmlNlParser::class);
                        } catch (XmlIOException $exception) {
                            $this->info("File under name $name and path $filePath should exist. But is missing.");

                            Log::error($exception);

                            continue;
                        }

                        $this->info("File under name $name has been processed.");
                    } else {
                        $this->info("File under name $name and path $filePath should exist. But is missing.");
                    }
                }
            }

        }
    }
}
