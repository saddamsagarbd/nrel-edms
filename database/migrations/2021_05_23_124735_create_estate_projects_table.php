<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estate_projects', function (Blueprint $table) {
            $table->id();
            $table->string('name',100);
            $table->string('slug',100);
            $table->tinyInteger('parent_id')->nullable();
            $table->string('project_type',4);
            $table->string('land_type', 50);
            $table->string('location', 150);
            $table->string('division_id',4)->nullable();
            $table->string('district_id',4)->nullable();
            $table->string('upazila_id', 4)->nullable();
            $table->string('status', 25)->nullable();
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
        Schema::dropIfExists('estate_projects');
    }
}
