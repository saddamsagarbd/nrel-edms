<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMouzasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mouzas', function (Blueprint $table) {
            $table->id();
            $table->string('name', 25);
            $table->string('bn_name', 25);
            $table->string('gl_no', 10)->nullable();
            $table->integer('division_id');
            $table->integer('union_id');
            $table->integer('upazilla_id');
            $table->integer('district_id');
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
        Schema::dropIfExists('mouzas');
    }
}
