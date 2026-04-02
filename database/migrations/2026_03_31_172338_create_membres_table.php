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
        Schema::create('membres', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nom')->nullable();
            $table->string('prenom')->nullable();
            $table->date('datefinstage')->nullable();
            $table->string('tel')->nullable();
            $table->enum('statut', ['Actif', 'Suspendu', 'Inactif', 'Exclu'])->default('Actif');
            $table->date('dateinscription')->nullable();
            $table->string('email')->unique();
            $table->string('civilite',5)->nullable()->default('Mr');
            $table->timestamps();
        });

        Schema::create('typeannonces', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('typeannonce')->nullable();
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('typearticles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('typearticle')->nullable();
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('typemessages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('typemessage')->nullable();
            $table->string('slug')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membres');
        Schema::dropIfExists('typeannonces');
        Schema::dropIfExists('typearticles');
        Schema::dropIfExists('typemessages');
    }
};
