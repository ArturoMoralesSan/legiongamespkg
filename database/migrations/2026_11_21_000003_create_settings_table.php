<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Ajustes generales del sitio (clave => valor JSON) y enlace del panel
     * "Detección de AdBlock" dentro de Publicidad > Anuncios.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key', 100)->unique();
            $table->json('value')->nullable();
            $table->timestamps();
        });

        $submenuId = DB::table('dashboard_submenus')
            ->join('dashboard_sections', 'dashboard_sections.id', '=', 'dashboard_submenus.section_id')
            ->where('dashboard_sections.name', 'Publicidad')
            ->where('dashboard_submenus.name', 'Anuncios')
            ->value('dashboard_submenus.id');

        $permissionId = DB::table('permissions')->where('key_name', 'create.ads')->value('id');

        if ($submenuId && $permissionId) {
            DB::table('dashboard_links')->updateOrInsert(
                ['name' => 'Detección de AdBlock', 'submenu_id' => $submenuId],
                [
                    'route' => 'publicidad/adblock',
                    'order' => 3,
                    'permission_id' => $permissionId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }

    /**
     * @return void
     */
    public function down()
    {
        DB::table('dashboard_links')->where('route', 'publicidad/adblock')->delete();

        Schema::dropIfExists('settings');
    }
}
