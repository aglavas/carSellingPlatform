<?php

namespace Database\Factories;

use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Company;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'country' => $this->faker->randomElement(['CZ', 'SK', 'SI', 'HU', 'HR', 'RS', 'CH', 'FR', 'NL']),
            'function_description' => $this->faker->randomElement(['Sales Operations', 'Sales Planning', 'General Manager CE', 'Logistic Assistant', 'Manager of NV Logistics']),
            'telephone' => $this->faker->phoneNumber,
            'mobile' => $this->faker->phoneNumber,
            'avatar' => Str::random(10),
            'show_contact_on_all_cars' => true,
            'company_id' => self::factoryForModel(Company::class),
            'stock_type' => $this->faker->randomElement(['UC', 'NC']),
            'import_types' => $this->faker->randomElement(['I', 'IR', 'I & R']),
            'comment' => $this->faker->text,
            'api_token' => Str::random(20),
            'new_user' => 0,
            'vehicle_type' => ['LCV', 'Passenger', 'Truck'],
        ];
    }
}

