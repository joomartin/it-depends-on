<?php

namespace ItDependsOn\DependencyParser\Contract;

interface PhpParser
{
    /**
     * @param string PHP source code
     * @return mixed AST
     */
    public function parse(string $code);
}