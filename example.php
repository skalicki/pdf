<?php

use Shopware\Pdf\Core\Document;

require 'vendor/autoload.php';

$doc = new Document(1.4,'Mein Dokument', 'Max Mustermann', null, 'de-DE');
$doc->addFont('Helvetica', 'Type1', 'StandardEncoding')
    ->addFont('Times-Roman', 'Type1', 'StandardEncoding');

$page1 = $doc->addPage();
$page1
    ->addText('Shopware - PDF Demo', 10, 263, 'Helvetica', 18, 'H1')
    ->addText('Vielen Dank, dass Sie Shopware verwenden!', 10, 249, 'Helvetica', 9, 'P')
    ->addText('Dies ist ein automatisch generiertes PDF, das zeigt, wie', 10, 231, 'Helvetica', 6, 'P')
    ->addText('Shop- und Kundeninformationen dargestellt werden koennen.', 10, 223, 'Helvetica', 6, 'P')
    ->addText('Hier sind die wichtigsten Informationen:', 10, 201, 'Helvetica', 9, 'P')
    ->addText('Bestellnummer: 123456', 10, 181, 'Helvetica', 9, 'P')
    ->addText('Kunde: Max Mustermann', 10, 171, 'Helvetica', 9, 'P')
    ->addText('Gesamtbetrag: 299,99 EUR', 10, 161, 'Helvetica', 9, 'P');


$page2 = $doc->addPage();
$page2
    ->addText('Hallo Welt!', 10, 250, 'Helvetica', 16, 'H1')
    ->addText('Hallo Welt2!', 10, 200, 'Times-Roman', 12, 'P');

$pdfContent = $doc->render();

file_put_contents('output_'. (new DateTime())->format('Y-m-d-H-i-s') .'.pdf', $pdfContent);
