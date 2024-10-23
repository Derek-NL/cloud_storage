<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('shared_files', function (Blueprint $table) {
            $table->unsignedBigInteger('shared_by')->after('user_id')->nullable();
        });
    }

    public function down()
    {
        Schema::table('shared_files', function (Blueprint $table) {
            $table->dropColumn('shared_by');
        });
    }
};
