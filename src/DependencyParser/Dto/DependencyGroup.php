<?php

namespace ItDependsOn\DependencyParser\Dto;

class DependencyGroup implements \Iterator
{
    /** @var Dependency[] */
    public $injected;
    /** @var Dependency[] */
    public $inline;

    protected $position;

    public function __construct(array $injected, array $inline)
    {
        // Use array_values to convert an associative array to a simple array
        // It is required because of Iterator's position
        $this->injected = array_values($injected);
        $this->inline = array_values($inline);

        $this->position = 0;
    }

    /**
     * @return Dependency
     */
    public function current(): Dependency
    {
        if ($this->position < count($this->inline))
            return $this->inline[$this->position];

        return $this->injected[$this->position - count($this->inline)];
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
        return $this->position < count($this->inline) + count($this->injected) && $this->position >= 0;
    }
}