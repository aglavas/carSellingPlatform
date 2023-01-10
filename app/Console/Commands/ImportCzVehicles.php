<?php

namespace App\Console\Commands;

use App\Exceptions\AutoSphereException;
use App\Export\AutoSphereCzCsvExport;
use App\Parsers\CsvCzParser;
use App\Service\AutosphereService;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Exceptions\CsvIOException;
use App\Service\CarUploadService;

class ImportCzVehicles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:vehicles:cz';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import vehicles from AutoSphere CZ';

    /**
     * @var AutosphereService
     */
    public $autoSphereService;

    /**
     * @var CarUploadService
     */
    public $carUpload;

    /**
     * @var array
     */
    public static $csvHeadings = [];

    /**
     * ImportCzVehicles constructor.
     * @param AutosphereService $autoSphereService
     * @param CarUploadService $carUploadService
     */
    public function __construct(AutosphereService $autoSphereService, CarUploadService $carUploadService)
    {
        parent::__construct();

        $this->autoSphereService = $autoSphereService;
        $this->carUpload = $carUploadService;
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
        ini_set("memory_limit",-1);

        $this->info('CZ import started.');

        $mappingArray = config('carmarket.imports.used.cz.mappings');

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

        if ($user->country != 'CZ') {
            $this->error('User is not from CZ.');
            return false;
        }

        Auth::loginUsingId($user->id, true);

        try {
            $vehicleArray = $this->autoSphereService->fetchAutoSphereVehicles();
        } catch (AutoSphereException $exception) {
            $this->error("Error while fetching data from AutoSphere. " . $exception->getMessage());

            return false;
        }

        $csvFile = $this->saveVehiclesToCsv($vehicleArray);

        $csvPath = config('carmarket.imports.used.cz.folders.import') . "/$csvFile";

        if (file_exists($csvPath)) {
            try {
                $source = [
                    'path' => $csvPath,
                    'file' => $csvFile,
                    'key' => ''
                ];

                $this->carUpload->startUpload($source, CarUploadService::SOURCE_FILE, CsvCzParser::class);
            } catch (CsvIOException $exception) {
                $this->info("File under name $csvFile and path $csvPath should exist. But is missing.");

                Log::error($exception);
            }

            $this->info("File under name $csvFile has been processed.");
        } else {
            $this->info("File under name $csvFile and path $csvPath should exist. But is missing.");
        }

    }

    /**
     * Save vehicles to CSV
     *
     * @param array $vehicleArray
     * @return string
     */
    private function saveVehiclesToCsv(array $vehicleArray)
    {
        $rand = 'autosphere_' . date('Ymd-his');
        $csvFile = "$rand.csv";

        Excel::store(new AutoSphereCzCsvExport($vehicleArray['cars']), "/exports/cz/$csvFile", 'local', \Maatwebsite\Excel\Excel::CSV);

        return $csvFile;
    }
}
