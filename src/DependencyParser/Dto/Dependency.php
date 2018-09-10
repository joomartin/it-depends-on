<?php

namespace ItDependsOn\DependencyParser\Dto;

class Dependency
{
    /** @var string */
    public $name;
    /** @var string */
    public $fqcn;
    /** @var string */
    public $type;
    /** @var array */
    public $methods;

    public function __construct(string $name, string $type, array $methods = [])
    {
        $this->name = $name;
        $this->type = $type;
        $this->methods = $methods;
    }

    public function addMethod(string $method)
    {
        $this->methods[] = $method;
    }
}