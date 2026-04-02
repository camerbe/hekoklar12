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
        Schema::create('binomes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->date('datereception');
            $table->integer('annee');

            $table->foreignUuid('membre1_id')
                ->constrained('membres')
                ->cascadeOnDelete();

            $table->foreignUuid('membre2_id')
                ->constrained('membres')
                ->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['annee', 'membre1_id']);
            $table->unique(['annee', 'membre2_id']);

            $table->unique('datereception');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('binomes');
    }
};
