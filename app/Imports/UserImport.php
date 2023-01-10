<?php

namespace App\Imports;

use App\Brand;
use App\Company;
use App\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Spatie\Permission\Models\Role;

class UserImport implements ToModel, WithHeadingRow, WithMultipleSheets
{
    use Importable;

    public function model(array $row)
    {
        $stockType = null;
        $brands = null;
        $roles = collect();
        $company = null;
        $row['contact_mail'] = strtolower(trim($row['contact_mail']));
        if ($row['used_cars'] == 'UC') {
            $stockType = 'UC';
        }
        if ($row['new_car'] == 'NC') {
            $stockType = 'NC';
        }
        if (!is_null($row['company'])) {
            $company = Company::firstOrCreate([
                'name' => trim($row['company']),
                'address' => trim($row['company_address'])
            ]);
        }
        if ($row['uploader_role'] === 'Uploader' ) {
            $roles->add(Role::where('name', 'Uploader')->first());
        }
        if ($row['logistic_role'] === 'Logistic') {
            $roles->add(Role::where('name', 'Logistics')->first());
        }
        if (!is_null($row['brand'])) {
            $brands = collect(preg_split('/[\s,\/;]+/', $row['brand']))
                ->map(function ($item) {
                    return trim($item);
                })
                ->map(function ($item) {
                    return Brand::firstOrCreate([
                        'name' => $item
                    ]);
                });
        }
        $user = User::updateOrCreate(
            [
                'email' => $row['contact_mail']
            ],
            [
                'name' => trim($row['name']),
                'country' => $row['country'],
                'function_description' => $row['role'],
                'telephone' => $row['tel'],
                'mobile' => $row['mob'],
                'stock_type' => $stockType,
                'import_types' => $row['import_i_retail_r'],
                'comment' => $row['comment'],
                'password' => Hash::make('changeme')
            ]
        );
        if (!is_null($brands)) {
            $user->brands()->sync($brands->pluck('id'));
        }
        if ($roles->count() > 0) {
            $user->roles()->sync($roles->pluck('id'));
        }
        if (!is_null($company)) {
            $user->company()->associate($company);
        }
        return $user;
    }

    public function sheets(): array
    {
        return [
            0 => $this
        ];
    }
}