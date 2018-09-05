<?php

namespace ItDependsOn\DependencyParser;

use ItDependsOn\DependencyParser\Adapter\PhpParserAdapter;
use ItDependsOn\DependencyParser\Adapter\NodeFinderAdapter;
use PhpParser\NodeDumper;

class PhpDependencyParser
{
    /**
     * @param PhpParserAdapter
     */
    protected $phpParser;
    /**
     * @param NodeFinderAdapter 
     */
    protected $nodeFinder;
    protected $nodeDumper;

    public function __construct(PhpParserAdapter $phpParser, NodeFinderAdapter $nodeFinder)
    {
        $this->phpParser = $phpParser;    
        $this->nodeFinder = $nodeFinder;
        $this->nodeDumper = new NodeDumper;
    }

    public function parse(string $code): array
    {
        $ast = $this->phpParser->parse($code);
        echo $this->nodeDumper->dump($ast);

        return $this->getAllDependency($ast);
    }

    protected function getAllDependency(array $ast): array
    {
        return $this->getUsedDependencies($ast);
    }

    /**
     * Returns all class names that injected to any method, so it appears in the function's parameters with type hint
     */
    protected function getInjectedDependencies(): array
    {
        /**
         * 1. Megkeresni az összes metódust (Stmt_ClassMethod)
         * 2. VÉgmenni a params tömbön
         * 3. Kiszűrni az osztály típusokat. Ezeknek a típusa Name, a skalároké Identifier
         * 4. Összefúzni \ a part array elemeit
         */
    }

    /**
     * Returns all class names that accours in use statements at the top of the class
     */
    protected function getUsedDependencies(array $ast): array
    {
        $useUseStatements = $this->nodeFinder->findInstanceOf($ast, NodeFinderAdapter::USE_INSTANCE);
        $names = $this->nodeFinder->findInstanceOf($useUseStatements, NodeFinderAdapter::USE_NAME_INSTANCE);

        return array_map(function ($name) {
            return join($name->parts, '\\');
        }, $names);
    }
}