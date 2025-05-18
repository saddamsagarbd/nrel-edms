<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('land_area');
            $table->string('zone');
            $table->string('status');
            $table->string('location');
            $table->string('total_floor');
            $table->string('address');
            $table->date('milad_date');
            $table->date('handover_date');
            $table->date('aoa_date');
            $table->date('completion_date');
            $table->string('design_officer');
            $table->date('design_start');
            $table->date('design_end');
            $table->integer('user_id')->unsigned();
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
        Schema::dropIfExists('projects');
    }
}
