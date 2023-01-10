<?php

namespace App\Service;

use App\Contracts\File\ParserContract as FileParserContract;
use App\Contracts\Json\ParserContract as JsonParserContract;
use App\Exceptions\BrandMappingException;
use App\Exceptions\ImportColumnMissingException;
use App\Imports\StockVehicleImport;
use App\Imports\Json\StockVehicleImport as JsonStockVehicleImport;
use App\StockListUpload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class CarUploadService
{
    const SOURCE_JSON = 'json';
    const SOURCE_FILE = 'file';
    const LIST_TYPE_USED_CARS = 'used_cars';
    const LIST_TYPE_OPEL = 'opel';

    /**
     * @var ImportValidationService
     */
    public $importValidationService;

    /**
     * @var StockListUpload
     */
    public $stockList;

    /**
     * CarUploadService constructor.
     * @param ImportValidationService $importValidationService
     * @param StockListUpload $stockListUpload
     */
    public function __construct(ImportValidationService $importValidationService, StockListUpload $stockListUpload)
    {
        $this->importValidationService = $importValidationService;
        $this->stockList = $stockListUpload;
    }

    /**
     * Start car upload
     *
     * @param $data
     * @param string $source
     * @param string|null $parser
     * @return array|bool|string
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function startUpload($data, string $source, string $parser = null)
    {
        if ($source == self::SOURCE_JSON) {
            if ($parser) {
                /** @var JsonParserContract $parserClass */
                $parserClass = App::make($parser);

                $data = $parserClass->parse($data);
            }

            $data = DataNormalizer::normalize($data, true);

            $result = $this->importValidationService->validateImportData($data);

            if (is_array($result)) {
                return $result;
            }

            $exchangeService = new ExchangeService();

            /** @var Model $resource */
            $importClassInstance = new JsonStockVehicleImport($exchangeService);

            try {
                $importClassInstance->import($data);
            } catch (\Exception $exception) { //@todo
                if ($exception instanceof BrandMappingException) {
                    $message = $exception->getMessage();

                    return "Brand $message cannot be mapped.";
                } elseif ($exception instanceof ImportColumnMissingException) {
                    $message = $exception->getMessage();

                    return "Field is missing from the request: $message ";
                }

                throw $exception;
            }

            return true;
        } else {
            $importClass = StockVehicleImport::class;

            if ($parser) {
                /** @var FileParserContract $parserClass */
                $parserClass = App::make($parser);

                try {
                    $csvFilePath = $parserClass->parse($data['path'], $data['file'], $data['key']);
                } catch (\Exception $exception) {
                    activity('parsing_error')
                        ->withProperties($exception)
                        ->log($parser);

                    throw new \Exception("CSV parsing error");
                }

                $stockListUpload = new StockListUpload();

                $user = Auth::user();

                $stockListUpload->create([
                    'file_path' => $csvFilePath,
                    'list_type' => $importClass,
                    'automatic' => true,
                    'country' => strtoupper($user->country)
                ]);

                return true;
            }

            $stockListUpload = $this->processFileUpload($data, $importClass);

            $stockListUploadResult = $this->stockList->find($stockListUpload->id);

            if ($stockListUploadResult->status === '1') {
                return true;
            }

            return ['status' => $stockListUploadResult->status, 'error_code' => $stockListUploadResult->error_code_response];
        }
    }

    /**
     * Process file upload
     *
     * @param $source
     * @param string $importClassNamespace
     * @return mixed
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    private function processFileUpload($source, string $importClassNamespace)
    {
        if ($source instanceof Request) {
            $request = $source;

            $md5Name = md5_file($request->file('file')->getRealPath()) . ".xlsx";

            /** @var $file \Illuminate\Http\UploadedFile **/
            $request->file('file')->storeAs('public', $md5Name);

            // If the submitted file is a CSV, automatically convert it to a XLSX file
            if ($request->file('file')->getClientMimeType() === 'text/csv') {
                $reader = IOFactory::createReader('Csv');
                $objPHPExcel = $reader->load(Storage::disk('public')->path($md5Name));
                $objWriter = IOFactory::createWriter($objPHPExcel, 'Xlsx');
                $objWriter->save(Storage::disk('public')->path($md5Name));
            }
        } else {
            $md5Name = $source;
        }

        $user = Auth::user();

        $country = $user->country;

        $stockListUpload = $this->stockList->create([
            'country' => $country,
            'file_path' => $md5Name,
            'list_type' => $importClassNamespace,
            'status' => 'processing',
            'uploader_id' => $user->id
        ]);

        return $stockListUpload;
    }
}
