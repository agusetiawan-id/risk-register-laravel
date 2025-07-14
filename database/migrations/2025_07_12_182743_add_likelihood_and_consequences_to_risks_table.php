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
        Schema::table('risks', function (Blueprint $table) {
            $table->enum('likelihood', ['Rare', 'Unlikely', 'Possible', 'Likely', 'Almost Certain'])->after('description');
            $table->enum('consequences', ['Insignificant', 'Minor', 'Moderate', 'Major', 'Catastrophic'])->after('likelihood');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('risks', function (Blueprint $table) {
            $table->dropColumn(['likelihood', 'consequences']);
        });
    }
};
