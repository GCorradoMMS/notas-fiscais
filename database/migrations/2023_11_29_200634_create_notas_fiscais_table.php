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
        Schema::create('notas_fiscais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')
                ->constrained('users')
                ->onUpdate('cascade')
                ->comment("Identificador do usuario responsavel pelo cadastro");
            $table->string('numero', 9)->unique()->default('999999999')->comment("Identificador único do documento");
            $table->decimal('valor', 10, 2)->unsigned()->default(50.20)->comment("Valor da nota fiscal");
            $table->date('data_emissao')->default('2000-01-01')->comment("Dia da emissão do documento.");
            $table->string('cnpj_remetente', 18)->default('44.091.875/0001-11')->comment("Identificador do remetente da nota.");
            $table->string('nome_remetente', 100)->default('João Cargueiro')->comment("Nome do remetente da nota");
            $table->string('cnpj_transportador', 18)->default('44.091.875/0021-11')->nullable()->comment("Identificador do transportador da nota.");
            $table->string('nome_transportador', 100)->default('Melhor Fretista do Mundo')->nullable()->comment("Nome do transportador da nota");
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notas_fiscais');
    }
};
