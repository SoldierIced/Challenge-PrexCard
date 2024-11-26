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
        Schema::create('gifs', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('url')->nullable();
            $table->string('slug')->nullable();
            $table->string('embed_url')->nullable();
            $table->string('username')->nullable();
            $table->string('source')->nullable();
            $table->string('title')->nullable();
            $table->string('source_tld')->nullable();
            $table->string('alt_text')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gifs');
    }
};
