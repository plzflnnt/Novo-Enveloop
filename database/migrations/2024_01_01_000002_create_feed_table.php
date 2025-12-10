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
        Schema::create('feed', function (Blueprint $table) {
            $table->id();
            $table->string('name', 225)->default('Saldo');
            $table->integer('type')->default(1)->comment('1=balance earning, 2=envelope earning, 3=balance expense, 4=envelope expense');
            $table->string('value', 50)->comment('Valor em centavos');
            $table->unsignedBigInteger('envelope_id')->default(0);
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamp('valid_at')->nullable()->comment('Data da transação');
            $table->timestamps();
            
            // Índices para otimização de consultas
            $table->index(['user_id', 'type']);
            $table->index(['envelope_id', 'type']);
            $table->index('valid_at');
            
            // Foreign key para envelopes (quando envelope_id > 1)
            // Não colocamos constraint porque envelope_id=1 é um valor especial para "saldo"
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feed');
    }
};
