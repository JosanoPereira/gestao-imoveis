<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('provincias', function (Blueprint $table) {
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->id();
            $table->string('provincia');
            $table->string('sigla', 20)->nullable();
            $table->timestamps();
        });

        Schema::create('municipios', function (Blueprint $table) {
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->id();
            $table->foreignId('provincias_id')
                ->constrained()->cascadeOnDelete();
            $table->string('municipio');
            $table->timestamps();
        });

        Schema::create('enderecos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('municipios_id')
                ->constrained()->cascadeOnDelete();
            $table->string('endereco');
            $table->string('bairro')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provincias');
        Schema::dropIfExists('municipios');
        Schema::dropIfExists('enderecos');
    }
};
