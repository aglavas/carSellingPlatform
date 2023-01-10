<?php

namespace App\Service;

use Carbon\Carbon;

class DataNormalizer
{
    /**
     * Normalize data row
     *
     * @param array $data
     * @param bool $isoTime
     * @return array|mixed
     * @throws \Exception
     */
    public static function normalize(array $data, bool $isoTime = false)
    {
        $dataKeys = array_keys($data);

        $dataKeys = array_filter($dataKeys);

        $data = remove_excel_formulas($data);

        foreach ($dataKeys as $key) {
            $data[$key] = trim($data[$key]);

            $data[$key] = self::handleSpecialCases($data[$key], $key, $isoTime);
        }

        return $data;
    }

    /**
     * Additional normalization rules
     *
     * @param string $fieldValue
     * @param string $key
     * @param bool $isoTime
     * @return mixed|string|string[]|null
     */
    private static function handleSpecialCases(string $fieldValue, string $key, bool $isoTime = false)
    {
        switch ($key) {
            case "origin":
                $fieldValue = str_replace(' ', '', $fieldValue);
                $fieldValue = preg_replace("/[^a-zA-Z]/", "", $fieldValue);  //Only Alpha
                $fieldValue = strtoupper($fieldValue);
                break;
            case "brand":
                $fieldValue = unified_brand($fieldValue);
                break;
            case "model":
                $fieldValue = strtoupper((string) $fieldValue);
                break;
            case "version_description":
                $fieldValue = strtoupper((string) $fieldValue);
                break;
            case "version_code":
                $fieldValue = strtoupper((string) $fieldValue);
                break;
            case "fuel_type":
                $fieldValue = str_replace(' ', '', $fieldValue);
                $fieldValue = preg_replace("/[^a-zA-Z\(\)]/", "", $fieldValue); //Only Alpha and (, )
                $fieldValue = ucfirst($fieldValue);
                break;
            case "gearbox":
                $fieldValue = str_replace(' ', '', $fieldValue);
                $fieldValue = preg_replace("/[^a-zA-Z0-9]/", "", $fieldValue);  //Only Alpha-Num
                $fieldValue = strtoupper($fieldValue);

                if ($fieldValue === 'AUTOMATIC' || $fieldValue === 'A' || (int) $fieldValue === 1) {
                    $fieldValue = 'A';
                } elseif ($fieldValue === 'MANUAL' || $fieldValue === 'M' || (int) $fieldValue === 0) {
                    $fieldValue = 'M';
                }
                break;
            case "km":
                $fieldValue = preg_replace("/[^0-9]/", "", $fieldValue); //Only Num
                if ($fieldValue) {
                    $fieldValue = (int) $fieldValue;
                } else {
                    $fieldValue = null;
                }
                break;
            case "co2":
                $fieldValue = preg_replace("/[^0-9]/", "", $fieldValue); //Only Num
                if ($fieldValue) {
                    $fieldValue = (int) $fieldValue;
                } else {
                    $fieldValue = null;
                }
                break;
            case "cm3":
                $fieldValue = preg_replace("/[^0-9]/", "", $fieldValue); //Only Num
                if ($fieldValue) {
                    $fieldValue = (int) $fieldValue;
                } else {
                    $fieldValue = null;
                }
                break;
            case "kw":
                $fieldValue = preg_replace("/[^0-9]/", "", $fieldValue); //Only Num
                if ($fieldValue) {
                    $fieldValue = (int) $fieldValue;
                } else {
                    $fieldValue = null;
                }
                break;
            case "hp":
                $fieldValue = preg_replace("/[^0-9]/", "", $fieldValue); //Only Num
                if ($fieldValue) {
                    $fieldValue = (int) $fieldValue;
                } else {
                    $fieldValue = null;
                }
                break;
            case "firstregistration":
                if ($isoTime) {
                    $carbonDate = Carbon::createFromFormat('m/d/Y', $fieldValue);
                    $unixTime = $carbonDate->timestamp;

                    $fieldValue = (int) ($unixTime / 86400) + 25569;
                } else {
                    $fieldValue = (int) $fieldValue;
                }
                break;
            case "b2b_price_ex_vat":
                $fieldValue = number_format((float) $fieldValue, 2, '.', '');
                break;
            case "disponsibility":
                if ($isoTime) {
                    $carbonDate = Carbon::createFromFormat('m/d/Y', $fieldValue);
                    $unixTime = $carbonDate->timestamp;

                    $fieldValue = (int) ($unixTime / 86400) + 25569;
                } else {
                    $fieldValue = (int) $fieldValue;
                }
                break;
            case "currency_iso_codification":
                $fieldValue = str_replace(' ', '', $fieldValue);
                $fieldValue = preg_replace("/[^a-zA-Z]/", "", $fieldValue);  //Only Alpha
                $fieldValue = ucfirst($fieldValue);
                break;
            case "account_id":
                $fieldValue = str_replace(' ', '', $fieldValue);
                $fieldValue = preg_replace("/[^a-zA-Z0-9]/", "", $fieldValue);  //Only Alpha-Num
                break;
            case "body_type":
                $fieldValue = str_replace(' ', '', $fieldValue);
                $fieldValue = preg_replace("/[^a-zA-Z]/", "", $fieldValue);  //Only Alpha
                $fieldValue = strtolower($fieldValue);
                break;
            case "condition_type":
                $fieldValue = str_replace(' ', '', $fieldValue);
                $fieldValue = preg_replace("/[^a-zA-Z_]/", "", $fieldValue);  //Only Alpha and _ sign
                $fieldValue = strtolower($fieldValue);
                break;
            case "cylinders":
                $fieldValue = preg_replace("/[^0-9]/", "", $fieldValue); //Only Num
                if ($fieldValue) {
                    $fieldValue = (int) $fieldValue;
                } else {
                    $fieldValue = null;
                }
                break;
            case "doors":
                $fieldValue = preg_replace("/[^0-9]/", "", $fieldValue); //Only Num
                if ($fieldValue) {
                    $fieldValue = (int) $fieldValue;
                } else {
                    $fieldValue = null;
                }
                break;
            case "model_group":
                $fieldValue = strtoupper((string) $fieldValue);
                break;
            case "price":
                $fieldValue = number_format((float) $fieldValue, 2, '.', '');
                break;
            case "price_new":
                $fieldValue = number_format((float) $fieldValue, 2, '.', '');
                break;
            case "seats":
                $fieldValue = preg_replace("/[^0-9]/", "", $fieldValue); //Only Num

                if ($fieldValue) {
                    $fieldValue = (int) $fieldValue;
                } else {
                    $fieldValue = null;
                }
                break;
            case "pollution_norm":
                $fieldValue = str_replace(' ', '', $fieldValue);
                $fieldValue = preg_replace("/[^a-zA-Z0-9+]/", "", $fieldValue); //Only Alpha-Num and + sign
                $fieldValue = strtoupper($fieldValue);
                break;
            case "weight":
                $fieldValue = preg_replace("/[^0-9]/", "", $fieldValue); //Only Num

                if ($fieldValue) {
                    $fieldValue = (int) $fieldValue;
                } else {
                    $fieldValue = null;
                }
                break;
            case "vehicle_type":
                $fieldValue = str_replace(' ', '', $fieldValue);
                $fieldValue = preg_replace("/[^a-zA-Z]/", "", $fieldValue);  //Only Alpha
                $fieldValue = ucfirst($fieldValue);
                break;
        }

        return $fieldValue;
    }
}
