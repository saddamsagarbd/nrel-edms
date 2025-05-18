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
        Schema::create('est_plot_activities', function (Blueprint $table) {
            $table->id();
            $table->string('plot_id');
            $table->string('activity_id');
            $table->timestamp('added_at');
            $table->integer('user_id');
            $table->string('subject')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('est_plot_activities');
    }
};
