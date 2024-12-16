<?php

namespace Shopware\Pdf\Core;

use DateTime;

class Info extends IndirectObject
{
    private Document $document;
    private string $producer;
    private string $creationDate;

    public function __construct(int $id, Document $document)
    {
        parent::__construct($id);

        $this->document = $document;
        $this->producer = 'swagPDF';
        $this->creationDate = (new DateTime())->format('YmdHis');
    }

    public function render(): string
    {
        $output = "{$this->id} 0 obj\n";
        $output .= "<<\n";
        $output .= "/Title ({$this->document->getTitle()})\n";
        $output .= "/Author ({$this->document->getAuthor()})\n";

        if (!empty($this->document->getSubject())) {
            $output .= "/Subject ({$this->document->getSubject()})\n";
        }

        if (!empty($this->document->getKeywords())) {
            $output .= "/Keywords (". implode(', ', $this->document->getKeywords()) .")\n";
        }

        $output .= "/Creator ({$this->producer})\n";
        $output .= "/Producer ({$this->producer})\n";
        $output .= "/CreationDate (D:{$this->creationDate})\n";

        if ($this->document->getVersion() >= 1.4) {
            $output .= "/Lang ({$this->document->getLanguage()})\n";
        }

        $output .= ">>\n";
        $output .= "endobj\n";

        return $output;
    }
}