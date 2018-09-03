<?php

require __DIR__ . '/vendor/autoload.php';

use PhpParser\NodeDumper;
use ItDependsOn\FileUtils\FileReader;
use ItDependsOn\FileUtils\FileIterator;
use ItDependsOn\DependencyParser\DependencyParserFactory;

$parser = DependencyParserFactory::createParser();
$fileIterator = new FileIterator(
    new FileReader('/Users/joomartin/code/it-depends-on/src/DependencyParser', ['php']));

$dumper = new NodeDumper;

foreach ($fileIterator as $file)
{
    $dependencies = $parser->parse($file->content);
    echo 'DEPENDENCIES OF ' . $file->path . "\r\n";
    var_dump($dependencies);
}