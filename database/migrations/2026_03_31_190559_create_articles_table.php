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
        Schema::create('articles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('article');
            $table->string('chapeau');
            $table->string('auteur',100);
            $table->string('source',100);
            $table->string('slug')->unique();
            $table->string('keyword',500);
            $table->text('image');
            $table->tinyText('titre');
            $table->integer('hit')->default(0);
            $table->date('datearticle')->index();
            $table->foreignUuid('pays_id')->constrained();
            $table->foreignUuid('typearticle_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
