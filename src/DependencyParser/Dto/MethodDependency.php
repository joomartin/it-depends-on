<?php

namespace ItDependsOn\DependencyParser\Dto;

class MethodDependency
{
    /** @var string */
    public $method;
    /** @var array */
    public $dependencies;

    public function __construct(string $method, array $dependencies = [])
    {
        $this->method = $method;
        $this->dependencies = $dependencies;
    }

    public function add(string $dependency)
    {
        $this->dependencies[] = $dependency;
    }

    public function addParts(array $parts)
    {
        $this->add(join('\\', $parts));
    }

    public function hasDependencies()
    {
        return !empty($this->dependencies);
    }
}