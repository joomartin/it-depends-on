<?php

namespace ItDependsOn\DependencyParser;

use ItDependsOn\DependencyParser\Adapter\NodeFinderAdapter;
use ItDependsOn\DependencyParser\Adapter\PhpParserAdapter;
use PhpParser\ParserFactory;
use PhpParser\NodeFinder;

class DependencyParserFactory
{
    public static function createParser(): PhpDependencyParser
    {
        return new PhpDependencyParser(self::createParserAdapter(), self::createNodeFinderAdapter());
    }

    private static function createParserAdapter(): PhpParserAdapter
    {
        return new PhpParserAdapter((new ParserFactory)->create(ParserFactory::PREFER_PHP7));
    }

    private static function createNodeFinderAdapter(): NodeFinderAdapter
    {
        return new NodeFinderAdapter(new NodeFinder);
    }
}