<?php

namespace App\Export;

use App\Console\Commands\ImportCzVehicles;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AutoSphereCzCsvExport implements FromCollection, WithHeadings
{
    /**
     * @var array
     */
    protected $data;

    /**
     * AutoSphereCzCsvExport constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        $dataArray = $this->data;

        foreach ($dataArray as $key => &$item) {
            $item['manufacturer'] = $item['relationships']['manufacturer']['name'];
            $item['model'] = $item['relationships']['model']['name'];
            $item['body'] = $item['relationships']['body']['name'];
            $item['transmission'] = $item['relationships']['transmission']['name'];
            $item['fuel'] = $item['relationships']['fuel']['name'];
            $item['drive'] = $item['relationships']['drive']['name'];
            $item['color_code'] = $item['relationships']['color']['code'];
            $item['color_description'] = $item['relationships']['color']['name'];
            $item['car_state'] = $item['relationships']['car_state']['code'];
            $item['category'] = $item['relationships']['category']['code'];
            $item['account_id'] = $item['relationships']['dealer']['id'];

            $optionsCode = null;
            $optionCodeDescription = null;

            foreach ($item['relationships']['parameters'] as $optionData) {
                $optionsCode = $optionsCode . $optionData['code'] . ' ';
                $optionCodeDescription = $optionCodeDescription . $optionData['name'] . ' · ';
            }

            $item['options_code'] = $optionsCode;
            $item['option_code_description'] = $optionCodeDescription;

            $mediaPath = null;

            foreach ($item['relationships']['images'] as $imageData) {
                $mediaPath = $mediaPath . $imageData['url'] . ';';
            }

            $item['media_path'] = $mediaPath;

            unset($item['relationships']);
        }

        $dataCollection = collect($dataArray);

        return $dataCollection;
    }

    /**
     * @return array
     */
    public function headings() :array
    {
        return [
            'id',
            'updated_at',
            'url',
            'title',
            'version_description',
            'description',
            'year',
            'km',
            'month',
            'volume',
            'power',
            'doors',
            'places',
            'vin',
            'vat_deductible',
            'price',
            'price_without_VAT',
            'loading_place',
            'has_warranty',
            'manufacturer',
            'model',
            'body',
            'transmission',
            'fuel',
            'drive',
            'color_code',
            'color_description',
            'car_state',
            'category',
            'account_id',
            'options_code',
            'option_code_description',
            'media_path',
        ];
    }
}
