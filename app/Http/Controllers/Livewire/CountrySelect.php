<?php

namespace App\Http\Controllers\Livewire;

use Livewire\Component;

class CountrySelect extends Component
{
    /**
     * @var array
     */
    public $countries = [];

    /**
     * @var string
     */
    public $selected = null;

    /**
     * Mount the component
     *
     * @param null $country
     */
    public function mount($country = null)
    {
        if ($country) {
            $this->selected = $country;
        }

        $this->setCountries();
    }

    /**
     * Render the component
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('frontend.livewire.country-select');
    }

    /**
     * Set country array
     */
    private function setCountries()
    {
        $this->countries = [
            null => __('-- Pick your country --'),
            'AL' => __('Albania'),
            'BE' => __('Belgium'),
            'BA' => __('Bosnia and Herzegovina'),
            'HR' => __('Croatia'),
            'CZ' => __('Czech Republic'),
            'FR' => __('France'),
            'DE' => __('Germany'),
            'HU' => __('Hungary'),
            'ME' => __('Montenegro'),
            'NL' => __('Netherlands'),
            'PL' => __('Poland'),
            'RS' => __('Serbia'),
            'SK' => __('Slovakia'),
            'SI' => __('Slovenia'),
            'CH' => __('Switzerland'),
        ];
    }
}
