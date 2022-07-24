<?php

$request = urldecode($_SERVER['REQUEST_URI']);
$url = 'https://www.flex-tools.com' . $request;
$file = substr($request, 1);

$pos = strrpos($request, '.');
if ($pos) {
    $ext = substr($request, $pos + 1, 3);
    if ($ext == 'web') {
        $ext = 'webp';
    }
    if ($ext == 'jpe') {
        $ext = 'jpeg';
    }
}
else {
    $ext = 'html';
    $file .= '/index.html';
}

function l($m)
{
    file_put_contents('log.txt', $m . "\n", FILE_APPEND);
}

function cleanHtml($html)
{
    $html = preg_replace('#<script id="gtm">.+src="https://app.usercentrics.eu/browser-ui/latest/loader.js" async=""></script>#sU', '', $html);
    $s = '<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PZTBRR9" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>';
    $html = str_replace($s, '', $html);
    return $html;
}

if (file_exists($file)) {
    l('exists -- ' . $ext . ' - ' . $file);
}
else {
    $dir = pathinfo($file, PATHINFO_DIRNAME);
    $content = file_get_contents($url);
    if ($content) {
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        if ($ext == 'html') {
            $content = cleanHtml($content);
        }
        $saved = file_put_contents($file, $content);
        if ($saved) {
            l("file saved $file");
            echo $content;
        }

    }
    else {
        l("file not loaded $url");
    }

}
