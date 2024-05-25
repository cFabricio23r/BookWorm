<?php

if (! function_exists('get_request_string_default_null')) {
    function get_request_string_default_null(string $key): ?string
    {
        if (request()->exists($key)) {
            return request()->str($key);
        }

        return null;
    }
}
