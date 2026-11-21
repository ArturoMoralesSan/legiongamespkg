<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProtectedLinkTokensTable extends Migration
{
    /**
     * Tabla de tokens efimeros para el sistema de enlaces protegidos.
     * La URL real de destino se guarda aqui, en el servidor, y nunca
     * se envia al navegador. Solo se envia el "token" (opaco y con
     * expiracion), tal como en el proyecto de referencia Node.js.
     */
    public function up()
    {
        Schema::create('protected_link_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('token', 64)->unique();
            $table->text('destination_url');
            $table->unsignedInteger('max_uses')->default(1);
            $table->unsignedInteger('uses')->default(0);
            $table->timestamp('expires_at');
            $table->timestamps();

            $table->index('expires_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('protected_link_tokens');
    }
}