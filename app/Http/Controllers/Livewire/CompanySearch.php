<?php

namespace App\Http\Controllers\Livewire;

use App\Company;
use App\User;
use Livewire\Component;

class CompanySearch extends Component
{
    /**
     * @var string
     */
    public $search;

    /**
     * @var array
     */
    public $companies = [];

    /**
     * @var string
     */
    public $country = null;

    /**
     * @var bool
     */
    public $addNew = false;

    /**
     * @var bool
     */
    public $showCompanyFields = false;

    /**
     * @var string
     */
    public $companyName;

    /**
     * Render the component
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        $companyArray = Company::pluck('name', 'id')->toArray();

        $companyArray[00000] = '-- Pick your company --';

        $this->companies = $companyArray;

        return view('frontend.livewire.company-search');
    }

    /**
     * Select company
     *
     * @param $company
     */
    public function selectCompany($company)
    {
        $user = User::where('company_id', $company)->get()->first();

        if (is_null($user) || is_null($user->country)) {
            $this->country = 'missing';
        } else {
            $this->country = $user->country;
        }
    }

    /**
     * Show company field
     */
    public function showCompanyFields()
    {
        $this->search = null;
        $this->reset();
        $this->showCompanyFields = !$this->showCompanyFields;
    }
}
