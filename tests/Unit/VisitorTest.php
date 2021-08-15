<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;
use App\Models\Visitor;
use App\Models\Meeting;
use App\Models\Reason;
use App\Models\PublicEmployee;
use App\Models\Office;
use App\Models\Position;
use App\Models\PublicEntity;

class VisitorTest extends TestCase
{
    use RefreshDatabase;
    
    public function setUp() :void
    {
        parent::setUp();

        $this->reason = Reason::factory()->create();
        $this->publicEntity = PublicEntity::factory()->create();
        $this->position = Position::factory()->create();
        $this->publicEmployee = PublicEmployee::factory()->create();
        $this->office = Office::factory()->create();
        $this->visitor = Visitor::factory()->create();
        $this->meeting = Meeting::factory()->create([
            'meetingable_id' => $this->visitor->id,
            'meetingable_type' => 'visitor'
        ]);
    } 

    /** @test  */
    public function visitors_database_has_expected_columns()
    {
        $this->assertTrue( 
            Schema::hasColumns('visitors', [
                'id','name', 'dni', 'entity'
        ]), 1);
    }

    /** @test  */
    public function a_visitor_morphs_many_meetings()
    {
        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection',
            $this->visitor->morphMeetings
        ); 
    }
}
