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
        Schema::create('est_entry_file_mutations', function (Blueprint $table) {
            $table->id();
            $table->integer('entryfile_id');
            $table->integer('zoth_no');
            $table->string('extdata')->nullable();
            $table->timestamp('mutation_date');
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
        Schema::dropIfExists('est_entry_file_mutations');
    }
};
