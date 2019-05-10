<?php namespace _\type;

function document($v) {
    $path = PAGE . $GLOBALS['URL']['path'];
    if (!$f = \File::exist([
        $path . '.page',
        $path . '.archive'
    ])) {
        return $v;
    }
    $f = file_get_contents($f);
    if (!$content = \Page::apart($f, 'content')) {
        return $v;
    }
    if (!$type = \Page::apart($f, 'type')) {
        $test = \strtolower($content);
        if (\substr($test, -7) === '</html>' && (
            \strpos($test, '<html>') !== false ||
            \strpos($test, '<html ') !== false
        )) {
            $type = 'Document';
        }
    }
    if ($status = \Page::apart($f, 'status')) {
        \HTTP::status($status);
    }
    return $type === 'Document' ? $content : $v;
}

\Hook::set('content', __NAMESPACE__ . "\\document", 2);