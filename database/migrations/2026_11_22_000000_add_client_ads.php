<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AddClientAds extends Migration
{
    /**
     * Anuncios enviados por el cliente el 21/11/2026:
     * pop-under (script global) y banner in-page.
     *
     * @return void
     */
    public function up()
    {
        $now = now();

        $ads = [
            [
                'name' => 'Pop-under (cloudfront)',
                'position' => 'global',
                'code' => '<script data-cfasync="false" src="//dc9xwpjprguup.cloudfront.net/?pwxcd=1451810"></script>',
                'use_iframe' => false,
                'iframe_height' => null,
                'closable' => false,
                'order' => 0,
            ],
            [
                'name' => 'Banner (untimely-hello)',
                'position' => 'top',
                'code' => <<<'HTML'
<script>
(function(lkrni){
var d = document,
    s = d.createElement('script'),
    l = d.currentScript || d.scripts[d.scripts.length - 1];
s.settings = lkrni || {};
s.src = "\/\/untimely-hello.com\/bKXvV\/s.doGRlC0zYjWmcl\/pe\/m-9eueZwUvlIkZPIT\/czzyOhTbIy4HNTTyM-tANPzdMo5hMFjcgI1VNUwD";
s.async = true;
s.referrerPolicy = 'no-referrer-when-downgrade';
l.parentNode.insertBefore(s, l);
})({})
</script>
HTML,
                'use_iframe' => true,
                'iframe_height' => 250,
                'closable' => false,
                'order' => 10,
            ],
        ];

        foreach ($ads as $ad) {
            if (DB::table('ads')->where('name', $ad['name'])->exists()) {
                continue;
            }

            DB::table('ads')->insert($ad + [
                'pages' => null,
                'type' => 'code',
                'delay_seconds' => 0,
                'refresh_seconds' => 0,
                'reopen_seconds' => 0,
                'is_active' => true,
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
        DB::table('ads')->whereIn('name', ['Pop-under (cloudfront)', 'Banner (untimely-hello)'])->delete();

        Cache::forget('ads.active');
    }
}
