<?php

namespace ItDependsOn\FileUtils;

class FileIterator implements \Iterator
{
    /**
     * @param FileReader 
     */
    protected $fileReader;
    /**
     * @param array
     */
    protected $fileNames;
    /**
     * @param int
     */
    protected $position;

    public function __construct(FileReader $fileReader)
    {
        $this->fileReader = $fileReader;
        $this->position = 0;

        $this->fileNames = $this->fileReader->getFiles();
    }

    /**
     * @return File
     */
    public function current(): File
    {
        return new File(
            $this->fileNames[$this->position], 
            $this->fileReader->getFileContent($this->fileNames[$this->position]));
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
        return isset($this->fileNames[$this->position]);
    }
}