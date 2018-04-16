<?php

function fn_type_document($yield) {
    global $url;
    $d = PAGE . DS . $url->path;
    if (!$f = File::exist([
        $d . '.page',
        $d . '.archive'
    ])) {
        return $yield;
    }
    if (!$content = Page::apart($f, 'content')) {
        return $yield;
    }
    if (($type = Page::apart($f, 'type', false)) === false) {
        $s = strtolower($content);
        if (substr($s, -7) === '</html>' && (
            strpos($s, '<html>') !== false ||
            strpos($s, '<html ') !== false
        )) {
            $type = 'Document';
        }
    }
    if ($status = Page::apart($f, 'status')) {
        HTTP::status($status);
    }
    return $type === 'Document' ? $content : $yield;
}

Hook::set('shield.yield', 'fn_type_document', 2);