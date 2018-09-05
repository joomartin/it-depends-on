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

        return $this->getAllDependency($ast);
    }

    protected function getAllDependency(array $ast): array
    {
        $this->getInjectedDependencies($ast);
        //return $this->getUsedDependencies($ast);
    }

    /**
     * Returns all class names that injected to any method, so it appears in the function's parameters with type hint
     */
    protected function getInjectedDependencies(array $ast): array
    {
        $methods = $this->getMethodsWithInjectedDependencies($ast);
        var_dump($methods);
        exit;

        /**
         * Output:
         * - Lista, amiben szerepel az összes EGYEDI függőség
         * - Az is kell, hogy ezek milyen metódusokban jelennek meg
         * 
         * [
         *      {
         *          "dependency": "Foo\Bar",
         *          "methods": ["__construct", "doThing"],
         *          "type": "injected"
         *      }
         * ]
         */
    }

    protected function getMethodsWithInjectedDependencies(array $ast): array
    {
        $classMethods = $this->nodeFinder->findInstanceOf($ast, NodeFinderAdapter::CLASS_METHOD_INSTANCE);
        $data = [];

        foreach ($classMethods as $classMethod) {
            $tmp = [
                'method'        => $classMethod->name->name,
                'dependencies'  => []
            ];

            foreach ($classMethod->params as $param) {                            
                $name = $this->nodeFinder->findInstanceOf($param, NodeFinderAdapter::USE_NAME_INSTANCE);

                // if no Node\Name found for this parameter, then it's a simple scalar type paramter
                if (empty($name)) 
                    continue;
                
                $tmp['dependencies'][] = join('\\', $name[0]->parts);
            }

            if (!empty($tmp['dependencies'])) 
                $data[] = $tmp;            
        }

        return $data;
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

    protected function dump($ast)
    {
        echo $this->nodeDumper->dump($ast);
    }
}