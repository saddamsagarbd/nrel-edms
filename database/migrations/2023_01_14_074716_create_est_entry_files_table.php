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
        Schema::create('est_entry_files', function (Blueprint $table) {

            $table->id();
            $table->string('file_no',16);
            $table->integer('dalil_no')->nullable();
            $table->integer('user_id');
            $table->integer('project_id');
            $table->integer('agent_id');
            $table->integer('buyer_id')->nullable();
            $table->string('buyer_company', 30)->nullable();
            $table->string('mouza_id');
            $table->tinyInteger('khatype_id');
            $table->string('remarks')->nullable();
            $table->string('land_size', 20)->nullable();
            $table->string('land_cost', 20)->nullable();
            $table->string('reg_cost', 20)->nullable();
            $table->date('reg_date')->nullable();
            $table->string('reg_office', 50)->nullable();
            $table->integer('mzoth_no', 10)->nullable();
            $table->timestamp('mutation_date')->nullable();
            $table->string('mkhatian_no', 10)->nullable();
            $table->tinyInteger('deed_status')->nullable();
            $table->enum('status',['1', '2', '3']);
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
        Schema::dropIfExists('est_entry_files');
    }
};
