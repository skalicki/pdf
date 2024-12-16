<?php

namespace Shopware\Pdf\Render;

use Shopware\Pdf\Core\Document;

class PdfRenderer
{
    private int $offset = 0;
    private array $offsets = [];

    public function render(Document $document): string
    {
        $document = $this->generateDocument($document);
        $offsets = $this->calculateOffsets($document);
        $crossTable = $this->generateCrossReferenceTable($offsets);

        $startxref = strlen($document);
//        $startxref = mb_strlen($document, '8bit');;

        $finalPdf = $document . $crossTable;
        $finalPdf .= $this->generateTrailer(count($offsets) + 1, 1);
        $finalPdf .= "startxref\n" . $startxref . "\n%%EOF";

        echo $finalPdf;

        return $finalPdf;
    }

//    public function render(Document $document): string
//    {
//        // Output
//        $output = "%PDF-{$document->getVersion()}\n";
//        $this->offset = strlen($output);
//
//        // Catalog
//        $this->offsets[] = $this->offset;
//        $output .= $document->getCatalog()->render();
//        $this->offset = strlen($output) - 2; // Todo: WHY???
//
//        // Pages
//        $this->offsets[] = $this->offset;
//        $output .= $document->getPages()->render();
//        $this->offset = strlen($output) - 2; // Todo: WHY???
//
//        // StructTreeRoot
//        if ($document->getVersion() >= 1.4) {
//            $this->offsets[] = $this->offset;
//            $output .= $document->getStructTreeRoot()->render();
//            $this->offset = strlen($output) - 2; // Todo: WHY???
//
//            // StructElems
//            foreach ($document->getStructElems() as $structElem) {
//                $this->offsets[] = $this->offset;
//                $output .= $structElem->render();
//                $this->offset = strlen($output) - 2; // Todo: WHY???
//            }
//        }
//
//        // Info
//        $this->offsets[] = $this->offset;
//        $output .= $document->getInfo()->render();
//        $this->offset = strlen($output) - 2; // Todo: WHY???
//
//        // Resource
//        $this->offsets[] = $this->offset;
//        $output .= $document->getResources()->render();
//        $this->offset = strlen($output) - 2; // Todo: WHY???
//
//        // Font
//        foreach ($document->getFonts() as $font) {
//            $this->offsets[] = $this->offset;
//            $output .= $font->render();
//            $this->offset = strlen($output) - 2; // Todo: WHY???
//        }
//
//        // Page
//        foreach ($document->getPages()->getPages() as $page) {
//            $this->offsets[] = $this->offset;
//            $output .= $page->render();
//            $this->offset = strlen($output) - 2; // Todo: WHY???
//
//            // Contents
//            $this->offsets[] = $this->offset;
//            $output .= $page->getContents()->render();
//            $this->offset = strlen($output) - 2; // Todo: WHY???
//
////            StructElems
////            foreach ($page->getStructElems() as $structElem) {
////                $this->offsets[] = $this->offset;
////                $output .= $structElem->render();
////                $this->offset = strlen($output) - 2; // Todo: WHY???
////            }
//        }
//
////        var_dump($this->offsets);
//
//        // Cross-Reference Table
//        $output .= "xref\n";
//        $output .= "0 ". (count($this->offsets) + 1) ."\n";
//        $output .= "0000000000 65535 f \n";
//        foreach ($this->offsets as $offset) {
//            $output .= sprintf('%010d 00000 n ', $offset) . "\n";
//        }
//
//        // Trailer
//        $output .= "trailer\n";
//        $output .= "<< /Size ". (count($this->offsets) + 1) ."\n";
//        $output .= "/Root {$document->getCatalog()->getId()} 0 R >>\n";
//        $output .= "/Info {$document->getInfo()->getId()} 0 R >>\n";
//        $output .= "startxref\n";
//        $output .= $this->offset ."\n";
//        $output .= "%%EOF\n";
//
//        echo $output;
//
//        return $output;
//    }

    private function generateDocument(Document $document): string {
        $output = "%PDF-{$document->getVersion()}\n";

        // Catalog
        $output .= $document->getCatalog()->render();

        // Pages
        $output .= $document->getPages()->render();

        // StructTreeRoot
        if ($document->getVersion() >= 1.4) {
            $output .= $document->getStructTreeRoot()->render();

            // StructElems
            foreach ($document->getStructElems() as $structElem) {
                $output .= $structElem->render();
            }
        }

        // Info
        $output .= $document->getInfo()->render();

        // Resource
        $output .= $document->getResources()->render();

        // Font
        foreach ($document->getFonts() as $font) {
            $output .= $font->render();
        }

        // Page
        foreach ($document->getPages()->getPages() as $page) {
            $output .= $page->render();

            // Contents
            $output .= $page->getContents()->render();
        }

        return $output;
    }

    private function calculateOffsets(string $document): array {
        $offsets = [];

        if (preg_match_all('/\d+ \d+ obj/', $document, $matches, PREG_OFFSET_CAPTURE)) {
            foreach ($matches[0] as $match) {
                $offsets[] = $match[1];
            }
        }

        return $offsets;
    }

    private function generateCrossReferenceTable(array $offsets): string {
        $xref = "xref\n";
        $xref .= "0 ". (count($offsets)  + 1) ."\n";
        $xref .= "0000000000 65535 f \n";

        foreach ($offsets as $offset) {
            $xref .= sprintf("%010d 00000 n \n", $offset);
        }

        return $xref;
    }

    private function generateTrailer(int $size, int $rootId): string {
        return "trailer\n<< /Size $size\n/Root $rootId 0 R >>\n";
    }
}
