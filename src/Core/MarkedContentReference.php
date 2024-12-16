<?php

namespace Shopware\Pdf\Core;

class MarkedContentReference extends IndirectObject
{

    public function render(): string
    {
        $output = "{$this->id} 0 obj\n";
        $output .= "<< /Type /MCR\n";
        $output .= "/MCID 0 >>\n"; // Todo: ContentId
        $output .= "endobj\n";

        return $output;
    }
}
