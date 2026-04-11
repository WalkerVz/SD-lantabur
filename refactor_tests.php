<?php
$dir = __DIR__ . '/tests/Feature';
$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));

foreach ($it as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $path = $file->getRealPath();
        $content = file_get_contents($path);
        
        if (strpos($content, '/** @test */') !== false) {
             if (strpos($content, 'use PHPUnit\Framework\Attributes\Test;') === false) {
                 $content = preg_replace('/namespace (.*);/', "namespace $1;\n\nuse PHPUnit\Framework\Attributes\Test;", $content);
             }
             $content = str_replace('/** @test */', '#[Test]', $content);
             file_put_contents($path, $content);
             echo "Refactored: " . $path . PHP_EOL;
        }
    }
}
