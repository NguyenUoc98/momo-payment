<?php
/**
 * Created by PhpStorm.
 * Filename: helper.php
 * User: Nguyễn Văn Ước
 * Date: 29/12/2021
 * Time: 14:07
 */

if (!function_exists('config')) {
    /**
     * Get / set the specified configuration value.
     *
     * If an array is passed as the key, we will assume you want to set an array of values.
     *
     * @param string $key
     * @param mixed $default
     */
    function config($key, $default = null)
    {
        $config_files = __DIR__ . "/../config";

        $keys   = explode(".", $key);
        $config = require_once "$config_files/{$keys[0]}.php";
        $level  = 1;
        $deep   = count($keys);
        while ($config && $level < $deep) {
            if (isset($config[$keys[$level]])) {
                $config = $config[$keys[$level]];
                $level++;
            } else {
                return $default;
            }
        }
        return $config;
    }
}
