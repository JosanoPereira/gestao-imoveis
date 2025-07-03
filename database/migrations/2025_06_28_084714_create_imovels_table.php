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
        Schema::create('imoveis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enderecos_id')->constrained();
            $table->decimal('area_util')->nullable();
            $table->integer('numero_compartimentos')->default(1);
            $table->text('estado_conservacao')->nullable();
            $table->foreignId('tipologias_id')->constrained();
            $table->foreignId('property_types_id')->constrained();
            $table->foreignId('proprietarios_id')->nullable()->constrained();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('imoveis_imagens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('imoveis_id')->constrained();
            $table->text('image');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('documentos', function (Blueprint $table) {
            $table->foreignId('clientes_id')->nullable()->change();
            $table->foreignId('imoveis_id')->nullable()->after('clientes_id')->constrained();
            $table->foreignId('proprietarios_id')->nullable()->after('imoveis_id')->constrained();
        });

        Schema::table('enderecos', function (Blueprint $table) {
            $table->foreignId('clientes_id')->nullable()->change();
            $table->foreignId('imoveis_id')->nullable()->after('clientes_id')->constrained();
            $table->foreignId('proprietarios_id')->nullable()->after('imoveis_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imoveis');
        Schema::dropIfExists('imoveis_imagens');

        Schema::table('documentos', function (Blueprint $table) {
            $table->foreignId('clientes_id')->nullable(false)->change()->constrained();
            $table->dropConstrainedForeignId('imoveis_id');
            $table->dropConstrainedForeignId('proprietarios_id');
        });

        Schema::table('enderecos', function (Blueprint $table) {
            $table->foreignId('clientes_id')->nullable(false)->change()->constrained();
            $table->dropConstrainedForeignId('imoveis_id');
            $table->dropConstrainedForeignId('proprietarios_id');
        });
    }
};
