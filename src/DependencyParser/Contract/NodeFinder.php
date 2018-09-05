<?php

namespace ItDependsOn\DependencyParser\Contract;

interface NodeFinder
{
    /**
     * @param array | mixed AST
     * @param string Type of the node
     * @return array All the nodes which is type of $type
     */
    public function findInstanceOf($ast, string $type);
}