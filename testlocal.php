<?php

function replaceInFiles($directory) {
    if (!is_dir($directory)) {
        die("Указанная директория не существует");
    }

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($directory)
    );

    foreach ($iterator as $file) {
        if ($file->getExtension() === 'php') {
            $filePath = $file->getRealPath();
            $content = file_get_contents($filePath);
            $newContent = str_replace('frontend', 'app', $content);
            file_put_contents($filePath, $newContent);
            echo "Файл $filePath успешно отредактирован.\n";
        }
    }
}

$directory = '/work/sites/yiiprojects/appbasic/basic/modules/takedatam';
replaceInFiles($directory);

?>