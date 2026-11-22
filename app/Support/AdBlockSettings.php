<?php

namespace App\Support;

use App\Models\Setting;

/**
 * Configuración de la detección de AdBlock (Panel > Publicidad > Detección de AdBlock).
 */
class AdBlockSettings
{
    const KEY = 'adblock';

    /**
     * Valores por defecto: así se comportaba el sitio antes del panel.
     *
     * @return array
     */
    public static function defaults()
    {
        return [
            // Aviso en el sitio
            'enabled' => true,
            'mode' => 'soft',            // soft = se puede cerrar | block = no se puede cerrar
            'pages' => [],               // vacío = todas (claves de config('ads.pages'))
            'remember_dismiss' => true,  // al cerrarlo no vuelve a salir en la sesión
            'title' => '¿Usas un bloqueador de anuncios?',
            'message' => 'Los anuncios nos ayudan a mantener el sitio gratis y los enlaces activos. '
                . 'Agrega este sitio a la lista de excepciones de tu bloqueador '
                . '(o desactiva los escudos de Brave / Opera) y recarga la página.',

            // Página de descarga
            'download_block' => true,    // bloquear la descarga si tiene AdBlock
        ];
    }

    /**
     * @return array
     */
    public static function all()
    {
        return array_merge(static::defaults(), (array) Setting::get(static::KEY, []));
    }

    /**
     * @param  array  $values
     * @return void
     */
    public static function save(array $values)
    {
        Setting::put(static::KEY, array_merge(static::all(), $values));
    }

    /**
     * ¿Se debe mostrar el aviso en la página actual?
     *
     * @return bool
     */
    public static function noticeAppliesHere()
    {
        $settings = static::all();

        if (! $settings['enabled']) {
            return false;
        }

        // La página de descarga tiene su propio bloqueo.
        if ($settings['download_block'] && AdManager::currentPage() === 'download') {
            return false;
        }

        return empty($settings['pages'])
            || in_array(AdManager::currentPage(), $settings['pages'], true);
    }
}
