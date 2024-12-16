<?php

namespace Shopware\Pdf\Elements;

use Shopware\Pdf\Core\Element;

class Image extends Element
{
    private int $width;
    private int $height;
    private string $colorSpace;
    private string $filter;
    private string $data;

    public function __construct(
        int $width,
        int $height,
        string $colorSpace,
        string $filter,
        string $data
    ) {
        $this->width = $width;
        $this->height = $height;
        $this->colorSpace = $colorSpace;
        $this->filter = $filter;
        $this->data = $data;
    }

    public function render(): string
    {
        $output = "<< /Type /XObject\n";
        $output .= "/Subtype /Image\n";
        $output .= "/Width {$this->width}\n";
        $output .= "/Height {$this->height}\n";
        $output .= "/ColorSpace /{$this->colorSpace}\n";
        $output .= "/BitsPerComponent 8\n";
        $output .= "/Filter /{$this->filter}\n";
        $output .= "/Length " . strlen($this->data) . " >>\n";
        $output .= "stream\n";
        $output .= $this->data . "\n";
        $output .= "endstream\n";

        return $output;
    }
}
