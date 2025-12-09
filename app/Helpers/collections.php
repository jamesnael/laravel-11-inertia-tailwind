<?php

use Illuminate\Support\Facades\Route;

if (! function_exists('prepare_main_menu')) {
    function prepare_main_menu() {
        $reservedKeywords = [
          '.index',
          '.create-sub',
          '.create',
          '.dokumen',
          '.position-sub',
          '.position',
          '.meta-sub',
          '.edit-sub',
          '.sub-menu',
          '.edit',
          '.show',
          '.detail',
          '.view',
          '.meta',
        ];
        $main_menu = collect(config('main-menu.menu'));
        $currentRoute = str_replace_multiple($reservedKeywords, '', Route::currentRouteName());
        $main_menu->transform(function($menu) use ($currentRoute, $reservedKeywords) {
            if ($menu['type'] == 'menu') {
                if ($menu['children'] == null || count($menu['children']) == 0) {
                    $menu['active'] = str_replace_multiple($reservedKeywords, '', $menu['route']) == $currentRoute;
                } else {
                    $child = collect($menu['children'])->map(function($item) use ($reservedKeywords,$currentRoute) {
                        $item['route'] = str_replace_multiple($reservedKeywords, '', $item['route']);

                        if(is_array($item['route'])){
                            $item['check'] = in_array($currentRoute,$item['route']) ? true : false;
                        } else {
                            $item['check'] = false;
                        }
                        
                        return $item;
                    });

                    $exist = $child->where('check', true)->first();

                    if(!$exist) {
                        $exist = $child->where('route',$currentRoute)->first();
                    }

                    if ($exist) {
                        $menu['active'] = true;
                        $menu['open'] = true;
                        $menu['children'] = collect($menu['children'])->transform(function($submenu) use ($currentRoute, $reservedKeywords) {
                            if ($submenu['type'] == 'menu') {
                                if(is_array($submenu['route'])){
                                    $route = str_replace_multiple($reservedKeywords, '', $submenu['route']);
                                    $submenu['active'] = in_array($currentRoute,$route) ? true : false;
                                    $submenu['open'] = in_array($currentRoute,$route) ? true : false;
                                } else {
                                    $submenu['active'] = str_replace_multiple($reservedKeywords, '', $submenu['route']) == $currentRoute;
                                    $submenu['open'] = str_replace_multiple($reservedKeywords, '', $submenu['route']) == $currentRoute;
                                }

                            }

                            if($submenu['children']) {
                                $submenu['children'] = collect($submenu['children'])->transform(function($subsubmenu) use ($submenu,$currentRoute, $reservedKeywords) {
                                    if ($subsubmenu['type'] == 'menu') {
                                        $subsubmenu['active'] = str_replace_multiple($reservedKeywords, '', $subsubmenu['route']) == $currentRoute;
                                        $subsubmenu['open'] = str_replace_multiple($reservedKeywords, '', $subsubmenu['route']) == $currentRoute;
                                    }
                                    return $subsubmenu;
                                });
                            }

                            return $submenu;
                        });
                    }
                }
            }
            return $menu;
        });
        return $main_menu;
    }
}

if (! function_exists('str_replace_multiple')) {
    function str_replace_multiple(array $search, $replace, $string) {
        foreach ($search as $term) {
            $string = str_replace($term, $replace, $string);
        }
        return $string;
    }
}

if (! function_exists('response_json')) {
    function response_json($success = false, $error = null, $message = '', $data = null, array $misc = [])
    {
        $response = [
            'success' => $success,
            'error' => $error,
            'message' => $message
        ];

        $response['data'] = $data;

        $response = collect($response)->merge($misc);

        return response()->json($response);
    }
}

if (! function_exists('format_money')) {
    function format_money($value=0, $showZero = true)
    {
        if ($showZero) {
            return number_format($value, 0, ',', '.');
        }
        return $value > 0 ? number_format($value, 0, ',', '.') : null;
    }
}

if (! function_exists('get_file_url')) {
    function get_file_url($disk_name = 'public', $file_name) {
        if ($file_name) {
            return Storage::disk($disk_name)->url($file_name);
        }

        return $file_name;
    }
}

if (! function_exists('log_activity')) {
    function log_activity($description, $model, $extra = [], $causer = null, $log_name = null) {
        $properties = [];
        if (is_array($model)) {
            foreach ($model as $key => $value) {
                $properties[] = collect([
                                    'attributes' => $value->getOriginal() ?? null,
                                    'changes' => $value->getChanges() ?? null,
                                ])->merge($extra);
            }
        } else {
            $properties[] = collect([
                                'attributes' => $model->getOriginal() ?? null,
                                'changes' => $model->getChanges() ?? null,
                            ])->merge($extra);
        }

        activity($log_name ?: config('activitylog.default_log_name', 'default'))
            ->by($causer ?: (Auth::user() ?? null))
            ->withProperties($properties)
            ->log($description);
    }
}

if (!function_exists('formatRupiahRange')) {
    function formatRupiahRange($min, $max)
    {
        return formatRupiahShort($min) . ' - ' . formatRupiahShort($max);
    }
}

if (!function_exists('formatRupiahShort')) {
    function formatRupiahShort($number)
    {
        if ($number >= 1_000_000_000_000) { // >= 1 Triliun
            return floor($number / 1_000_000_000_000) . ' Triliun';
        } elseif ($number >= 1_000_000_000) { // >= 1 Miliar
            return floor($number / 1_000_000_000) . ' Miliar';
        } elseif ($number >= 1_000_000) { // >= 1 Juta
            return floor($number / 1_000_000) . ' Juta';
        } elseif ($number >= 1_000) { // >= ribuan
            return number_format($number, 0, ',', '.');
        }

        return $number;
    }
}

if (!function_exists('encryptID')) {
    function encryptID($id)
    {
        $encrypt_method = 'AES-256-CBC';
        $secret_key = 'Some#Random_Key!';
        $secret_iv = '!IV@_$2';

        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        
        $data = openssl_encrypt($id, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($data);
        return $output;
    }
}

if (!function_exists('decryptID')) {
    function decryptID($id)
    {
        $encrypt_method = 'AES-256-CBC';
        $secret_key = 'Some#Random_Key!';
        $secret_iv = '!IV@_$2';

        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        $data = base64_decode($id);
        $output = openssl_decrypt($data, $encrypt_method, $key, 0, $iv);
        return $output;
    }
}