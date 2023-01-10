<?php

namespace App\Http\Controllers\Auth;

use App\Brand;
use App\Company;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show registration form
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showRegistrationForm()
    {
        $companyDbArray = Company::pluck('name', 'id')->toArray();

        $companyArray = array_replace([
            null => '-- Select company --',
        ], $companyDbArray);

        $roleArray = Role::where('name', '!=', 'Administrator')->pluck('name', 'id')->toArray();

        $brandArray = Brand::pluck('name', 'id')->toArray();

        $vehicleTypeArray = [
            'Passenger' => 'Passenger',
            'LCV' => 'LCV',
            'Truck' => 'Truck',
        ];

        return view('auth.register', [
            'companies' => $companyArray,
            'roles' => $roleArray,
            'brands' => $brandArray,
            'vehicleTypes' => $vehicleTypeArray,
        ]);
    }

    /**
     * Register the user
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Exception
     */
    public function register(RegisterRequest $request)
    {
        DB::beginTransaction();

        try {
            $user = $this->create($request->input());

            if (count($request->input('brand', []))) {
                $user->brands()->sync($request->input('brand'));
            }

            $user->roles()->sync($request->input('role'));
        } catch (\Exception $exception) {
            DB::rollBack();

            throw $exception;
        }

        DB::commit();

        return view('auth.registerSuccess');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $params = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'country' => $data['country'],
            'function_description' => $data['function_description'],
            'telephone' => $data['telephone'],
            'mobile' => $data['mobile'],
            'stock_type' => $data['stock_type'],
            'vehicle_type' => $data['vehicle_type'],
            'new_user' => 1,
        ];

        if (isset($data['company'])) {
            $params = array_merge($params, [
                'company_id' => $data['company']
            ]);
        } else {
            $params = array_merge($params, [
                'company_suggestion' => $data['company_name'] . ',' . $data['company_address']
            ]);
        }

        return User::create($params);
    }
}
