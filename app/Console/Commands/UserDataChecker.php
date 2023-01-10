<?php

namespace App\Console\Commands;

use App\Company;
use App\DataIntegrityReport;
use Illuminate\Console\Command;
use App\User;
use Illuminate\Support\Facades\DB;

class UserDataChecker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:user:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks user data integrity';

    /**
     * @var Company
     */
    public $company;

    /**
     * @var DataIntegrityReport
     */
    public $dataIntegrityReport;

//    /**
//     * @var array
//     */
//    public $companyRoleSellingStaffArray = [];

//    /**
//     * @var array
//     */
//    public $companyRoleOtherStaffArray = [];

    /**
     * @var array
     */
    public $companyWithoutUsersArray = [];

    /**
     * @var array
     */
    public $companyUserRoleMappingArray = [];

    /**
     * @var array
     */
    public $sellingStaffRoles = ['Uploader', 'Logistics'];

    /**
     * UserDataChecker constructor.
     * @param Company $company
     * @param DataIntegrityReport $dataIntegrityReport
     */
    public function __construct(Company $company, DataIntegrityReport $dataIntegrityReport)
    {
        parent::__construct();

        $this->company = $company;
        $this->dataIntegrityReport = $dataIntegrityReport;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $companyCollection = $this->company->with(['users.roles'])->get();

        foreach ($companyCollection as $company) {
            if (count($company->users)) {
                foreach ($company->users as $user) {
                    foreach ($user->roles as $role) {
                        if ($role->name === 'Administrator') {
                            continue;
                        }

                        $vehicleType = $user->vehicle_type;

                        if ($user->stock_type === 'UC') {
                            $this->companyUserRoleMappingArray[$company->id]['UC'][$role->name] = true;
                        } elseif ($user->stock_type === 'NC') {
                            if (!$vehicleType || !count($vehicleType)) {
                                continue;
                            }

                            foreach ($vehicleType as $type) {
                                $this->companyUserRoleMappingArray[$company->id]['NC'][$type][$role->name] = true;
                            }
                        } elseif ($user->stock_type === 'both') {
                            if (!$vehicleType || !count($vehicleType)) {
                                continue;
                            }

                            $this->companyUserRoleMappingArray[$company->id]['UC'][$role->name] = true;

                            foreach ($vehicleType as $type) {
                                $this->companyUserRoleMappingArray[$company->id]['NC'][$type][$role->name] = true;
                            }
                        }
                    }
                }
            } else {
                $this->companyWithoutUsersArray[$company->id]['name'] = $company->name;
            }
        }

        //dd($this->companyUserRoleMappingArray);

        DB::beginTransaction();

        try {
            $this->checkUserRolePerCompany();

            $this->checkUsersWithoutCompany();

            $this->checkUsersWithoutStockType();

            $this->checkNCUsersWithoutBrand();

            $this->checkCompanyWithoutUsers();

            //$this->checkCompanyWithoutStaff();

            $this->checkUserVehicleType();

            DB::commit();
        } catch (\Exception $exception) {
            activity('user_data_checker_report_error')
                ->withProperties($exception)
                ->log('Error while generating user data integrity report.');

            DB::rollback();
        }

        $this->info("Report generation completed");

        return true;
    }

    /**
     * Check if there are users without stock type
     */
    private function checkUsersWithoutStockType()
    {
        $usersWithoutStockTypeWarningArray = [];

        $userCollection = User::where('stock_type', null)->get();

        foreach ($userCollection as $user) {
            array_push($usersWithoutStockTypeWarningArray, [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'report' => "User does not have a stock type set.",
            ]);
        }

        if (count($usersWithoutStockTypeWarningArray)) {
            $this->dataIntegrityReport->create([
                'report_data' => $usersWithoutStockTypeWarningArray,
                'type' => DataIntegrityReport::USER_WITHOUT_STOCK_TYPE,
            ]);
        }
    }

    /**
     * Check if there are users without vehicle type
     */
    private function checkNCUsersWithoutBrand()
    {
        $ncUsersWithoutBrandWarningArray = [];

        $userCollection = User::whereIn('stock_type', ['NC', 'both'])->doesntHave('brands')->get();

        foreach ($userCollection as $user) {
            array_push($ncUsersWithoutBrandWarningArray, [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'report' => "User is either New Cars seller or 'both' seller, but it does not have any brands attached.",
            ]);
        }

        if (count($ncUsersWithoutBrandWarningArray)) {
            $this->dataIntegrityReport->create([
                'report_data' => $ncUsersWithoutBrandWarningArray,
                'type' => DataIntegrityReport::NC_USER_WITHOUT_BRAND,
            ]);
        }
    }

    /**
     * Check if there are users without vehicle type
     */
    private function checkUserVehicleType()
    {
        $usersWithoutVehicleTypeWarningArray = [];

        $userCollection = User::where('vehicle_type', null)->get();

        foreach ($userCollection as $user) {
            array_push($usersWithoutVehicleTypeWarningArray, [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'report' => "User does not have vehicle type set.",
            ]);
        }

        if (count($usersWithoutVehicleTypeWarningArray)) {
            $this->dataIntegrityReport->create([
                'report_data' => $usersWithoutVehicleTypeWarningArray,
                'type' => DataIntegrityReport::USER_WITHOUT_VEHICLE_TYPE,
            ]);
        }
    }

    /**
     * Check if there are companies without users
     */
    private function checkUsersWithoutCompany()
    {
        $usersWithoutCompanyWarningArray = [];

        $userCollection = User::doesntHave('company')->get();

        foreach ($userCollection as $user) {
            array_push($usersWithoutCompanyWarningArray, [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'report' => "User does not have any company.",
            ]);
        }

        if (count($usersWithoutCompanyWarningArray)) {
            $this->dataIntegrityReport->create([
                'report_data' => $usersWithoutCompanyWarningArray,
                'type' => DataIntegrityReport::USER_WITHOUT_COMPANY,
            ]);
        }
    }

    /**
     * Check if there are companies without users
     */
    private function checkCompanyWithoutUsers()
    {
        $companyWithoutUsersWarningArray = [];

        $companyCollection = Company::doesntHave('users')->get();

        foreach ($companyCollection as $company) {
            array_push($companyWithoutUsersWarningArray, [
                'company_id' => $company->id,
                'company_name' => $company->name,
                'report' => "Company does not have any users",
            ]);
        }

        if (count($companyWithoutUsersWarningArray)) {
            $this->dataIntegrityReport->create([
                'report_data' => $companyWithoutUsersWarningArray,
                'type' => DataIntegrityReport::COMPANY_WITHOUT_USERS,
            ]);
        }
    }

//    /**
//     * Check if there are companies without staff (Uploaders and Logistics users)
//     */
//    private function checkCompanyWithoutStaff()
//    {
//        $companyWithoutStaffWarningArray = [];
//
//        foreach ($this->companyRoleOtherStaffArray as $companyId => $companyData) {
//            array_push($companyWithoutStaffWarningArray, [
//                'company_id' => $companyId,
//                'company_name' => $companyData['name'],
//                'report' => "Company does not have Uploader and Logistics roles. Both are missing",
//            ]);
//        }
//
//        if (count($companyWithoutStaffWarningArray)) {
//            $this->dataIntegrityReport->create([
//                'report_data' => $companyWithoutStaffWarningArray,
//                'type' => DataIntegrityReport::COMPANY_WITHOUT_LOGISTICS_UPLOADER_ROLE,
//            ]);
//        }
//    }

    /**
     * Check if there are companies that don't have Uploader-Logistics combination. One of roles is missing
     */
    private function checkUserRolePerCompany()
    {
        $userRolePerCompanyWarningArray = [];

        foreach ($this->companyUserRoleMappingArray as $companyId => $companyData) {
            foreach ($companyData as $stockType => $roleData) {
                if ($stockType == 'UC') {
                    $roleData = array_keys($roleData);
                    $result = array_intersect($this->sellingStaffRoles, $roleData);

                    if (count($result) == 1) {
                        $company = Company::find($companyId);

                        if (!$company) {
                            continue;
                        }

                        array_push($userRolePerCompanyWarningArray, [
                            'company_id' => $companyId,
                            'company_name' => $company->name,
                            'report' => "Company does not have Uploader-Logistics combination under Used Cars stock type. One of roles is missing",
                        ]);
                    }
                } elseif ($stockType == 'NC') {
                    foreach ($roleData as $vehicleType => $roleArray) {
                        $roleArray = array_keys($roleArray);
                        $result = array_intersect($this->sellingStaffRoles, $roleArray);

                        if (count($result) == 1) {
                            $company = Company::find($companyId);

                            if (!$company) {
                                continue;
                            }

                            array_push($userRolePerCompanyWarningArray, [
                                'company_id' => $companyId,
                                'company_name' => $company->name,
                                'report' => "Company does not have Uploader-Logistics combination under New Cars stock type and $vehicleType vehicle type. One of roles is missing",
                            ]);
                        }
                    }
                }
            }
        }

        if (count($userRolePerCompanyWarningArray)) {
            $this->dataIntegrityReport->create([
                'report_data' => $userRolePerCompanyWarningArray,
                'type' => DataIntegrityReport::COMPANY_WITHOUT_SELLER_ROLE_COMBINATION,
            ]);
        }
    }
}
