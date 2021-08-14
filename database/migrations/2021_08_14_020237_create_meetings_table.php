<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->dateTime('started_at', $precision = 0);
            $table->dateTime('finished_at', $precision = 0);
            $table->text('observation');
            $table->integer('meetingable_id');
            $table->string('meetingable_type');
            $table->foreignId('public_employee_id')->constrained();
            $table->foreignId('office_id')->constrained();
            $table->foreignId('reason_id')->constrained();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meetings');
    }
}
