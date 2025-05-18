<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estate_files', function (Blueprint $table) {
            $table->id();
            $table->string('deed_no');
            $table->string('file_name');
            $table->string('file_desc');
            $table->string('orgi_name');
            $table->string('file_path');
            $table->string('file_type');
            $table->string('file_size');
            $table->string('project_id');
            $table->integer('vendor_id');
            $table->integer('user_id');
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
        Schema::dropIfExists('estate_files');
    }
}
