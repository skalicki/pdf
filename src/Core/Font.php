<?php

namespace Shopware\Pdf\Core;

use InvalidArgumentException;

class Font extends IndirectObject
{
    private string $baseFont;
    private string $subtype;
    private string $encoding;
    private string $version;

    public function __construct(
        int $id, string $baseFont, string $subtype, string $encoding, string $version
    )
    {
        parent::__construct($id);

        $this->baseFont = $baseFont;
        $this->subtype = $subtype;
        $this->encoding = $encoding;
        $this->version = $version;

        $this->validate();
    }

    public function getBaseFont(): string
    {
        return $this->baseFont;
    }

    public function render(): string
    {
        $output = "{$this->id} 0 obj\n";
        $output .= "<< /Type /Font\n";
        $output .= "/Subtype /{$this->subtype}\n";
        $output .= "/BaseFont /{$this->baseFont}\n";
        $output .= "/Encoding /{$this->encoding} >>\n";
        $output .= "endobj\n";

        return $output;
    }

    private function validate(): void {
        $allowedEncodings10 = [
            'StandardEncoding',
            'ISOLatin1Encoding',
            'SymbolEncoding',
            'ZapfDingbatsEncoding'
        ];

        $symbolFonts = ['Symbol'];
        $zapfDingbatsFonts = ['ZapfDingbats'];

        if ($this->version === '1.0' && !in_array($this->encoding, $allowedEncodings10, true)) {
            throw new InvalidArgumentException("Encoding '{$this->encoding}' ist in PDF 1.0 nicht erlaubt.");
        }

        if ($this->encoding === 'SymbolEncoding' && !in_array($this->baseFont, $symbolFonts, true)) {
            throw new InvalidArgumentException("BaseFont '{$this->baseFont}' ist nicht kompatibel mit 'SymbolEncoding'.");
        }

        if ($this->encoding === 'ZapfDingbatsEncoding' && !in_array($this->baseFont, $zapfDingbatsFonts, true)) {
            throw new InvalidArgumentException("BaseFont '{$this->baseFont}' ist nicht kompatibel mit 'ZapfDingbatsEncoding'.");
        }
    }
}