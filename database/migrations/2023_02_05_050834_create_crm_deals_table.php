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
        Schema::create('crm_deals', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount',10,2)->default(0.00);
            $table->string('deal_name', 100);
            $table->date('closing_date');
            $table->string('deal_stage', 100)->nullable();
            $table->unsignedBigInteger('account_id');
            //$table->foreign('account_id')->references('id')->on('crm_accounts');
            $table->unsignedBigInteger('client_id');
            //$table->foreign('client_id')->references('id')->on('crm_clients');
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
        Schema::dropIfExists('crm_deals');
    }
};
