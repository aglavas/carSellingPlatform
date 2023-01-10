<?php

namespace App\Console\Commands;

use App\Company;
use Illuminate\Console\Command;
use App\User;
use Illuminate\Support\Facades\Hash;

class ApiUsersRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:api:users:roles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ensures integrity of API users. Adds users to API connection company (if needed). Adds roles (Buyer, Logistics, Uploader) to these company users. Adds Passenger, LCV vehicle type to these users.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //NL integration

        $mappingArray = config('carmarket.imports.used.nl.mappings');

        $mappingKeys = array_keys($mappingArray);

        foreach ($mappingKeys as $key) {
            $companyId = $mappingArray[$key]['klantnummer'];

            $this->handleCompanyUsers($companyId,'NL');
        }

        $this->info("NL users checked");

        //DE integration

        $mappingArray = config('carmarket.imports.used.de.mappings');

        $companyId = $mappingArray['company_data']['company_id'];

        $this->handleCompanyUsers($companyId,'DE');

        $this->info("DE users checked");

        //CZ integration

        $mappingArray = config('carmarket.imports.used.cz.mappings');

        $companyId = $mappingArray['company_data']['company_id'];

        $this->handleCompanyUsers($companyId,'CZ');

        $this->info("CZ users checked");

        $this->info("Finalized");
    }

    /**
     * Handle company users
     *
     * @param int $companyId
     * @param string $country
     */
    private function handleCompanyUsers(int $companyId, string $country)
    {
        $company = Company::find($companyId);

        $companyUserCollection = $company->users()->get();

        if (!count($companyUserCollection)) {
            $companyUserCollection = $this->addUserToCompany($company, $country);
        }

        foreach ($companyUserCollection as $user) {
            $user->syncRoles(['Buyer', 'Uploader', 'Logistics']);

            $user->vehicle_type = [
                'Passenger',
                'LCV'
            ];

            $user->save();
        }
    }

    /**
     * Add user to company
     *
     * @param Company $company
     * @param string $country
     * @return \Illuminate\Support\Collection
     */
    private function addUserToCompany(Company $company, string $country)
    {
        $emailName = strtolower(trim($company->name));

        $emailName = str_replace(' ', '', $emailName);

        $params = [
            'name' => $company->name . ' API user',
            'email' => $emailName . 'apiuser@mail.com',
            'password' => Hash::make('changeme'),
            'country' => $country,
            'company_id' => $company->id,
        ];

        $user = User::create($params);

        return collect([$user]);
    }
}
