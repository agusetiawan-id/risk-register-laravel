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
            $table->enum('likelihood', ['Very Low', 'Low', 'Equal', 'High', 'Very High'])->change();
            $table->enum('consequences', ['Insignificant', 'Minor', 'Moderate', 'High', 'Severe'])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('risks', function (Blueprint $table) {
            // Revert to the previous enum definition
            $table->enum('likelihood', ['Rare', 'Unlikely', 'Possible', 'Likely', 'Almost Certain'])->change();
            $table->enum('consequences', ['Insignificant', 'Minor', 'Moderate', 'Major', 'Catastrophic'])->change();
        });
    }
};