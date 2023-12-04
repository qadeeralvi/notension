<?php

namespace Database\Factories;

use App\Models\JobManagement;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = JobManagement::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = user::pluck('id')->all();
        return [
            'user_id' =>  $this->faker->randomElement($user),
            'title' => $this->faker->words(2, true),
            'category' => $this->faker->randomElement(['Craft','Transport','Lahore']),
            'sub_category' => $this->faker->randomElement(['Freight Transport','Freight Transport']),
            'phone' => $this->randomNumber(12, true),
            'name' => $this->faker->words(2, true),
            'city' =>$this->faker->randomElement(['Islamabad','Rawalpindi','Lahore','Karachi','Kallar']),
            'address' => $this->faker->randomElement(['Islamabad','Rawalpindi','Lahore','Karachi','Kallar']),
            'description' =>$this->faker->words(10, true),
            'date' => $this->faker->date('Y_m_d'),
            'time' => $this->faker->date('h:i:s A'),
            'status' => $this->faker->randomElement(['active','rejected','Pending']),
        ];
    }
}
