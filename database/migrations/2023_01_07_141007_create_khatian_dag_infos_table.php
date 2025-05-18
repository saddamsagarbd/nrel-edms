<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKhatianDagInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('khatian_dag_infos', function (Blueprint $table) {
            $table->id();
            $table->integer('mouza_id');
            $table->integer('khatian_type');
            $table->string('dag_no', 10);
            $table->string('land_size', 10);
            $table->string('khatian_no', 10)->nullable();
            $table->integer('parent_id');
            $table->unique(['mouza_id', 'dag_no']);
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
        Schema::dropIfExists('khatian_dag_infos');
    }
}
