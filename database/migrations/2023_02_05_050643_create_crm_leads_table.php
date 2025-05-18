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
        Schema::create('crm_leads', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('email', 100);
            $table->string('phone', 100);
            $table->string('company', 100)->nullable();
            $table->string('lead_source', 100)->nullable();
            $table->string('lead_status', 100)->nullable();
            $table->string('street', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('zip_code', 100)->nullable();
            $table->string('description', 100)->nullable();
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
        Schema::dropIfExists('crm_leads');
    }
};
