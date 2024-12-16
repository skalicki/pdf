<?php

namespace Shopware\Pdf\Core;

use InvalidArgumentException;
use Shopware\Pdf\Elements\Text;

// Todo: Jede Page bekommt sein eigenes Resource Object / Klasse
class Page extends IndirectObject
{
    private float $width;
    private float $height;
    private int $markedContentId = 0;
    private Document $document;
    private Contents $contents;

    public function __construct(
        int $id,
        int $contentsId,
        float $width,
        float $height,

        Document $document
    )
    {
        parent::__construct($id);

        $this->id = $id;
        $this->width = $width;
        $this->height = $height;

        $this->document = $document;
        $this->contents = new Contents($contentsId);
    }

    public function getContents(): Contents
    {
        return $this->contents;
    }

    public function addText(string $text, float $x, float $y, string $baseFont, int $size, string $tag): self
    {
        $fontId = null;
        $markedContentId = $this->markedContentId++;

        foreach ($this->document->getFonts() as $index => $font) {
            if ($font->getBaseFont() === $baseFont) {
                $fontId = $index + 1;
                break;
            }
        }

        if ($fontId === null) {
            throw new InvalidArgumentException("Font '{$font}' is not registered.");
        }

        $this->contents->addElement(new Text($markedContentId, $text, $x, $y, "F{$fontId}", $size, $tag));
        $this->document->addStructElem($tag, $markedContentId);

        return $this;
    }

    public function addImage(): self {
        return $this;
    }

    public function render(): string
    {
        $output = "{$this->id} 0 obj\n";
        $output .= "<< /Type /Page\n";
        $output .= "/Parent {$this->document->getPages()->getId()} 0 R\n";
        $output .= "/MediaBox [0 0 {$this->width} {$this->height}]\n";
        $output .= "/Resources {$this->document->getResources()->getId()} 0 R\n";
        $output .= "/Contents {$this->contents->getId()} 0 R >>\n";
        $output .= "endobj\n";

        return $output;
    }
}