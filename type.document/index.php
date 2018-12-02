<?php namespace fn\type;

function document($yield) {
    global $url;
    $path = PAGE . DS . $url->path(DS);
    if (!$f = \File::exist([
        $path . '.page',
        $path . '.archive'
    ])) {
        return $yield;
    }
    if (!$content = \Page::apart($f, 'content')) {
        return $yield;
    }
    if (!$type = \Page::apart($f, 'type')) {
        $test = strtolower($content);
        if (substr($test, -7) === '</html>' && (
            strpos($test, '<html>') !== false ||
            strpos($test, '<html ') !== false
        )) {
            $type = 'Document';
        }
    }
    if ($status = \Page::apart($f, 'status')) {
        \HTTP::status($status);
    }
    return $type === 'Document' ? $content : $yield;
}

\Hook::set('shield.yield', __NAMESPACE__ . "\\document", 2);