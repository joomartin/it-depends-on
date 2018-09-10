<?php

require __DIR__ . '/vendor/autoload.php';

use PhpParser\NodeDumper;
use ItDependsOn\FileUtils\FileReader;
use ItDependsOn\FileUtils\FileIterator;
use ItDependsOn\DependencyParser\DependencyParserFactory;
use ItDependsOn\FileUtils\FileWriter;
use ItDependsOn\HtmlFormatter\HtmlFormatter;

$inputPath = 'C:\code\it-depends-on\src\DependencyParser';
$outputPath = 'C:\output';

// $inputPath = '/Users/joomartin/code/it-depends-on/src/DependencyParser';
//$inputPath = '/Users/joomartin/code/it-depends-on/sample';
//$outputPath = '/Users/joomartin/output';

$fileWriter = new FileWriter($inputPath, $outputPath);
$parser = DependencyParserFactory::createParser();
$fileIterator = new FileIterator(
    new FileReader($inputPath, ['php']));

$dumper = new NodeDumper;

foreach ($fileIterator as $file)
{
    /** @var DependencyGroup $dependencies */
    $dependencies = $parser->parse($file->content);
    var_dump($dependencies);

    $html = (new HtmlFormatter)->getHtml($dependencies);
    $fileWriter->write($file->path, $html);
}