<?php

use App\Models\Countries;
use App\Models\States;
use App\Models\Address;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;


if (!function_exists('list_themes')) {

    function list_themes($key)
    {
        $cacheKey = "theme_".get_config('site_theme')."_{$key}";
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }
        
        if ($key != '') {
            
            $value = DB::table('themes')->get();

            Cache::put($cacheKey, $value, now()->addMinutes(60));
            return $value;
            
        }
    }
}
if (!function_exists('get_theme_config')) {

    function get_theme_config($key)
    {
        $cacheKey = "theme_".get_config('site_theme')."_{$key}";
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }
        
        if ($key != '') {
            $active_theme = get_config('site_theme');
            $value = DB::table('theme_settings')->whereRaw("theme = '$active_theme' AND config_key = '$key'")->value('value');

            Cache::put($cacheKey, $value, now()->addMinutes(60));
            return $value;
            
        }
    }
}

if (!function_exists('get_theme_config_data')) {
    function get_theme_config_data($value, $theme)
    {
        $cacheKey = "theme_{$value}";
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }
        $contents = DB::table('themes')->whereRaw("slug = '$theme'")->value('theme_info');
        $var_json = json_decode($contents, true);

        
        if (!empty($var_json[$value])) {
                return $var_json[$value];
        }
        
    }
}


if (!function_exists('get_contents')) {

    function get_contents($key, $subkey = NULL, $all = NULL)
    {
        $cacheKey = "theme_" . get_config('site_theme') . "_{$key}";
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }
        if ($key != '') {
            $active_theme = get_config('site_theme');

            if ($subkey =='') {
            $contents =  (DB::table('theme_contents')->whereRaw("theme = '$active_theme' AND config_key = '$key'")->value('contents'));
            if (isset($all)) {
                $contents =  (DB::table('theme_contents')->whereRaw("theme = '$active_theme' AND config_key = '$key'")->get('contents'));
            }
            }

            if ($subkey) {
                $contents =  DB::table('theme_contents')->whereRaw("theme = '$active_theme' AND sub_key = '$subkey'")->get();
            }
            Cache::put($cacheKey, $contents, now()->addMinutes(60));
            return $contents;
        }

    }
}

if (!function_exists('get_contents_admin')) {

    function get_contents_admin($key, $subkey = NULL, $all = NULL)
    {
        
        if ($key != '') {
            $active_theme = get_config('site_theme');

            if ($subkey =='') {
            $contents =  get_content_locale(DB::table('theme_contents')->whereRaw("theme = '$active_theme' AND config_key = '$key'")->value('contents'));
            if (isset($all)) {
                $contents =  (DB::table('theme_contents')->whereRaw("theme = '$active_theme' AND config_key = '$key'")->value('contents'));
            }
            }

            if ($subkey) {
                $contents =  DB::table('theme_contents')->whereRaw("theme = '$active_theme' AND sub_key = '$subkey'")->get();
            }
           
            return $contents;
        }

    }
}

if (!function_exists('get_theme_dir')) {

    function get_theme_dir($key, $key2 = NULL)
    {

        if ($key == 'assets') {
            return 'assets/themes/' . get_config('site_theme');
        }
        if ($key == 'assets_dashboard') {
            return 'assets/dashboard';
        }
        if ($key == 'plugins') {
            return 'assets/plugins';
        }
        if ($key2 != '') {

            return ($key2 . '.' . $key);
        } else {
            return 'themes.' . get_config('site_theme') . '.' . $key;
        }
    }
}


function menu_active($route, $menutype = null)
{

    if ($menutype == 1) {
        $class = 'side-menu-open';
    } elseif ($menutype == 2) {
        $class = 'sidebar-submenu-open';
    } else {
        $class = 'active';
    }
    if (is_array($route)) {
        foreach ($route as $key => $value) {
            if (request()->routeIs($value)) {
                return $class;
            }
        }
    } elseif (request()->routeIs($route)) {
        return $class;
    }
}