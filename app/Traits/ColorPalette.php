<?php

namespace App\Traits;

trait ColorPalette
{
    /**
     * @var array
     */
    public $colorArray = ['#F87171', '#8E44AD', '#1ABC9C', '#E67E22', '#707B7C', '#17202A', ' #D98880', '#00EE00', '#97FFFF', '#FFDEAD', '#FFF68F', '#C0FF3E'];

    /**
     * @var array
     */
    public $ucNcColors = ['#DB2777', '#7C3AED'];

    public $countryColors = [
        'cz' => '#2563EB',
        'sk' => '#059669',
        'si' => '#D97706',
        'hu' => '#4F46E5',
        'hr' => '#DC2626',
        'rs' => '#F472B6',
        'ch' => '#A78BFA',
        'fr' => '#818CF8',
        'nl' => '#60A5FA',
        'de' => '#34D399',
        'pl' => '#FBBF24'
    ];

    /**
     * Get country color array
     *
     * @param array $countries
     * @return array
     */
    public function getCountryColorArray(array $countries)
    {
        $colorArray = [];

        foreach ($countries as $countryCode) {
            if (isset($this->countryColors[$countryCode])) {
                $colorArray[$countryCode] = $this->countryColors[$countryCode];
            }
        }

        return $colorArray;
    }

    /**
     * Return color array
     *
     * @param int $length
     * @param bool $ucNc
     * @return array
     */
    public function getColorArray(int $length, $ucNc = false)
    {
        if ($ucNc) {
            return $this->ucNcColors;
        }

        $counter = 0;

        $resultColorArray = [];

        foreach ($this->colorArray as $color) {
            array_push($resultColorArray, $color);

            $counter++;

            if ($counter == $length) {
                break;
            }

            if ($color === end($this->colorArray)) {
                reset($this->colorArray);
            }
        }

        return $resultColorArray;
    }

    /**
     * Adjust brightness
     *
     * @param $hexCode
     * @param $adjustPercent
     * @return string
     */
    function adjustBrightness($hexCode, $adjustPercent) {
        $hexCode = ltrim($hexCode, '#');

        if (strlen($hexCode) == 3) {
            $hexCode = $hexCode[0] . $hexCode[0] . $hexCode[1] . $hexCode[1] . $hexCode[2] . $hexCode[2];
        }

        $hexCode = array_map('hexdec', str_split($hexCode, 2));

        foreach ($hexCode as & $color) {
            $adjustableLimit = $adjustPercent < 0 ? $color : 255 - $color;
            $adjustAmount = ceil($adjustableLimit * $adjustPercent);

            $color = str_pad(dechex($color + $adjustAmount), 2, '0', STR_PAD_LEFT);
        }

        return '#' . implode($hexCode);
    }
}
