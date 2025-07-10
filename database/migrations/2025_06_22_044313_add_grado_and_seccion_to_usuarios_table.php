<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
    if (!Schema::hasColumn('usuarios', 'grado_id')) {
        $table->foreignId('grado_id')->nullable()->constrained('grados')->onDelete('set null');
    }

    if (!Schema::hasColumn('usuarios', 'seccion_id')) {
        $table->foreignId('seccion_id')->nullable()->constrained('secciones')->onDelete('set null');
    }
});
    }

    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropForeign(['grado_id']);
            $table->dropForeign(['seccion_id']);
            $table->dropColumn(['grado_id', 'seccion_id']);
        });
    }
};
