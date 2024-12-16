<?php

namespace Shopware\Pdf\Core;

use InvalidArgumentException;

class StructElem extends IndirectObject
{
    private string $tag;
    private array $kids = [];
    private array $allowedTags = [
        // Text-Tags
        'Document',
        'H1', 'H2', 'H3',
        'P',
        'L', 'LI', 'LBody',
        'Span', 'Quote', 'Note',

        // Struktur-Tags
        'Part', 'Sect', 'Art', 'Div'

        // Tabellen-Tags
        // ...
    ];

    public function __construct(int $id, string $tag)
    {
        parent::__construct($id);

        $this->tag = $tag;

        $this->validate();
    }

    public function addKid(string $id): self
    {
        $this->kids[] = $id;
        return $this;
    }

    public function render(): string
    {
        $kids = implode(" ", array_map(fn($id) => $id." 0 R", $this->kids));

        $output = "{$this->id} 0 obj\n";
        $output .= "<< /Type /StructElem\n";
        $output .= "/S /{$this->tag}\n";
        $output .= "/K [{$kids}] >>\n";
        $output .= "endobj\n";

        return $output;
    }

    private function validate(): void
    {
        if (!in_array($this->tag, $this->allowedTags)) {
            throw new InvalidArgumentException("Tag '{$this->tag}' is not allowed.");
        }
    }
}
