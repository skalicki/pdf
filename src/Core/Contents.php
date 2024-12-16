<?php

namespace Shopware\Pdf\Core;

class Contents extends IndirectObject
{
    private array $elements = [];

    public function addElement(Element $element): self
    {
        $this->elements[] = $element;
        return $this;
    }

    public function render(): string
    {
        $contents = implode("\n", array_map(fn($elements) => $elements->render(), $this->elements));

        $output = "{$this->id} 0 obj\n";
        $output .= "<< /Length ". strlen($contents) ." >>\n";
        $output .= "stream\n";
        $output .= "{$contents}\n";
        $output .= "endstream\n";
        $output .= "endobj\n";

        return $output;
    }
}