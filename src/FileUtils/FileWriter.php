<?php

namespace ItDependsOn\FileUtils;

class FileWriter
{
    /** @var string Original output path, given by user. It does not contain project name */
    protected $outputPath;
    /** @var string Base path where to write output files. It contains the project name  */
    protected $fullOutputPath;
    /** @var string */
    protected $projectDir;

    public function __construct(string $inputPath, string $outputPath)
    {
        $parts = explode(DIRECTORY_SEPARATOR, $inputPath);
        $lastDirectory = $parts[count($parts) - 1];

        $this->fullOutputPath = $outputPath . DIRECTORY_SEPARATOR . $lastDirectory;
        $this->outputPath = $outputPath;
        $this->projectDir = $lastDirectory;
    }

    public function write(string $filePath, string $content)
    {
        $path = $this->getOutputPath($filePath);
        $this->createDirectories($path);

        $result = file_put_contents($path, $content);

        if ($result === false)
            throw new \Exception('Something went wrong file writing to ' . $outputPath);
    }

    protected function createDirectories(string $path)
    {
        /**
         * @todo a projekt mappát is hozza létre, ha kell
         * teht ha az output path: /Users/joomartin/output
         * és az output mappa nem létezik
         */
        $notExistingDirectoryPath = substr($path, strlen($this->outputPath . DIRECTORY_SEPARATOR));

        /**
         * @todo remove array_pop
         */

        $parts = explode(DIRECTORY_SEPARATOR, $notExistingDirectoryPath);
        $file = array_pop($parts);
        $dir = $this->outputPath;

        foreach ($parts as $part) {
            $nextDir = $dir . DIRECTORY_SEPARATOR . $part;

            if (!is_dir($nextDir))
                mkdir($nextDir);

            $dir .= (DIRECTORY_SEPARATOR . $part);
        }

    }

    protected function getOutputPath(string $filePath) : string
    {
        /**
         * Pl.:
         * filepath: C:\code\it-depends-on\src\DependencyParser\Adapter\NodeFinderAdapter.php
         * fulloutputpath: C:\output\DependencyParser
         * 
         * result: C:\output\DependencyParser\Adapter\NodeFinderAdapter.php.html
         */

        $fullOutputParts = explode(DIRECTORY_SEPARATOR, $this->fullOutputPath);

        $filePathParts = explode(DIRECTORY_SEPARATOR, $filePath);
        $projectDirIndex = array_search($this->projectDir, $filePathParts);

        return $this->outputPath . DIRECTORY_SEPARATOR . join(DIRECTORY_SEPARATOR, array_slice($filePathParts, $projectDirIndex)) . '.html';
    }
}