<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Enlaces protegidos - configuracion
    |--------------------------------------------------------------------------
    |
    | ttl_seconds: cuanto tiempo, en segundos, es valido un token desde que
    | se genera. Por defecto 180 (3 minutos), igual que el proyecto de
    | referencia Node.js.
    |
    | max_uses: cuantas veces se puede usar un mismo token antes de quedar
    | invalido. 1 = un solo uso (recomendado). 0 = ilimitado mientras no
    | expire.
    |
    */

    'ttl_seconds' => (int) env('PROTECTED_LINK_TTL_SECONDS', 25),

    'max_uses' => (int) env('PROTECTED_LINK_MAX_USES', 1),

];