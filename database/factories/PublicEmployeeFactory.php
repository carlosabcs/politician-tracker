<?php

namespace Database\Factories;

use App\Models\PublicEmployee;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Position;
use App\Models\PublicEntity;

class PublicEmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PublicEmployee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'position_id' => Position::all()->random()->id,
            'public_entity_id' => PublicEntity::all()->random()->id
        ];
    }
}
