<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNotesToGamesTable extends Migration
{
    /**
     * Notas rápidas por juego (se muestran en la página del juego).
     *
     * @return void
     */
    public function up()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->text('notes')->nullable()->after('synopsis');
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropColumn('notes');
        });
    }
}
