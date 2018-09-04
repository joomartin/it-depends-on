<?php

namespace ItDependsOn\HtmlFormatter;

class HtmlFormatter
{
    public function getHtml(array $dependencies): string
    {
        return join('<br>', $dependencies);
    }
}