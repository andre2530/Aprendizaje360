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
    Schema::table('notas', function (Blueprint $table) {
        $table->year('anio')->after('valor')->default(date('Y'));
    });
}

public function down(): void
{
    Schema::table('notas', function (Blueprint $table) {
        $table->dropColumn('anio');
    });
}

};
