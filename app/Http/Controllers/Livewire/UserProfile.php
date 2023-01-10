<?php

namespace App\Http\Controllers\Livewire;

use App\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;

class UserProfile extends Component
{
    use WithFileUploads;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $country;

    /**
     * @var string
     */
    public $company;

    /**
     * @var string
     */
    public $function;

    /**
     * @var string
     */
    public $phone;

    /**
     * @var string
     */
    public $mobile;

    /**
     * @var string
     */
    public $stockType;

    /**
     * @var string
     */
    public $importType;

    /**
     * @var string
     */
    public $apiToken;

    /**
     * @var File
     */
    public $avatar;

    /**
     * @var array
     */
    protected $rules = [
        'name' => 'required|string',
        'email' => 'required|email',
        'avatar' => 'nullable|image|max:1024',
    ];

    public function mount()
    {
        $user = Auth::user();

        $this->name = $user->name;
        $this->email = $user->email;
        $this->country = $user->country;
        $this->company = $user->company->id;
        $this->function = $user->function_description;
        $this->phone = $user->telephone;
        $this->mobile = $user->mobile;
        $this->stockType = $user->stock_type;
        $this->importType = $user->import_types;
        $this->apiToken = $user->api_token;
    }

    /**
     * Render the component
     *
     * @return mixed
     */
    public function render()
    {
        return view('frontend.livewire.user-profile')->layout('frontend.layouts.app');
    }

    /**
     * Submit form
     */
    public function submit()
    {
        //@todo
        $this->validate();

        $user = Auth::user();

        $paramArray = [
            'name' => $this->name,
            'email' => $this->email,
            'function_description' =>  $this->function,
            'telephone' =>  $this->phone,
            'mobile' =>  $this->mobile,
        ];

        if ($this->password) {
            $paramArray = array_merge($paramArray, [
                'password' =>  Hash::make($this->password),
            ]);
        }

        if ($this->avatar) {
            $avatar = $this->avatar->store('/', 'public');

            $paramArray = array_merge($paramArray, [
                'avatar' =>  $avatar,
            ]);
        }

        $user->update($paramArray);

        //@todo refactor flash message

        $this->emitSelf('notify-saved');
    }

    /**
     * Return country property
     *
     * @return array
     */
    public function getCountriesProperty()
    {
        return [
            'AF' => __('Afghanistan'),
            'AX' => __('Aland Islands'),
            'AL' => __('Albania'),
            'DZ' => __('Algeria'),
            'AS' => __('American Samoa'),
            'AD' => __('Andorra'),
            'AO' => __('Angola'),
            'AI' => __('Anguilla'),
            'AQ' => __('Antarctica'),
            'AG' => __('Antigua and Barbuda'),
            'AR' => __('Argentina'),
            'AM' => __('Armenia'),
            'AW' => __('Aruba'),
            'AU' => __('Australia'),
            'AT' => __('Austria'),
            'AZ' => __('Azerbaijan'),
            'BS' => __('Bahamas'),
            'BH' => __('Bahrain'),
            'BD' => __('Bangladesh'),
            'BB' => __('Barbados'),
            'BY' => __('Belarus'),
            'BE' => __('Belgium'),
            'BZ' => __('Belize'),
            'BJ' => __('Benin'),
            'BM' => __('Bermuda'),
            'BT' => __('Bhutan'),
            'BO' => __('Bolivia'),
            'BQ' => __('Bonaire, Sint Eustatius and Saba'),
            'BA' => __('Bosnia and Herzegovina'),
            'BW' => __('Botswana'),
            'BV' => __('Bouvet Island'),
            'BR' => __('Brazil'),
            'IO' => __('British Indian Ocean Territory'),
            'BN' => __('Brunei Darussalam'),
            'BG' => __('Bulgaria'),
            'BF' => __('Burkina Faso'),
            'BI' => __('Burundi'),
            'KH' => __('Cambodia'),
            'CM' => __('Cameroon'),
            'CA' => __('Canada'),
            'CV' => __('Cape Verde'),
            'KY' => __('Cayman Islands'),
            'CF' => __('Central African Republic'),
            'TD' => __('Chad'),
            'CL' => __('Chile'),
            'CN' => __('China'),
            'CX' => __('Christmas Island'),
            'CC' => __('Cocos (Keeling) Islands'),
            'CO' => __('Colombia'),
            'KM' => __('Comoros'),
            'CG' => __('Congo'),
            'CD' => __('Congo, Democratic Republic'),
            'CK' => __('Cook Islands'),
            'CR' => __('Costa Rica'),
            'CI' => __('Cote D\'Ivoire'),
            'HR' => __('Croatia'),
            'CU' => __('Cuba'),
            'CW' => __('Curaçao'),
            'CY' => __('Cyprus'),
            'CZ' => __('Czech Republic'),
            'DK' => __('Denmark'),
            'DJ' => __('Djibouti'),
            'DM' => __('Dominica'),
            'DO' => __('Dominican Republic'),
            'EC' => __('Ecuador'),
            'EG' => __('Egypt'),
            'SV' => __('El Salvador'),
            'GQ' => __('Equatorial Guinea'),
            'ER' => __('Eritrea'),
            'EE' => __('Estonia'),
            'ET' => __('Ethiopia'),
            'FK' => __('Falkland Islands (Malvinas)'),
            'FO' => __('Faroe Islands'),
            'FJ' => __('Fiji'),
            'FI' => __('Finland'),
            'FR' => __('France'),
            'GF' => __('French Guiana'),
            'PF' => __('French Polynesia'),
            'TF' => __('French Southern Territories'),
            'GA' => __('Gabon'),
            'GM' => __('Gambia'),
            'GE' => __('Georgia'),
            'DE' => __('Germany'),
            'GH' => __('Ghana'),
            'GI' => __('Gibraltar'),
            'GR' => __('Greece'),
            'GL' => __('Greenland'),
            'GD' => __('Grenada'),
            'GP' => __('Guadeloupe'),
            'GU' => __('Guam'),
            'GT' => __('Guatemala'),
            'GG' => __('Guernsey'),
            'GN' => __('Guinea'),
            'GW' => __('Guinea-Bissau'),
            'GY' => __('Guyana'),
            'HT' => __('Haiti'),
            'HM' => __('Heard Island and Mcdonald Islands'),
            'VA' => __('Holy See (Vatican City State)'),
            'HN' => __('Honduras'),
            'HK' => __('Hong Kong'),
            'HU' => __('Hungary'),
            'IS' => __('Iceland'),
            'IN' => __('India'),
            'ID' => __('Indonesia'),
            'IR' => __('Iran, Islamic Republic Of'),
            'IQ' => __('Iraq'),
            'IE' => __('Ireland'),
            'IM' => __('Isle Of Man'),
            'IL' => __('Israel'),
            'IT' => __('Italy'),
            'JM' => __('Jamaica'),
            'JP' => __('Japan'),
            'JE' => __('Jersey'),
            'JO' => __('Jordan'),
            'KZ' => __('Kazakhstan'),
            'KE' => __('Kenya'),
            'KI' => __('Kiribati'),
            'KP' => __('Korea, Democratic People\'s Republic Of'),
            'KR' => __('Korea'),
            'XK' => __('Kosovo'),
            'KW' => __('Kuwait'),
            'KG' => __('Kyrgyzstan'),
            'LA' => __('Lao People\'s Democratic Republic'),
            'LV' => __('Latvia'),
            'LB' => __('Lebanon'),
            'LS' => __('Lesotho'),
            'LR' => __('Liberia'),
            'LY' => __('Libya'),
            'LI' => __('Liechtenstein'),
            'LT' => __('Lithuania'),
            'LU' => __('Luxembourg'),
            'MO' => __('Macao'),
            'MK' => __('Macedonia'),
            'MG' => __('Madagascar'),
            'MW' => __('Malawi'),
            'MY' => __('Malaysia'),
            'MV' => __('Maldives'),
            'ML' => __('Mali'),
            'MT' => __('Malta'),
            'MH' => __('Marshall Islands'),
            'MQ' => __('Martinique'),
            'MR' => __('Mauritania'),
            'MU' => __('Mauritius'),
            'YT' => __('Mayotte'),
            'MX' => __('Mexico'),
            'FM' => __('Micronesia, Federated States Of'),
            'MD' => __('Moldova'),
            'MC' => __('Monaco'),
            'MN' => __('Mongolia'),
            'ME' => __('Montenegro'),
            'MS' => __('Montserrat'),
            'MA' => __('Morocco'),
            'MZ' => __('Mozambique'),
            'MM' => __('Myanmar'),
            'NA' => __('Namibia'),
            'NR' => __('Nauru'),
            'NP' => __('Nepal'),
            'NL' => __('Netherlands'),
            'NC' => __('New Caledonia'),
            'NZ' => __('New Zealand'),
            'NI' => __('Nicaragua'),
            'NE' => __('Niger'),
            'NG' => __('Nigeria'),
            'NU' => __('Niue'),
            'NF' => __('Norfolk Island'),
            'MP' => __('Northern Mariana Islands'),
            'NO' => __('Norway'),
            'OM' => __('Oman'),
            'PK' => __('Pakistan'),
            'PW' => __('Palau'),
            'PS' => __('Palestinian Territory, Occupied'),
            'PA' => __('Panama'),
            'PG' => __('Papua New Guinea'),
            'PY' => __('Paraguay'),
            'PE' => __('Peru'),
            'PH' => __('Philippines'),
            'PN' => __('Pitcairn'),
            'PL' => __('Poland'),
            'PT' => __('Portugal'),
            'PR' => __('Puerto Rico'),
            'QA' => __('Qatar'),
            'RE' => __('Reunion'),
            'RO' => __('Romania'),
            'RU' => __('Russian Federation'),
            'RW' => __('Rwanda'),
            'BL' => __('Saint Barthelemy'),
            'SH' => __('Saint Helena'),
            'KN' => __('Saint Kitts and Nevis'),
            'LC' => __('Saint Lucia'),
            'MF' => __('Saint Martin'),
            'PM' => __('Saint Pierre and Miquelon'),
            'VC' => __('Saint Vincent and Grenadines'),
            'WS' => __('Samoa'),
            'SM' => __('San Marino'),
            'ST' => __('Sao Tome and Principe'),
            'SA' => __('Saudi Arabia'),
            'SN' => __('Senegal'),
            'RS' => __('Serbia'),
            'SC' => __('Seychelles'),
            'SL' => __('Sierra Leone'),
            'SG' => __('Singapore'),
            'SX' => __('Sint Maarten (Dutch part)'),
            'SK' => __('Slovakia'),
            'SI' => __('Slovenia'),
            'SB' => __('Solomon Islands'),
            'SO' => __('Somalia'),
            'ZA' => __('South Africa'),
            'GS' => __('South Georgia and Sandwich Isl.'),
            'SS' => __('South Sudan'),
            'ES' => __('Spain'),
            'LK' => __('Sri Lanka'),
            'SD' => __('Sudan'),
            'SR' => __('Suriname'),
            'SJ' => __('Svalbard and Jan Mayen'),
            'SZ' => __('Swaziland'),
            'SE' => __('Sweden'),
            'CH' => __('Switzerland'),
            'SY' => __('Syrian Arab Republic'),
            'TW' => __('Taiwan'),
            'TJ' => __('Tajikistan'),
            'TZ' => __('Tanzania'),
            'TH' => __('Thailand'),
            'TL' => __('Timor-Leste'),
            'TG' => __('Togo'),
            'TK' => __('Tokelau'),
            'TO' => __('Tonga'),
            'TT' => __('Trinidad and Tobago'),
            'TN' => __('Tunisia'),
            'TR' => __('Turkey'),
            'TM' => __('Turkmenistan'),
            'TC' => __('Turks and Caicos Islands'),
            'TV' => __('Tuvalu'),
            'UG' => __('Uganda'),
            'UA' => __('Ukraine'),
            'AE' => __('United Arab Emirates'),
            'GB' => __('United Kingdom'),
            'US' => __('United States'),
            'UM' => __('United States Outlying Islands'),
            'UY' => __('Uruguay'),
            'UZ' => __('Uzbekistan'),
            'VU' => __('Vanuatu'),
            'VE' => __('Venezuela'),
            'VN' => __('Vietnam'),
            'VG' => __('Virgin Islands, British'),
            'VI' => __('Virgin Islands, U.S.'),
            'WF' => __('Wallis and Futuna'),
            'EH' => __('Western Sahara'),
            'YE' => __('Yemen'),
            'ZM' => __('Zambia'),
            'ZW' => __('Zimbabwe'),
        ];
    }

    /**
     * Return companies property
     *
     * @return array
     */
    public function getCompaniesProperty()
    {
        $companiesArray = Company::all()->pluck('name', 'id')->toArray();

        return $companiesArray;
    }

    /**
     * Return stock property
     *
     * @return array
     */
    public function getStockProperty()
    {
        return [
            null => 'Choose an option',
            'NC' => 'New Cars',
            'UC' => 'Used Cars',
        ];
    }

    /**
     * Return import property
     *
     * @return array
     */
    public function getImportProperty()
    {
        return [
            null => 'Choose an option',
            'I'  => 'Import Only',
            'R'  => 'Retail Only',
            'IR' => 'Import & Retail',
        ];
    }

    /**
     * Set dropdown state
     *
     * @param $state
     * @param $value
     */
    public function setState($state, $value)
    {
        $this->$state = $value;
    }
}
