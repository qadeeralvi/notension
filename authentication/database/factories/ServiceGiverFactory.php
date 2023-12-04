<?php

namespace Database\Factories;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use App\Models\ServiceGiver;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceGiverFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ServiceGiver::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->words(2, true),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('admin'), // password
            'remember_token' => Str::random(10),
            'location' => $this->faker->randomElement(['Islamabad','Rawalpindi','Lahore','Karachi','Kallar']),
            'total_job_assigned' => $this->faker->randomNumber(2, false),
            'rating' => $this->faker->numberBetween(1, 20), 
            'last_jod_date' => $this->faker->date('Y-M-d'),
        ];
    }
}
