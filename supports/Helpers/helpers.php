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

if (! function_exists('per_page_from_request')) {
    function per_page_from_request(): int
    {
        return request()->integer(
            key: config('app.per_page_filter_name'),
            default: config('app.per_page')
        );
    }
}
