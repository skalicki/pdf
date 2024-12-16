<?php

namespace Shopware\Pdf\Core;

class Resources extends IndirectObject
{
    private array $fonts = [];

    public function __construct(int $id)
    {
        parent::__construct($id);
    }

    public function addFont(Font $font): self
    {
        $this->fonts[] = $font;
        return $this;
    }

    public function render(): string
    {
        $fonts = implode(" ", array_map(
            fn($font, $i) => "/F".($i+1)." ".$font->getId()." 0 R",
            $this->fonts,
            array_keys($this->fonts)
        ));

        $output = "{$this->id} 0 obj\n";
        $output .= "<< /Font << ". $fonts ." >> >>\n";
        $output .= "endobj\n";

        return $output;
    }
}