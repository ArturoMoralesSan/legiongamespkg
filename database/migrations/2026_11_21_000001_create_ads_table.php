<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAdsTable extends Migration
{
    /**
     * Tabla de anuncios + permisos + entrada en el menú del panel.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('position', 30);          // top, bottom, left, right, sidebar, content
            $table->json('pages')->nullable();        // null / [] = todas las páginas
            $table->string('type', 10)->default('code'); // code | image
            $table->text('code')->nullable();         // HTML / script (AdSense, etc.)
            $table->string('image', 150)->nullable(); // banner subido
            $table->string('link_url')->nullable();   // destino del banner
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('order')->default(0);
            $table->timestamps();

            $table->index(['is_active', 'position']);
        });

        $now = now();

        // Permisos
        foreach ([
            'view.ads'   => 'Ver anuncios',
            'create.ads' => 'Crear anuncios',
        ] as $key => $name) {
            if (! DB::table('permissions')->where('key_name', $key)->exists()) {
                DB::table('permissions')->insert([
                    'name' => $name,
                    'key_name' => $key,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }

        $permissions = DB::table('permissions')
            ->whereIn('key_name', ['view.ads', 'create.ads'])
            ->pluck('id', 'key_name');

        // Menú del panel: sección "Publicidad" > submenú "Anuncios"
        $sectionId = DB::table('dashboard_sections')->where('name', 'Publicidad')->value('id')
            ?: DB::table('dashboard_sections')->insertGetId([
                'name' => 'Publicidad',
                'tile' => 'banners.svg',
                'order' => (int) DB::table('dashboard_sections')->max('order') + 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

        $submenuId = DB::table('dashboard_submenus')
            ->where(['name' => 'Anuncios', 'section_id' => $sectionId])
            ->value('id')
            ?: DB::table('dashboard_submenus')->insertGetId([
                'name' => 'Anuncios',
                'icon' => 'banners.svg',
                'order' => 1,
                'section_id' => $sectionId,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

        foreach ([
            ['Agregar anuncio', 'anuncios/create', 'create.ads', 1],
            ['Lista de anuncios', 'anuncios', 'view.ads', 2],
        ] as [$name, $route, $permission, $order]) {
            DB::table('dashboard_links')->updateOrInsert(
                ['name' => $name, 'submenu_id' => $submenuId],
                [
                    'route' => $route,
                    'order' => $order,
                    'permission_id' => $permissions[$permission],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }
    }

    /**
     * @return void
     */
    public function down()
    {
        $sectionId = DB::table('dashboard_sections')->where('name', 'Publicidad')->value('id');

        if ($sectionId) {
            $submenuIds = DB::table('dashboard_submenus')->where('section_id', $sectionId)->pluck('id');
            DB::table('dashboard_links')->whereIn('submenu_id', $submenuIds)->delete();
            DB::table('dashboard_submenus')->where('section_id', $sectionId)->delete();
            DB::table('dashboard_sections')->where('id', $sectionId)->delete();
        }

        DB::table('permissions')->whereIn('key_name', ['view.ads', 'create.ads'])->delete();

        Schema::dropIfExists('ads');
    }
}
