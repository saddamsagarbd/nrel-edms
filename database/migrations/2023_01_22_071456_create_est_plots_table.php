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
        Schema::create('est_plots', function (Blueprint $table) {
            $table->id();
            $table->string('plot_no',16);
            $table->integer('project_id');
            $table->string('sector_no');
            $table->string('road_no');
            $table->string('plot_size', 20)->nullable();
            $table->string('plot_rate', 20)->nullable();
            $table->string('sale_rate', 20)->nullable();
            $table->string('p_category');
            $table->date('reg_date')->nullable();
            $table->date('mutation_date')->nullable();
            $table->date('handover_date')->nullable();
            $table->string('facing');
            $table->string('remarks')->nullable();
            $table->enum('s_status',['unsold','booked','sold']);
            $table->enum('p_status',['publish', 'unpublish']);
            $table->string('mouza_id');
            $table->string('khatian_type');
            $table->integer('plot_owner')->nullable();
            $table->integer('user_id');
            $table->string('seller_uid');
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
        Schema::dropIfExists('est_plots');
    }
};
