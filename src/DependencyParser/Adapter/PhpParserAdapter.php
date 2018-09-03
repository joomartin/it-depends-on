<?php

namespace ItDependsOn\DependencyParser\Adapter;

use PhpParser\Parser;
use ItDependsOn\DependencyParser\Contract\PhpParser as PhpParserContract;

class PhpParserAdapter implements PhpParserContract
{
    /**
     * @param Parser
     */
    protected $phpParser;

    public function __construct(Parser $phpParser)
    {
        $this->phpParser = $phpParser;    
    }

    public function parse(string $code)
    {
        return $this->phpParser->parse($code);
    }
}