<?php

namespace App\Parsers;

use App\Contracts\File\ParserContract;
use App\Exceptions\CsvHeaderMissingException;
use App\Exceptions\CsvIOException;
use App\Service\CSVReader;
use App\StockVehicle;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Carbon\Carbon;

class CsvCzParser implements ParserContract
{
    /**
     * @var string
     */
    private $importFolder;

    /**
     * @var string
     */
    private $processedFolder;

    /**
     * @var array
     */
    private $fuelType = [
        'benzin' => 'Gasoline',
        'nafta' => 'Diesel',
        'hybridní' => 'Hybrid'
    ];

    /**
     * @var array
     */
    private $pollutionNorm = [
        '0' => 'EURO0',
        '1' => 'EURO1',
        '2' => 'EURO2',
        '3' => 'EURO3',
        '4' => 'EURO4',
        '5' => 'EURO5',
        '6' => 'EURO6',
        '5A' => 'EURO5A',
        '5B' => 'EURO5B',
        '6A' => 'EURO6A',
        '6B' => 'EURO6B',
        '6C' => 'EURO6C',
        '6D' => 'EURO6D',
        '6+' => 'EURO6+',
    ];

    /**
     * @var array
     */
    protected $columns = [
        'manufacturer_id' => 'vin',
        'origin' => null,
        'brand' => 'manufacturer',
        'model' => 'model',
        'version_description' => null,
        'kw' => 'power',
        'cm3' => 'volume',
        'hp' => null,
        'fuel_type' => null,
        'gearbox' => null,
        'km' => null,
        'firstregistration' => null,
        'interior' => null,
        'color_code' => null,
        'color_description' => null,
        'options_code' => null,
        'option_code_description' => null,
        'co2' => null,
        'b2b_price_ex_vat' => 'price_without_VAT',
        'vat_deductible' => null,
        'damages_excl_vat_info' => null,
        'disponsibility' => null,
        'loading_place' => null,
        'note' => null,
        'language_option_code_description' => null,
        'currency_iso_codification' => null,
        'url_address' => 'url',
        'media_path' => null,
        'account_id' => null,
        'body_type' => 'body',
        'sku_number' => null,
        'certification_code' => null,
        'condition_type' => null,
        'fuel_consumption_city' => null,
        'fuel_consumption_land' => null,
        'fuel_consumption_rating' => null,
        'fuel_consumption_total' => null,
        'cylinders' => null,
        'coc' => null,
        'documents' => null,
        'doors' => 'doors',
        'drive_type' => 'drive',
        'has_warranty' => null,
        'id' => null,
        'model_group' => null,
        'pollution_norm' => null,
        'price' => 'price',
        'price_history' => null,
        'price_new' => null,
        'properties' => null,
        'additional_properties' => null,
        'seats' => 'places',
        'segmentation_id' => null,
        'teaser' => null,
        'videos' => null,
        'weight' => null,
        'vehicle_type' => null, //custom, pkwnfz
    ];

    /**
     * XmlNlParser constructor.
     */
    public function __construct()
    {
        $this->importFolder = config('carmarket.imports.used.cz.folders.import');
        $this->processedFolder = config('carmarket.imports.used.cz.folders.processed');
    }

    /**
     * Parse and map DE csv
     *
     * @param string $pathName
     * @param string $fileName
     * @param string $folderKey
     * @return mixed|string
     * @throws CsvHeaderMissingException
     * @throws CsvIOException
     */
    public function parse(string $pathName, string $fileName, string $folderKey)
    {
        $headerColumns = array_values(StockVehicle::HEADER_COLUMNS);

        try {
            $reader = new CSVReader([
                'filename' => $pathName,
                'fgetcsvOptions' => [
                    'length' => 0, 'delimiter' => ',', 'enclosure' => '"', 'escape' => "\\"
                ],
                'maxColumns' => 33
            ]);

            $dataArray = $reader->parseCsv();
        } catch (\Exception $exception) {
            throw new CsvIOException();
        }

        $csvHeaderColumns = $dataArray[0];

        $csvHeaderColumns = array_filter($csvHeaderColumns);

        foreach ($csvHeaderColumns as $headerColumn) {
            if (!is_string($headerColumn) || empty($headerColumn) || is_null($headerColumn)) {
                throw new CsvHeaderMissingException('CSV is missing header');
            }
        }

        unset($dataArray[0]);

        $csvHeaderArray = array_flip($csvHeaderColumns);

        $data = [];

        foreach ($dataArray as $rowKey => $row) {
            $line = array_fill_keys($headerColumns, '');
            foreach ($this->columns as $column => $czColumn) {
                if ($czColumn) {
                    try {
                        $key = $csvHeaderArray[$czColumn];

                        $value = $row[$key];
                    } catch (\Exception $exception) {
                        continue 2;
                    }
                } else {
                    switch ($column) {
                        case 'currency_iso_codification':
                            $value = 'CZK';
                            break;
                        case 'origin':
                            $value = 'CZ';
                            break;
                        case 'vat_deductible':
                            $vdKey = $csvHeaderArray['vat_deductible'];
                            $vdValue = $row[$vdKey];

                            if ($vdValue) {
                                $value = $vdValue;
                            } else {
                                $value = 0;
                            }

                            break;
                        case 'has_warranty':
                            $hwKey = $csvHeaderArray['has_warranty'];
                            $hwValue = $row[$hwKey];

                            if ($hwValue) {
                                $value = 1;
                            } else {
                                $value = 0;
                            }

                            break;
                        case 'hp':
                            $kwKey = $csvHeaderArray['power'];
                            $kwValue = $row[$kwKey];

                            if (is_numeric($kwValue)) {
                                $value = round($kwValue * 1.341);
                            } else {
                                $value = null;
                            }

                            break;
                        case 'gearbox':
                            $gearboxKey = $csvHeaderArray['transmission'];
                            $gearboxValue = $row[$gearboxKey];

                            if ($gearboxValue === 'automatická převodovka') {
                                $value = 'A';
                                break;
                            }

                            $value = 'M';
                            break;
                        case 'fuel_type':
                            $fuelKey = $csvHeaderArray['fuel'];
                            $fuelValue = $row[$fuelKey];

                            if (isset($this->fuelType[$fuelValue])) {
                                $this->fuelType[$fuelValue];
                                $value = 'Gasoline';
                                break;
                            }

                            $value = 'Gasoline';
                            break;
                        case 'firstregistration':
                            $monthKey = $csvHeaderArray['month'];
                            $yearKey = $csvHeaderArray['year'];

                            $month = $row[$monthKey];
                            $year = $row[$yearKey];

                            if (!$month) {
                                $value = "01/01/$year";
                            } else {
                                $month = (int) $month;

                                if ($month < 10) {
                                    $value = "01/0$month/$year";
                                } else {
                                    $value = "01/$month/$year";
                                }
                            }

                            try {
                                $carbonDate = Carbon::createFromFormat('d/m/Y', $value);
                                $unixTime = $carbonDate->timestamp;

                                $value = (int) ($unixTime / 86400) + 25569;
                            } catch (\Exception $exception) {
                                $value = '';
                            }

                            break;
                        case 'language_option_code_description':
                            $value = 0; //not english
                            break;
                        case 'condition_type':
                            $stateKey = $csvHeaderArray['car_state'];

                            $stateCode = $row[$stateKey];

                            if ($stateCode == 0) {
                                $value = 'used';
                                break;
                            }

                            $value = 'new';

                            break;
                        case 'id':
                            $key = $csvHeaderArray['id'];

                            $value = $row[$key];

                            $value = "CZ => $value";
                            break;
                        case 'vehicle_type':
                            $categoryKey = $csvHeaderArray['category'];

                            $categoryCode = $row[$categoryKey];

                            if ($categoryCode == 'A') {
                                $value = 'Passenger';
                                break;
                            }

                            $value = 'LCV';

                            break;
                        default:
                            if (isset($csvHeaderArray[$column])) {
                                $columnKey = $csvHeaderArray[$column];

                                $value = $row[$columnKey];
                                break;
                            }

                            $value = null;
                            break;
                    }
                }

                if (isset($line[$column])) {
                    $line[$column] = $value;
                }
            }

            $data[] = $line;
        }

        $xlsxFile = $this->writeXlsxToDisk($data, $folderKey);

        $this->moveToProcessed($folderKey, $fileName);

        return $xlsxFile;
    }

    /**
     * Write XLSX file to disk
     *
     * @param array $data
     * @param string $key
     * @return string
     */
    private function writeXlsxToDisk(array $data, string $key)
    {
        $rand = 'cz' . '_' . date('Ymd-his');
        $xlsxFile = "$rand.xlsx";
        SimpleExcelWriter::create(storage_path("app/public/{$xlsxFile}"))->addRows($data);
        return $xlsxFile;
    }

    /**
     * Move uploaded file to processed
     *
     * @param  string  $pathname
     * @return bool
     */
    private function moveToProcessed(string $folderKey, string $pathname)
    {
        rename($this->importFolder . '/' . $pathname, $this->processedFolder . '/' . date('Ymd-his') . '.csv');
        return true;
    }
}
