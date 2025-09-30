<?php

use App\Models\Setting;

if (!function_exists('setting')) {
    function setting()
    {
        return new class {
            public function all()
            {
                return Setting::pluck('value', 'key')->toArray();
            }

            public function get($key, $default = null)
            {
                return Setting::where('key', $key)->value('value') ?? $default;
            }
        };
    }
}
