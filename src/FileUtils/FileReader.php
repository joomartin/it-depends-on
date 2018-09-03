<?php

namespace ItDependsOn\FileUtils;

class FileReader
{
    /**
     * @param string Path of directory which will be read
     */
    protected $dir;
    /**
     * @param array of strings which contains the allowed extensions. Only these will be read
     */
    protected $allowedExtensions;

    public function __construct(string $dir, array $allowedExtensions)
    {
        $fileInfo = new \SplFileInfo($dir);

        if (!$fileInfo->isDir()) throw new \InvalidArgumentException("The given path was a file");

        $this->dir = $dir;    
        $this->allowedExtensions = $allowedExtensions;
    }

    /**
     * Get all files in the $dir with $allowedExtensions
     */
    public function getFiles(): array
    {
        $result = [];
        $iterator = $this->createRecursiveIterator();

        foreach ($iterator as $path) {
            if ($path->isDir()) continue;

            $extension = $path->getExtension();

            if (in_array($extension, $this->allowedExtensions)) {
                $result[] = $path->__toString();
            }
        }

        return $result;
    }

    /**
     * @todo ez itt nincs jó helyen.
     */
    public function getFileContent(string $path): string
    {
        $fileInfo = new \SplFileInfo($path);

        if ($fileInfo->isDir()) throw new \InvalidArgumentException("The given path was a directory");

        return file_get_contents($path);
    }

    protected function createRecursiveIterator()
    {
        return new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($this->dir), \RecursiveIteratorIterator::SELF_FIRST);
    }
}