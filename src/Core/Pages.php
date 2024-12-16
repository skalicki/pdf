<?php

namespace Shopware\Pdf\Core;

class Pages extends IndirectObject
{
    private Document $document;
    private array $pages = [];

    public function __construct(int $id, Document $document)
    {
        parent::__construct($id);

        $this->document = $document;
    }

    public function getPages(): array
    {
        return $this->pages;
    }

    public function addPage(
        int $pageId,
        int $contentsId,
        float $width,
        float $height
    ): Page
    {
        // Todo: Klassen übergeben...
        $page = new Page($pageId, $contentsId, $width, $height, $this->document);
        $this->pages[] = $page;

        return $page;
    }

    public function render(): string
    {
        $kids = implode(" ", array_map(fn($page) => $page->getId()." 0 R", $this->pages));

        $output = "{$this->id} 0 obj\n";
        $output .= "<< /Type /Pages /Kids [{$kids}] /Count ". count($this->pages) ." >>\n";
        $output .= "endobj";

        return $output . "\n";
    }
}