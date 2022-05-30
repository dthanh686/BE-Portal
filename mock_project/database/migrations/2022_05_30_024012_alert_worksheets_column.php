<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlertWorksheetsColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('worksheets', function (Blueprint $table) {
            $table->string('late', 10)->default(null)->change();
            $table->string('early', 10)->default(null)->change();
            $table->string('in_office', 10)->default(null)->change();
            $table->string('ot_time', 10)->default(null)->change();
            $table->string('work_time', 10)->default(null)->change();
            $table->string('lack', 10)->default(null)->change();
            $table->string('compensation', 10)->default(null)->change();
            $table->string('paid_leave', 10)->default(null)->change();
            $table->string('unpaid_leave', 10)->default(null)->change();
            $table->string('note', 70)->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
