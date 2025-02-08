<?php

function asset($path)
{
    return APP_URL . 'Assets/' . $path;
}

function view($view, $data = [])
{
    extract($data);
    ob_start();
    include __DIR__ . '/../resources/views/' . $view . '.php';
    $content = ob_get_clean();
    return preg_replace_callback('/\{\{\s*(.+?)\s*\}\}/', function ($matches) {
        return '<?php echo ' . $matches[1] . '; ?>';
    }, $content);
}
