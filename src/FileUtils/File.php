<?php

namespace ItDependsOn\FileUtils;

class File
{
    /**
     * @param string
     */
    protected $path;
    /**
     * @param string
     */
    protected $content;

    public function __construct(string $path, string $content)
    {
        $this->path = $path;
        $this->content = $content;
    }

    public function __toString()
    {
        return $this->path;
    }

    public function __get(string $prop)
    {
        return $this->{$prop};
    }
}