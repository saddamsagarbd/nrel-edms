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
        Schema::create('crm_clients', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('email', 100)->nullable();
            $table->string('phone', 100);
            $table->string('prsnt_address', 100)->nullable();
            $table->string('ofc_address', 100)->nullable();
            $table->string('prmnt_address', 100)->nullable();
            $table->string('company', 100)->nullable();
            $table->string('client_source', 100)->nullable();
            $table->string('client_status', 100)->nullable();
            $table->enum('client_type' ,  array('client','landowner'));
            $table->integer('user_id')->nullable();
            $table->integer('company_id')->nullable();
            $table->integer('erp_client_id')->nullable();
            $table->string('others_owner', 100)->nullable();
            $table->unsignedBigInteger('account_id');
            //$table->foreign('account_id')->references('id')->on('crm_accounts');
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
        Schema::dropIfExists('crm_clients');
    }
};
