<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('shared_files', function (Blueprint $table) {
            $table->string('email')->after('file_id'); // Voeg de email kolom toe
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shared_files', function (Blueprint $table) {
            $table->dropColumn('email'); // Verwijder de email kolom als de migratie wordt teruggedraaid
        });
    }
};
