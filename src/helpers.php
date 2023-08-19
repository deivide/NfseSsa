<?php

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

if (! function_exists('xml_view')) {

    /**
     * @param $view
     * @param $data
     * @return string
     * @throws Throwable
     */
    function xml_view($view, $data): string
    {
        $view = view("nfse-ssa::$view", ['dados' => $data]);

        return $view->render();
    }
}

if (! function_exists('array_get')) {

    /**
     * Get an item from an array using "dot" notation.
     *
     * @param  \ArrayAccess|array  $array
     * @param  string|int|null  $key
     * @param  mixed  $default
     * @return mixed
     */
    function array_get($array, $key): mixed
    {
        return Arr::get($array, $key);
    }
}

if (! function_exists('array_xml_get')) {

    /**
     * @param $array
     * @param $key
     * @return mixed
     */
    function array_xml_get($array, $key): mixed
    {
        if ($value = Arr::get($array, $key)) {
            $xmlTag = '<'.Str::studly($key).'>';
            $xmlCloseTag = '</'.Str::studly($key).'>';

            return $xmlTag.$value.$xmlCloseTag;
        }

        return null;
    }
}
