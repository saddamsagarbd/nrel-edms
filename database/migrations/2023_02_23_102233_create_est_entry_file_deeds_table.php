<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('est_entry_file_deeds', function (Blueprint $table) {
            $table->id();
            $table->integer('entfile_id');
            $table->integer('deed_type');
            $table->tinyInteger('khatian_type');
            $table->integer('cssa_dag')->nullable();
            $table->integer('rs_dag')->nullable();
            $table->integer('bscity_dag')->nullable();
            $table->string('propose_land',10);
            $table->string('purchase_land',10);
            $table->string('mutation_land',10);
            $table->string('ext_data')->nullable();
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
        Schema::dropIfExists('est_entry_file_deeds');
    }
};
