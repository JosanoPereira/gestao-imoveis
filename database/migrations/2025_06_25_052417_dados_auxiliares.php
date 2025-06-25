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
        Schema::create('tipo_clientes', function (Blueprint $table) {
            $table->id();
            $table->string('tipo');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('tipo_documentos', function (Blueprint $table) {
            $table->id();
            $table->string('tipo');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('generos', function (Blueprint $table) {
            $table->id();
            $table->string('genero');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('estado_civil', function (Blueprint $table) {
            $table->id();
            $table->string('estado');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('pessoas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->date('data_nascimento')->nullable();
            $table->foreignId('generos_id')->constrained('generos')->cascadeOnUpdate();
            $table->foreignId('estado_civil_id')->constrained('estado_civil')->cascadeOnUpdate();
            $table->string('nacionalidade')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->string('nome_social');
            $table->string('nome_fantasia')->nullable();
            $table->string('tipo_empresa')->nullable();
            $table->string('responsavel')->nullable();
            $table->date('data_registo')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_clientes');
        Schema::dropIfExists('tipo_documentos');
        Schema::dropIfExists('generos');
        Schema::dropIfExists('estado_civil');
        Schema::dropIfExists('pessoas');
        Schema::dropIfExists('empresas');
    }
};
