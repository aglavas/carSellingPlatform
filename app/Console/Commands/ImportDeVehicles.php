<?php

namespace App\Console\Commands;

use App\Exceptions\CsvIOException;
use App\Parsers\CsvDeParser;
use Illuminate\Console\Command;
use App\Service\CarUploadService;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ImportDeVehicles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:vehicles:de';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import vehicles from Germany FTP';

    /**
     * @var CarUploadService
     */
    private $carUpload;

    /**
     * Create a new command instance.
     *
     * ImportDeVehicles constructor.
     * @param CarUploadService $carUploadService
     */
    public function __construct(CarUploadService $carUploadService)
    {
        $this->carUpload = $carUploadService;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return bool
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function handle()
    {
        $mappingArray = config('carmarket.imports.used.de.mappings');

        $companyId = $mappingArray['company_data']['company_id'];

        $user = User::where('company_id', $companyId)->whereNotNull('vehicle_type')->first();

        if (!$user) {
            $this->error('Company, user and vehicle type should be preset.');
            return false;
        }

        if (!$user->isSeller()) {
            $this->error('User is not seller.');
            return false;
        }

        if ($user->country != 'DE') {
            $this->error('User is not from DE.');
            return false;
        }

        Auth::loginUsingId($user->id, true);

        $uploadCsvFile = config('carmarket.imports.used.de.folders.import') . '/efgd-de.csv';

        $name = 'efgd-de.csv';

        if (file_exists($uploadCsvFile)) {
            try {
                $source = [
                    'path' => $uploadCsvFile,
                    'file' => 'efgd-de.csv',
                    'key' => ''
                ];

                $this->carUpload->startUpload($source, CarUploadService::SOURCE_FILE, CsvDeParser::class);
            } catch (CsvIOException $exception) {
                $this->info("File under name $name and path $uploadCsvFile should exist. But is missing.");

                Log::error($exception);
            }

            $this->info("File under name $name has been processed.");
        } else {
            $this->info("File under name $name and path $uploadCsvFile should exist. But is missing.");
        }
    }
}
