<?php

namespace App\Parsers;

use App\Contracts\File\ParserContract;
use App\Exceptions\CsvHeaderMissingException;
use App\Exceptions\CsvIOException;
use App\Service\CSVReader;
use App\StockVehicle;
use Carbon\Carbon;
use Spatie\SimpleExcel\SimpleExcelWriter;

class CsvDeParser implements ParserContract
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
        'SUPER' => 'Gasoline',
        'BENZIN' => 'Gasoline',
        'SUPER_PLUS' => 'Gasoline',
        'DIESEL' => 'Diesel',
    ];

    /**
     * @var array
     */
    private $gearBox = [
        1 => 'A',
        3 => 'M',
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
        'manufacturer_id' => 'fahrgestellnummer',
        'origin' => null,
        'brand' => 'marke',
        'model' => 'erw_modellbasis',
        'version_description' => null,
        'kw' => 'leistung',
        'cm3' => 'ccm',
        'hp' => null,
        'fuel_type' => null,
        'gearbox' => null,
        'km' => 'kilometer',
        'firstregistration' => null,
        'color_code' => null,
        'color_description' => 'farbe',
        'interior' => 'grundfarbe',
        'options_code' => null,
        'option_code_description' => 'bemerkung',
        'co2' => 'emission',
        'b2b_price_ex_vat' => 'haendlerpreis',
        'vat_deductible' => 'mwst',
        'damages_excl_vat_info' => null,
        'disponsibility' => null,
        'loading_place' => 'lagerort',
        'note' => null,
        'language_option_code_description' => null,
        'currency_iso_codification' => 'waehrung',
        'url_address' => null,
        'media_path' => null,
        'account_id' => 'filiale',
        'body_type' => 'kategorie',
        'sku_number' => null,
        'certification_code' => 'erw_modellschluessel',
        'condition_type' => null,
        'fuel_consumption_city' => null,
        'fuel_consumption_land' => null,
        'fuel_consumption_rating' => 'energieeffizienzklasse',
        'fuel_consumption_total' => null,
        'cylinders' => 'erw_zylinder',
        'coc' => null,
        'documents' => null,
        'doors' => 'tueren',
        'drive_type' => null,
        'has_warranty' => null,
        'id' => null,
        'model_group' => 'erw_modellbasis',
        'pollution_norm' => null,
        'price' => 'preis',
        'price_history' => null,
        'price_new' => 'erw_ehempreisempfehlunguvp',
        'properties' => null,
        'additional_properties' => null,
        'seats' => 'sitze',
        'segmentation_id' => null,
        'teaser' => null,
        'videos' => 'videourl',
        'weight' => 'gesamtgewicht',
        'vehicle_type' => null, //custom, pkwnfz
    ];

    /**
     * XmlNlParser constructor.
     */
    public function __construct()
    {
        $this->importFolder = config('carmarket.imports.used.de.folders.import');
        $this->processedFolder = config('carmarket.imports.used.de.folders.processed');
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
       //headers
        $headerColumns = array_values(StockVehicle::HEADER_COLUMNS);

        try {
            $reader = new CSVReader(['filename' => $pathName]);
            $dataArray = $reader->parseCsv();
        } catch (\Exception $exception) {
            throw new CsvIOException();
        }

        $csvHeaderColumns = $dataArray[0];

        foreach ($csvHeaderColumns as $headerColumn) {
            if (!is_string($headerColumn) || empty($headerColumn) || is_null($headerColumn)) {
                throw new CsvHeaderMissingException('CSV is missing header');
            }
        }

        unset($dataArray[0]);

        $csvHeaderArray = array_flip($csvHeaderColumns);

        $data = [];

        foreach ($dataArray as $key => $row) {
            $line = array_fill_keys($headerColumns, '');
            foreach ($this->columns as $column => $deColumn) {
                if ($deColumn) {
                    $key = $csvHeaderArray[$deColumn];

                    $value = $row[$key];
                } else {
                    switch ($column) {
                        case 'origin':
                            $value = 'DE';
                            break;
                        case 'version_description':
                            $keyFirst = $csvHeaderArray['erw_ausstattungslinie'];
                            $keySecond = $csvHeaderArray['erw_modelltexterw'];

                            $value = $row[$keyFirst] . ' / ' . $row[$keySecond];
                            break;
                        case 'hp':
                            $key = $csvHeaderArray['leistung'];

                            $value = round($row[$key] * 1.341);

                            break;
                        case 'fuel_type':
                            $key = $csvHeaderArray['kraftstoffname'];

                            $fuelType = $row[$key];

                            if (isset($this->fuelType[$fuelType])) {
                                $value = $this->fuelType[$fuelType];
                            } else {
                                $value = 'Gasoline';
                            }

                            break;
                        case 'gearbox':
                            $key = $csvHeaderArray['getriebeart'];

                            $gearBox = $row[$key];

                            if (isset($this->gearBox[$gearBox])) {
                                $value = $this->gearBox[$gearBox];
                            } else {
                                $value = 'A';
                            }

                            break;
                        case 'firstregistration':
                            $key = $csvHeaderArray['ez'];

                            $firstRegistration = $row[$key];

                            $firstRegistrationArray = explode('.', $firstRegistration);

                            if (isset($firstRegistrationArray[1])) {
                                $yearLength = strlen($firstRegistrationArray[1]);

                                if ($yearLength != 4) {
                                    $firstRegistrationArray[1] = $firstRegistrationArray[1] . '0';
                                }

                                $firstRegistrationCleanedString = implode('.', $firstRegistrationArray);

                                $carbonDate = Carbon::createFromFormat('d.m.Y', '01.' . $firstRegistrationCleanedString);

                                $unixTime = $carbonDate->timestamp;

                                $value = (int) ($unixTime / 86400) + 25569;
                            } else {
                                $value = null;
                            }

                            break;
                        case 'language_option_code_description':
                            $value = 0; //not english
                            break;
                        case 'media_path':
                            $value = null;

                            $key = $csvHeaderArray['internenummer'];

                            for ($i = 1; $i <= 100; $i++) {
                                $imgName = $row[$key] . "_0$i.jpg";

                                $imgPath = $this->importFolder . "/$imgName";

                                if (!file_exists($imgPath)) {
                                    break;
                                }

                                $value = $value . $imgName . ';';
                            }

                            break;
                        case 'sku_number':
                            $keyFirst = $csvHeaderArray['internenummer'];
                            $keySecond = $csvHeaderArray['kommissionsnummer'];

                            $value = $row[$keyFirst] . ' / ' . $row[$keySecond];

                            break;
                        case 'condition_type':
                            $key = $csvHeaderArray['nwgw'];

                            $conditionType = $row[$key];

                            if ($conditionType === 'GW') {
                                $value = 'used';
                            } elseif ($conditionType === 'NW') {
                                $value = 'new';
                            } else {
                                $value = 'used';
                            }

                            break;
                        case 'has_warranty':
                            $key = $csvHeaderArray['garantie'];

                            $hasWarranty = $row[$key];

                            if ($hasWarranty) {
                                $value = 1;
                            } else {
                                $value = 0;
                            }

                            break;
                        case 'pollution_norm':
                            $key = $csvHeaderArray['erw_schadstoffklassedetail'];

                            $pollutionNorm = $row[$key];

                            $pollutionInt = (int) filter_var($pollutionNorm, FILTER_SANITIZE_NUMBER_INT);

                            if ($pollutionInt) {
                                $pollutionNormArray = explode($pollutionInt, $pollutionNorm);

                                if (!isset($pollutionNormArray[1])) {
                                    $value = $this->pollutionNorm[$pollutionInt];
                                } else {
                                    $pollutionNormAddition = $pollutionNormArray[1];

                                    $pollutionNormAdditionArray = explode('_TEMP', $pollutionNormAddition);

                                    $key = $pollutionInt . $pollutionNormAdditionArray[0];

                                    $value = $this->pollutionNorm[$key];
                                }
                            } else {
                                $value = null;
                            }

                            break;
                        case 'id':
                            $key = $csvHeaderArray['internenummer'];

                            $id = $row[$key];

                            $value = "DE => $id";
                            break;
                        case 'vehicle_type':
                            $key = $csvHeaderArray['pkwnfz'];

                            $vehicleType = $row[$key];

                            if ($vehicleType === 'PKW') {
                                $value = 'Passenger';
                            } elseif ($vehicleType === 'NFZ') {
                                $value = 'LCV';
                            } else {
                                $value = 'Truck';
                            }

                            break;
                        case 'fuel_consumption_city':
                            $key = $csvHeaderArray['verbrauchinnerorts'];

                            $fuelConsumptionCity = $row[$key];

                            str_replace(',', '.', $fuelConsumptionCity);

                            $value = (float) $fuelConsumptionCity;

                            break;
                        case 'fuel_consumption_land':
                            $key = $csvHeaderArray['verbrauchausserorts'];

                            $fuelConsumptionLand = $row[$key];

                            str_replace(',', '.', $fuelConsumptionLand);

                            $value = (float) $fuelConsumptionLand;

                            break;
                        case 'fuel_consumption_total':
                            $key = $csvHeaderArray['verbrauchkombiniert'];

                            $fuelConsumptionTotal = $row[$key];

                            str_replace(',', '.', $fuelConsumptionTotal);

                            $value = (float) $fuelConsumptionTotal;

                            break;
                        default:
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
        $rand = $key . '_' . date('Ymd-his');
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
        rename($this->importFolder . '/' . $pathname, $this->processedFolder . '/' . date('Ymd-his'));
        return true;
    }
}
