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
            $table->foreignId('usuario_id')
                ->constrained('users')
                ->onUpdate('cascade')
                ->comment("Identificador do usuario responsavel pelo cadastro");
            $table->string('numero', 9)->unique()->comment("Identificador único do documento");
            $table->decimal('valor', 10, 2)->unsigned()->comment("Valor da nota fiscal");
            $table->date('data_emissao')->comment("Dia da emissão do documento.");
            $table->string('cnpj_remetente', 14)->comment("Identificador do remetente da nota.");
            $table->string('nome_remetente', 100)->comment("Nome do remetente da nota");
            $table->string('cnpj_transportador', 14)->nullable()->comment("Identificador do transportador da nota.");
            $table->string('nome_transportador', 100)->nullable()->comment("Nome do transportador da nota");
            $table->unique('cnpj_remetente');
            $table->unique('cnpj_transportador')->nullable();
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
