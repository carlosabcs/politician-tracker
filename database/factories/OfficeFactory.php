<?php

namespace Database\Factories;

use App\Models\Office;
use App\Models\PublicEntity;
use Illuminate\Database\Eloquent\Factories\Factory;

class OfficeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Office::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'description' => $this->faker->company(),
            'public_entity_id' => PublicEntity::all()->random()->id
        ];
    }
}
