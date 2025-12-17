<?php
define('BASE_URL', 'http://localhost/DWO/');

function base_url(string $path = ''): string
{
    return rtrim(BASE_URL, '/') . '/' . ltrim($path, '/');
}
