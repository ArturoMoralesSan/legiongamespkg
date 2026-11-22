<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddBehaviorToAdsTable extends Migration
{
    /**
     * Comportamiento de los anuncios (iframe, tiempos, cerrar) y migración
     * de los anuncios que estaban escritos a mano en master.blade.php y
     * partials/sidebar.blade.php.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->boolean('use_iframe')->default(false)->after('link_url');
            $table->unsignedSmallInteger('iframe_height')->nullable()->after('use_iframe');
            $table->boolean('closable')->default(false)->after('iframe_height');
            $table->unsignedSmallInteger('delay_seconds')->default(0)->after('closable');
            $table->unsignedSmallInteger('refresh_seconds')->default(0)->after('delay_seconds');
            $table->unsignedSmallInteger('reopen_seconds')->default(0)->after('refresh_seconds');
        });

        $now = now();

        $legacy = [
            [
                'name' => 'RX - Ventana modal',
                'position' => 'modal',
                'code' => '<script data-cfasync="false" src="//untimely-hello.com/bqXGV.s/dPGIlS0xYCW/cb/XeSma9TuQZ/UClykEPMTccrzEOKDSgR5/ORDSkUtaNXzdMJ4/ODDSkk5NMhwF"></script>',
                'iframe_height' => 250,
                'delay_seconds' => 8,
                'refresh_seconds' => 20,
                'reopen_seconds' => 20,
            ],
            [
                'name' => 'RX - Ancla inferior',
                'position' => 'anchor',
                'code' => '<script data-cfasync="false" src="//untimely-hello.com/bqXGV.s/dPGIlS0xYCW/cb/XeSma9TuQZ/UClykEPMTccrzEOKDSgR5/ORDSkUtaNXzdMJ4/ODDSkk5NMhwF"></script>',
                'iframe_height' => 90,
                'delay_seconds' => 0,
                'refresh_seconds' => 30,
                'reopen_seconds' => 30,
            ],
            [
                'name' => 'RX - Banner barra lateral',
                'position' => 'sidebar',
                'code' => '<script data-cfasync="false" src="//untimely-hello.com/b/XNV.sPdYGfl/0/Y/WpcG/zeomS9zu_ZMUBlMknPxTVcaz_O/TgIu4SNNT_Mqt/N/zMMw5CMpj/gZ1HNBwZ"></script>',
                'iframe_height' => 250,
                'delay_seconds' => 0,
                'refresh_seconds' => 20,
                'reopen_seconds' => 20,
            ],
            [
                // Estaba en principal/await.blade.php, se mostraba en línea.
                'name' => 'RX - Página de descarga',
                'position' => 'content',
                'pages' => json_encode(['download']),
                'code' => '<script data-cfasync="false" src="//untimely-hello.com/b/XNV.sPdYGfl/0/Y/WpcG/zeomS9zu_ZMUBlMknPxTVcaz_O/TgIu4SNNT_Mqt/N/zMMw5CMpj/gZ1HNBwZ"></script>',
                'use_iframe' => false,
                'closable' => false,
                'iframe_height' => null,
                'delay_seconds' => 0,
                'refresh_seconds' => 0,
                'reopen_seconds' => 0,
            ],
        ];

        foreach ($legacy as $i => $ad) {
            if (DB::table('ads')->where('name', $ad['name'])->exists()) {
                continue;
            }

            // $ad va primero: sus valores ganan sobre los de por defecto.
            DB::table('ads')->insert($ad + [
                'pages' => null, // todas las páginas, como antes
                'type' => 'code',
                'use_iframe' => true,
                'closable' => true,
                'is_active' => true,
                'order' => $i,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        Cache::forget('ads.active');
    }

    /**
     * @return void
     */
    public function down()
    {
        DB::table('ads')->whereIn('name', [
            'RX - Ventana modal',
            'RX - Ancla inferior',
            'RX - Banner barra lateral',
            'RX - Página de descarga',
        ])->delete();

        Schema::table('ads', function (Blueprint $table) {
            $table->dropColumn([
                'use_iframe',
                'iframe_height',
                'closable',
                'delay_seconds',
                'refresh_seconds',
                'reopen_seconds',
            ]);
        });

        Cache::forget('ads.active');
    }
}
