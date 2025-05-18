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
        Schema::create('est_entry_file_dags', function (Blueprint $table) {
            $table->id();
            $table->integer('cssa_dag');
            $table->integer('rs_dag');
            $table->integer('bscity_dag');
            $table->string('propose_land',10);
            $table->string('purchase_land',10);
            $table->string('mutation_land',10);
            $table->tinyInteger('khatian_type');
            $table->integer('entfile_id');
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
        Schema::dropIfExists('est_entry_file_dags');
    }
};
