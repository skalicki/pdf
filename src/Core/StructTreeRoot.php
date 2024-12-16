<?php

namespace Shopware\Pdf\Core;

class StructTreeRoot extends IndirectObject
{
    private array $kids = [];

    public function addKid(string $id): self
    {
        $this->kids[] = $id;
        return $this;
    }

    public function render(): string
    {
        $kids = implode(" ", array_map(fn($id) => $id." 0 R", $this->kids));

        $output = "{$this->id} 0 obj\n";
        $output .= "<< /Type /StructTreeRoot\n";
        $output .= "/K [{$kids}] >>\n";
        $output .= "endobj\n";

        return $output;
    }
}
