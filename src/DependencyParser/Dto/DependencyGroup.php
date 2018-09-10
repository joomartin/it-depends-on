<?php

namespace ItDependsOn\DependencyParser\Dto;

class DependencyGroup implements \Iterator
{
    /** @var Dependency[] */
    public $injected;
    /** @var Dependency[] */
    public $inline;
    /** @var Dependency[] */
    public $allDependency;

    protected $position;

    public function __construct(array $injected, array $inline)
    {
        $this->injected = $injected;
        $this->inline = $inline;

        $this->allDependency = array_merge(array_values($inline), array_values($injected));

        $this->position = 0;
    }

    /**
     * @return Dependency
     */
    public function current(): Dependency
    {
        return $this->allDependency[$this->position];
    }

    public function key(): int
    {
        return $this->position;
    }

    public function next()
    {
        $this->position++;
    }

    public function rewind()
    {
        $this->position = 0;
    }

    public function valid(): bool
    {
        return $this->position < count($this->allDependency);
    }
}