<?php

namespace App\Parsers;

use App\Contracts\File\ParserContract;
use App\Exceptions\XmlIOException;
use App\StockVehicle;
use Carbon\Carbon;
use Spatie\SimpleExcel\SimpleExcelWriter;

class XmlNlParser implements ParserContract
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
        'B' => 'Gasoline',
        'D' => 'Diesel',
        'H' => 'Hybrid',
        'E' => 'Electric',
        'L' => 'LPG',
        'O' => 'Other Fuels',
        'A' => 'Alcohol',
        'C' => 'Cryogenic',
        'W' => 'Waterstof'
    ];

    /**
     * @var array
     */
    private $gearBox = [
        'A' => 'A',
        'M' => 'M',
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
        'origin' => null, //custom
        'brand' => 'merk',
        'model' => 'model',
        'version_description' => 'type',
//        'kw' => 'vermogen_motor_kw',
        'kw' => null,
//        'cm3' => 'cilinder_inhoud',
        'cm3' => null,
//        'hp' => 'vermogen_motor_pk',
        'hp' => null,
        'fuel_type' => null, //brandstof key, custom
        'gearbox' => null, //transmissie
        'km' => 'tellerstand',
        //'firstregistration' => 'datum_deel_1',
        'firstregistration' => null,
        'color_code' => null,
        'color_description' => null,
        'interior' => 'interieurkleur',
        'options_code' => null,
        'option_code_description' => null,
        'co2' => 'co2_uitstoot',
        'b2b_price_ex_vat' => 'verkoopprijs_particulier',
        'vat_deductible' => 'btw_marge',
        'damages_excl_vat_info' => 'schadevoertuig',
        'disponsibility' => 'datum_binnenkomst',
        'loading_place' => null,
        'note' => 'opmerkingen',
        'language_option_code_description' => null,
        'currency_iso_codification' => 'munteenheid',
        'url_address' => 'directe_link',
        'media_path' => null,
        'account_id' => 'klantnummer',
        'body_type' => 'carrosserie',
        'sku_number' => 'voertuignr',
        'certification_code' => 'typenummer',
        'condition_type' => null,
        'fuel_consumption_city' => 'verbruik_stad',
        'fuel_consumption_land' => 'verbruik_snelweg',
        'fuel_consumption_rating' => 'energielabel',
        'fuel_consumption_total' => 'gemiddeld_verbruik',
        'cylinders' => 'cilinder_aantal',
        'coc' => null,
        'documents' => 'documenten',
        'doors' => 'aantal_deuren',
        'drive_type' => 'aandrijving',
        'has_warranty' => null,
        'id' => null,
        'model_group' => 'model_orig',
        'pollution_norm' => null,
        'price' => null,
        'price_history' => null,
        'price_new' => 'nieuwprijs',
        'properties' => null,
        'additional_properties' => null,
        'seats' => 'aantal_zitplaatsen',
        'segmentation_id' => null,
        'teaser' => null,
        'videos' => 'videos',
//        'weight' => 'gvw',
        'weight' => null,
        'vehicle_type' => null,
    ];

    /**
     * XmlNlParser constructor.
     */
    public function __construct()
    {
        $this->importFolder = config('carmarket.imports.used.nl.folders.import');
        $this->processedFolder = config('carmarket.imports.used.nl.folders.processed');
    }

    /**
     * Convert XML to CSV
     *
     * @param string $pathName
     * @param string $fileName
     * @param string $folderKey
     * @return bool
     * @throws XmlIOException
     */
    public function parse(string $pathName, string $fileName, string $folderKey)
    {
        //headers
        $headerColumns = array_values(StockVehicle::HEADER_COLUMNS);

        try {
            $xml = simplexml_load_file($pathName);
        } catch (\Exception $exception) {
            throw new XmlIOException();
        }

        $data = [];

        foreach ($xml as $globalHeader => $xmlValue) {
            $line = array_fill_keys($headerColumns, '');
            foreach ($this->columns as $column => $nlColumn) {
                if ($nlColumn) {
                    $value = (string)$xmlValue->$nlColumn;
                } else {
                    switch ($column) {
                        case 'origin':
                            $value = 'NL';

                            break;
                        case 'fuel_type':
                            $fuelType = (string)$xmlValue->brandstof;

                            if (isset($this->fuelType[$fuelType])) {
                                $value = $this->fuelType[$fuelType];
                            } else {
                                $value = 'Gasoline';
                            }

                            break;
                        case 'gearbox':
                            $gearBox = (string)$xmlValue->transmissie;

                            if (isset($this->gearBox[$gearBox])) {
                                $value = $this->gearBox[$gearBox];
                            } else {
                                $value = 'A';
                            }

                            break;
                        case 'color_description':
                            $color = (string)$xmlValue->kleur;
                            $baseColor = (string)$xmlValue->basiskleur;

                            $value = $color . "($baseColor)";
                            break;
                        case 'options_code':
                            $value = null;

                            foreach ($xmlValue->accessoires as $accessories) {
                                foreach ($accessories as $option) {
                                    if ($option->code) {
                                        $value = $value . (string) $option->code . ', ';
                                    }
                                }
                            }

                            $value = substr($value, 0, -2);
                            break;
                        case 'option_code_description':
                            $value = null;

                            foreach ($xmlValue->accessoires_engels as $accessories) {
                                foreach ($accessories as $item) {
                                    $value = $value . (string) $item->naam . ' ';
                                }
                            }

                            $value = substr($value, 0, -2);
                            break;
                        case 'language_option_code_description':
                            $value = 1;
                            break;
                        case 'media_path':
                            $value = null;

                            foreach ($xmlValue->afbeeldingen as $media) {
                                foreach ($media as $item) {
                                    $value = $value . (string) $item->bestandsnaam . ';';
                                }
                            }
                            break;
                        case 'condition_type':
                            $value = 'used';
                            break;
                        case 'has_warranty':
                            $nlValue = (string)$xmlValue->cargarantie;

                            if ($nlValue == 'n') {
                                $value = 0;
                            } elseif ($nlValue == 'y') {
                                $value = 1;
                            } else {
                                $value = $nlValue;
                            }
                            break;
                        case 'id':  //emissieklasse
                            $id = (string)$xmlValue->voertuignr_hexon;

                            $value = "Nl => $id";
                            break;
                        case 'pollution_norm':
                            $nlValue = (string)$xmlValue->emissieklasse;

                            if (isset($this->pollutionNorm[$nlValue])) {
                                $value = $this->pollutionNorm[$nlValue];
                            } else {
                                $value = 'EURO1';
                            }

                            break;
                        case 'vehicle_type':
                            $value = 'Passenger';
                            break;
                        case 'co2':
                            $value = (int) $xmlValue->co2_uitstoot;
                            break;
                        case 'hp':
                            $value = (int) $xmlValue->vermogen_motor_pk;
                            break;
                        case 'kw':
                            $value = (int) $xmlValue->vermogen_motor_kw;
                            break;
                        case 'cm3':
                            $value = (int) $xmlValue->cilinder_inhoud;
                            break;
                        case 'weight':
                            $value = (int) $xmlValue->gvw;
                            break;
                        case 'firstregistration':
                            $value = (string) $xmlValue->datum_deel_1;

                            if ($value) {
                                $carbonTime = Carbon::createFromFormat('d-m-Y', $value);

                                $unixTime = $carbonTime->timestamp;

                                $value = (int) ($unixTime / 86400) + 25569;
                            } else {
                                $value = null;
                            }

                            break;
                        case 'loading_place':
                            $value = config('carmarket.imports.used.nl.mappings')[(string)$xmlValue->klantnummer]['locatie_voertuig'];
                            break;

                        default:
                            $value = '';
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
     * @param array $csv
     * @param string $key
     * @return string
     */
    private function writeXlsxToDisk(array $csv, string $key)
    {
        $rand = $key . '_' . date('Ymd-his');
        $xlsxFile = "$rand.xlsx";
        SimpleExcelWriter::create(storage_path("app/public/{$xlsxFile}"))->addRows($csv);
        return $xlsxFile;
    }

    /**
     * Move uploaded file to processed
     *
     * @param string $folderKey
     * @param string $pathname
     * @return bool
     */
    private function moveToProcessed(string $folderKey, string $pathname)
    {
        rename($this->importFolder . "/{$folderKey}/" . $pathname, $this->processedFolder . "/{$folderKey}_" . date('Ymd-his'));
        return true;
    }
}
