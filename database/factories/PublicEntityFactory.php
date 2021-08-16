<?php

namespace Database\Factories;

use App\Models\PublicEntity;
use Illuminate\Database\Eloquent\Factories\Factory;

class PublicEntityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PublicEntity::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'description' => $this->faker->company()
        ];
    }
}
