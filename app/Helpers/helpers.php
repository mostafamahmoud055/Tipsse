<?php

use App\Helpers\MenuHelper;

if (! function_exists('menu_icon')) {
    function menu_icon(string $name): string
    {
        return MenuHelper::getIconSvg($name);
    }
}

if (!function_exists('current_month')) {
    /**
     * Get the current month name.
     *
     * @param string $format Optional. 'F' for full month, 'M' for short month. Default 'F'.
     * @return string
     */
    function current_month($format = 'M'): string
    {
        return date($format);
    }
}

