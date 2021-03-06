<?php

namespace ItDependsOn\HtmlFormatter;

use ItDependsOn\DependencyParser\Dto\DependencyGroup;


class HtmlFormatter
{
    /** @var \Twig_Environment */
    protected $twig;

    public function __construct()
    {
        $loader = new \Twig_Loader_Filesystem('./src/HtmlFormatter/templates');
        $this->twig = new \Twig_Environment($loader);
    }

    public function getHtml(DependencyGroup $dependencies): string
    {
        return $this->twig->render('dependency-table.html', compact('dependencies'));
    }
}