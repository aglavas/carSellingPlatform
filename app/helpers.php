<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

if (!function_exists('static_image_carmarket')) {
    /**
     * @param string $url
     *
     * @return string
     */
    function static_image_carmarket($url)
    {
//        if (!$url) {
//            return null;
//        }
//
//        $appUrl = env('APP_URL', null);
//
//        if (strpos($url, $appUrl) == false) {
//            return app('static-image-cache')->getUrl($url);
//        }

        return $url;
    }
}


if (!function_exists('convert_country')) {
    function convert_country($country)
    {
        try {
            return convert_country_to_iso3166($country);
        } catch (\Exception $exception) {
            try {
                $testCountry = convert_iso3166_to_country($country);

                return strtolower($country);
            } catch (\Exception $exception) {
                throw new Exception('Country ' . $country . ' cannot be mapped.');
            }
        }
    }
}
if (!function_exists('convert_country_to_iso3166')) {
    function convert_country_to_iso3166($country)
    {
        switch ($country) {
            case 'Albania':
                return 'al';
                break;
            case 'Belgium':
                return 'be';
                break;
            case 'Bosnia and Herzegovina':
                return 'ba';
                break;
            case 'Czech Republic':
                return 'cz';
                break;
            case 'Montenegro':
                return 'me';
                break;
            case 'Slovakia':
                return 'sk';
                break;
            case 'Slovenia':
                return 'si';
                break;
            case 'Hungary':
                return 'hu';
                break;
            case 'Croatia':
                return 'hr';
                break;
            case 'R.Serbia':
            case 'rs':
                return 'rs';
                break;
            case 'Switzerland':
                return 'ch';
                break;
            case 'France':
                return 'fr';
                break;
            case 'Netherlands':
                return 'nl';
                break;
            case 'Germany':
                return 'de';
                break;
            case 'Poland':
                return 'pl';
                break;
        }
        throw new Exception('Country ' . $country . ' cannot be mapped.');
    }
}
if (!function_exists('convert_iso3166_to_country')) {
    function convert_iso3166_to_country($country)
    {
        switch ($country) {
            case 'al':
            case 'AL':
                return 'Albania';
                break;
            case 'be':
            case 'BE':
                return 'Belgium';
                break;
            case 'ba':
            case 'BA':
                return 'Bosnia and Herzegovina';
                break;
            case 'me':
            case 'ME':
                return 'Montenegro';
                break;
            case 'cz':
            case 'CZ':
                return 'Czech Republic';
                break;
            case 'sk':
            case 'SK':
                return 'Slovakia';
                break;
            case 'si':
            case 'SI':
                return 'Slovenia';
                break;
            case 'hu':
            case 'HU':
                return 'Hungary';
                break;
            case 'hr':
            case 'HR':
                return 'Croatia';
                break;
            case 'rs':
            case 'RS':
                return 'R.Serbia';
                break;
            case 'ch':
            case 'CH':
                return 'Switzerland';
                break;
            case 'fr':
            case 'FR':
                return 'France';
                break;
            case 'nl':
            case 'NL':
                return 'Netherlands';
                break;
            case 'de':
            case 'DE':
                return 'Germany';
                break;
            case 'pl':
            case'PL':
                return 'Poland';
                break;
        }
        throw new Exception('Country ' . $country . ' cannot be mapped.');
    }
}

if (!function_exists('convert_to_excel_dates_to_date')) {
    function convert_to_excel_dates_to_date($date)
    {
        if (is_integer($date)) {
            return date('c', ($date - 25569) * 86400);
        }
        if (preg_match('/^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4}$/', $date) === 1) {
            return Carbon::createFromFormat('d/m/Y', $date);
        }
        if (preg_match('/^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{2}$/', $date) === 1) {
            return Carbon::createFromFormat('d/m/y', $date);
        }
        if (preg_match('/^[0-9]{1,2}\.[0-9]{1,2}\.[0-9]{4}$/', $date) === 1) {
            return Carbon::createFromFormat('d.m.Y', $date);
        }
        if (preg_match('/^[0-9]{1,2}\.[0-9]{1,2}\.[0-9]{2}$/', $date) === 1) {
            return Carbon::createFromFormat('d.m.y', $date);
        }
        if (preg_match('/^(\d{2})-(\d{2})-(\d{4})$/', $date) === 1) {
            return Carbon::createFromFormat('d-m-Y', $date);
        }
        if (is_null($date) || trim($date) == '' || $date == 'NULL') {
            return null;
        }
        throw new Exception("Date '" . $date . "' cannot be converted. Please check that the format is correct.");
    }
}

if (!function_exists('select_options_for')) {
    function select_options_for($model, $column)
    {
        return $model::select($column)->groupBy($column)->get()->pluck($column, $column)->sort()->filter()->toArray();
    }
}

if (!function_exists('google_translate')) {
    function google_translate($content, $to = 'en')
    {
        try {
            if (trim($content)) {
                $contentHash = md5($content);
                $translation = \App\Translation::where('content_hash', $contentHash)->first();
                if (is_null($translation)) {
                    $translatedContent = \Illuminate\Support\Facades\Http::post('https://translation.googleapis.com/language/translate/v2?key=' . config('carmarket.google_translate_api_key'),
                        [
                            'q' => $content,
                            'target' => $to,
                        ])->json();

                    if (isset($translatedContent['error'])) {
                        activity('google_translate_error')
                            ->withProperties($translatedContent)
                            ->log('Translation error failed.');
                    } else {
                        $translatedContent = $translatedContent['data']['translations'][0]['translatedText'];
                    }
                    
                    //['data']['translations'][0]['translatedText'];
                    $translation = \App\Translation::create([
                        'content_hash' => $contentHash,
                        'target_language' => $to,
                        'content' => $content,
                        'translated_content' => $translatedContent
                    ]);
                }
                return $translation->translated_content;
            }
        } catch (Exception $exception) {
            activity('google_translate')
                ->withProperties($exception)
                ->log('Translation failed.');
            return 'Translation failed.';
        }
    }
}

if (!function_exists('unified_brand')) {
    function unified_brand($brand)
    {
        $transliterator = Transliterator::createFromRules(':: NFD; :: [:Nonspacing Mark:] Remove; :: NFC;', Transliterator::FORWARD);
        $brand = strtoupper(trim($transliterator->transliterate($brand)));
        switch ($brand) {
            case 'MERCEDES-BENZ':
            case 'MERCEDES BENZ':
                $brand = 'MERCEDES';
                break;
            case 'FIAT PROFESSIONAL':
                $brand = 'FIAT';
                break;
            case 'VOLKSWAGEN':
                $brand = 'VW';
                break;
            case 'DS ATOMOBILI':
            case 'DS ATOMOBILES':
                $brand = 'DS';
                break;
            case 'ALFA':
                $brand = 'ALFA ROMEO';
                break;
        }
        return $brand;
    }
}

if (!function_exists('unified_fuel_type')) {
    function unified_fuel_type($fuel_type)
    {
        $fuel_type = preg_replace('/[^A-z \-]/i', '', iconv("UTF-8", "US-ASCII//TRANSLIT", strtoupper(trim($fuel_type))));
        switch ($fuel_type) {
            case 'GASOLINE':
            case 'BENZIN':
            case 'BENZINE':
                $fuel_type = 'PETROL';
                break;
            case 'D':
                $fuel_type = 'DIESEL';
                break;
        }
        return $fuel_type;
    }
}

if (!function_exists('get_contacts_of_new_car')) {
    function get_contacts_of_new_car($country, $brand)
    {
        $country = strtoupper($country);

        $logisticUsers = Cache::remember('logistic_users', 60, function () {
            return \App\User::with('brands')->role('Logistics')->get();
        });
        return $logisticUsers
            ->filter(function($user) use ($country) {
                return strtoupper($user->country) === strtoupper($country) || $user->show_contact_on_all_cars;
            })
            ->filter(function($user) use($brand) {
                return $user->brands->where('id', $brand)->count() > 0 || $user->show_contact_on_all_cars;
            })
            ->sortBy('show_contact_on_all_cars');
    }
}

if (!function_exists('remove_excel_formulas')) {
    function remove_excel_formulas($row)
    {
        foreach ($row as $key => &$value) {
            if (substr($value, 0, 1) === '=') {
                $value = substr($value, 1);
            }
        }
        return $row;
    }
}

if (!function_exists('get_contacts_of_used_car')) {
    function get_contacts_of_used_car($vehicle)
    {
        $company = $vehicle->company;
        return \App\User::role('Buyer')
            ->where('country', 'ilike', strtoupper($vehicle->country) ?? '')
            ->where('stock_type', 'UC')
            ->orWhere('show_contact_on_all_cars', true)
            ->orderBy('name', 'ASC')
            ->get()
            ->filter(function($item) use ($company) {
                if ($item->company) {
                    return $item->company->name === $company || $item->show_contact_on_all_cars;
                } else {
                    return $item->show_contact_on_all_cars;
                }
            })
            ->sortBy('show_contact_on_all_cars');
    }
}

if (!function_exists('get_enquiry_contacts_for_used_cars')) {
    function get_enquiry_contacts_for_used_cars($vehicle, $vehicleType = null)
    {
        if ($vehicleType) {
            $vehicle = (new $vehicleType())::find($vehicle);
        }
        $company = $vehicle->company;
        return \App\User::role('Logistics')
            ->where('country', 'ilike', strtoupper($vehicle->country) ?? '')
            ->where('stock_type', 'UC')
            ->orderBy('name', 'ASC')
            ->get()
            ->filter(function($item) use ($company) {
                if ($item->company) {
                    return $item->company->name === $company;
                }
                return false;
            });
    }
}

if (!function_exists('generate_range')) {
    function generate_range($start, $end)
    {
        if (($start instanceof Carbon) && ($end instanceof Carbon)) {
            $years = range($start->format('Y'), $end->format('Y'));

            $options = [];

            foreach ($years as $year) {
                $options[$year] = $year;
            }
        } else {
            $options = [];

            $start = ceil($start / 10000) * 10000;

            if (($end - $start) < 10000) {
                $end = $start + 10000;
            }

            foreach (range($start, $end, 10000) as $value) {
                $options[] = intval($value);
            }

            if (count($options) > 2) {
                $options[] = $end;
            }
        }

        return $options;
    }
}

if (!function_exists('format_filter_label')) {
    function format_filter_label($label)
    {
        if ($label === 'brand_id') {
            return 'Brand';
        } elseif ($label === 'firstregistration') {
            return 'First Registration';
        }

        $labelExplodedArray = explode('_', $label);

        $labelExplodedArray = array_map('ucfirst', $labelExplodedArray);

        if (count($labelExplodedArray) == 1) {
            return $labelExplodedArray[0];
        }

        $label = implode(' ', $labelExplodedArray);

        return $label;
    }
}

if (!function_exists('sort_field')) {
    function sort_field($field, $column, $direction)
    {
        if ($field === $column) {
            return $direction;
        }

        return null;

    }
}

if (!function_exists('carmarket_price_format')) {
    function carmarket_price_format($value)
    {
        if (empty($value)) {
            return null;
        }

        return number_format($value, 2);
    }
}

if (!function_exists('carmarket_price_display_format')) {
    function carmarket_price_display_format($value)
    {
        if (empty($value) || is_null($value) || ($value == 0)) {
            return 'Not disclosed';
        }

        return number_format($value, 2);
    }
}

if (!function_exists('carmarket_registration_format')) {
    function carmarket_registration_format($date)
    {
        $carbon = Carbon::parse($date);

        return $carbon->format('Y-m-d');
    }
}

if (!function_exists('deleted_car_brand')) {
    function deleted_car_brand($vehicle)
    {
        if (isset($vehicle->brand)) {
            return $vehicle->brand;
        } elseif (isset($vehicle->brand_id)) {
            $brand = \App\Brand::findOrFail($vehicle->brand_id);
            return $brand->name;
        }

        return null;
    }
}

if (!function_exists('format_equipment')) {
    function format_equipment($equipment)
    {
        if ($equipment) {
            $equipmentArray = explode(' · ', $equipment);

            return $equipmentArray;
        }

        return [];
    }
}
