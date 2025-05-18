<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estate_vendors', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 60);
            $table->string('father_name', 100);
            $table->string('mother_name', 100);
            $table->string('birth_date', 20);
            $table->string('nid', 50);
            $table->string('project_id', 50);
            $table->string('district_id', 4);
            $table->string('upazila_id', 6);
            $table->string('union_id', 10);
            $table->enum('client_type' ,  array('landowner','media'));
            $table->string('v_code', 10);
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
        Schema::dropIfExists('estate_vendors');
    }
}
