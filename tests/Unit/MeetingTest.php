<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;
use App\Models\PublicEmployee;
use App\Models\Meeting;
use App\Models\Reason;
use App\Models\Visitor;
use App\Models\Office;
use App\Models\Position;
use App\Models\PublicEntity;

class MeetingTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    public function setUp() :void
    {
        parent::setUp();

        $this->reason = Reason::factory()->create();
        $this->publicEntity = PublicEntity::factory()->create();
        $this->position = Position::factory()->create();
        $this->publicEmployee = PublicEmployee::factory()->create();
        $this->visitor = Visitor::factory()->create();
        $this->office = Office::factory()->create();
        $this->meeting = Meeting::factory()->create();
    }

    /** @test */
    public function a_meeting_can_be_morphed_to_a_visitor_model()
    {
        $meeting = Meeting::factory()->create([
            'meetingable_id' => $this->visitor->id,
            'meetingable_type' => 'visitor',
        ]); 

        $this->assertInstanceOf(
            Visitor::class,
            $meeting->meetingable
        );
    }

    /** @test */
    public function a_meeting_can_be_morphed_to_a_public_employee_model()
    {
        $meeting = Meeting::factory()->create([
            'meetingable_id' => $this->publicEmployee->id,
            'meetingable_type' => 'publicEmployee',
        ]); 

        $this->assertInstanceOf(
            PublicEmployee::class,
            $meeting->meetingable
        );
    }
}
