<?php

namespace ItDependsOn\DependencyParser\Adapter;

use PhpParser\NodeFinder;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\{UseUse, ClassMethod}; 
use ItDependsOn\DependencyParser\Contract\NodeFinder as NodeFinderContract;

class NodeFinderAdapter implements NodeFinderContract
{
    const USE_INSTANCE = UseUse::class;
    const USE_NAME_INSTANCE = Name::class;
    const CLASS_METHOD_INSTANCE = ClassMethod::class;

    /**
     * @param NodeFinder
     */
    protected $nodeFinder;

    public function __construct(NodeFinder $nodeFinder)
    {
        $this->nodeFinder = $nodeFinder;
    }

    public function findInstanceOf($ast,string $type)
    {
        return $this->nodeFinder->findInstanceOf($ast, $type);
    }
}