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
        Schema::create('documentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clientes_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tipo_documentos_id')->constrained()->cascadeOnDelete();
            $table->string('numero');
            $table->date('emissao');
            $table->date('validade')->nullable();
            $table->boolean('vitalicio')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos');
    }
};
