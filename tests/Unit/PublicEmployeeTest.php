<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;
use App\Models\Meeting;
use App\Models\Reason;
use App\Models\PublicEmployee;
use App\Models\Office;
use App\Models\Position;
use App\Models\PublicEntity;

class PublicEmployeeTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() :void
    {
        parent::setUp();

        $this->reason = Reason::factory()->create();
        $this->publicEntity = PublicEntity::factory()->create();
        $this->position = Position::factory()->create();
        $this->publicEmployee = PublicEmployee::factory()->create();
        $this->publicEmployeeAsVisitor = PublicEmployee::factory()->create();
        $this->office = Office::factory()->create();
        $this->meeting = Meeting::factory()->create([
            'meetingable_id' => $this->publicEmployeeAsVisitor->id,
            'meetingable_type' => 'publicEmployee'
        ]);
    }

    /** @test  */
    public function public_employees_database_has_expected_columns()
    {
        $this->assertTrue( 
            Schema::hasColumns('public_employees', [
                'id','name', 'position_id', 'public_entity_id'
        ]), 1);
    }

    /** @test  */
    public function a_public_employee_morphs_many_meetings()
    {
        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection',
            $this->publicEmployee->morphMeetings
        ); 
    }
}
