<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Relations\Relation;
use App\Models\Meeting;
use App\Models\Reason;
use App\Models\PublicEmployee;
use App\Models\Visitor;
use App\Models\Office;

use Illuminate\Database\Eloquent\Factories\Factory;

class MeetingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Meeting::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $meetingable = $this->faker->randomElement(['visitor', 'publicEmployee']);

        return [
            'started_at' => date('Y-m-d H:i:s'),
            'finished_at' => date('Y-m-d H:i:s'),
            'public_employee_id' => PublicEmployee::all()->random()->id,
            'reason_id' => Reason::all()->random()->id,
            'office_id' => Office::all()->random()->id,
            'observation' => $this->faker->text(),
            'meetingable_type' => $meetingable,
            'meetingable_id' => call_user_func(Relation::getMorphedModel($meetingable) . "::factory")
        ];
    }
}
