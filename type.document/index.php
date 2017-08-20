<?php

function fn_type_document($input) {
    global $url;
    $d = PAGE . DS . $url->path;
    if (!$f = File::exist([
        $d . '.draft',
        $d . '.page',
        $d . '.archive'
    ])) {
        return $input;
    }
    if (!$content = Page::apart($f, 'content')) {
        return $input;
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
    return $type === 'Document' ? $content : $input;
}

Hook::set('shield.input', 'fn_type_document', 2);