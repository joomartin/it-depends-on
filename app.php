<?php

require __DIR__ . '/vendor/autoload.php';

use ItDependsOn\FileUtils\FileReader;
use ItDependsOn\FileUtils\FileIterator;
use ItDependsOn\DependencyParser\PhpDependencyParser;

use PhpParser\ParserFactory;
use PhpParser\NodeDumper;
use PhpParser\NodeFinder;
use ItDependsOn\DependencyParser\Adapter\PhpParserAdapter;
use ItDependsOn\DependencyParser\Adapter\NodeFinderAdapter;

$parserAdapter = new PhpParserAdapter((new ParserFactory)->create(ParserFactory::PREFER_PHP7));
$nodeFinderAdapter = new NodeFinderAdapter(new NodeFinder);

$parser = new PhpDependencyParser($parserAdapter, $nodeFinderAdapter);

$fileReader = new FileReader('C:code\it-depends-on\src\DependencyParser', ['php']);
$fileIterator = new FileIterator($fileReader);

$dumper = new NodeDumper;

foreach ($fileIterator as $file)
{
    $dependencies = $parser->parse($file->content);
    echo 'DEPENDENCIES OF ' . $file->path . "\r\n";
    var_dump($dependencies);
}