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
        Schema::table('est_entry_files', function (Blueprint $table) {
            $table->decimal('t_pur_rs', 15, 2)->nullable()->after('khatype_id');
            $table->string('m_jote')->nullable()->after('t_pur_rs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('est_entry_files', function (Blueprint $table) {
            if(Schema::hasColumn('est_entry_files', 't_pur_rs')) $table->dropColumn('t_pur_rs');
            if(Schema::hasColumn('est_entry_files', 'm_jote')) $table->dropColumn('m_jote');
        });
    }
};
