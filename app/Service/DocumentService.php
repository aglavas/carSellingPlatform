<?php

namespace App\Service;

use App\StockUsedCentralEurope;
use App\VinDocuments;

class DocumentService
{
    /**
     * Format VIN documents as links
     *
     * @param VinDocuments $vinDocument
     * @return array
     */
    public function formatVinDocuments(VinDocuments $vinDocument)
    {
        $vinDocumentCollection = collect($vinDocument->getAttributes());

        $vinDocumentCollection = $vinDocumentCollection->except(['created_at', 'updated_at', 'id', 'vin']);

        $vinDocumentsArray = $vinDocumentCollection->toArray();

        $vinDocumentsArray = array_filter($vinDocumentsArray);

        $vinDocumentCount = count($vinDocumentsArray) / 2;

        $vinRangeArray = array_reverse(range(1, $vinDocumentCount));

        $vinDocumentLinkArray = [];

        foreach ($vinRangeArray as $index) {
            $vinDocumentLinkArray[$vinDocumentsArray["description{$index}"]] = $vinDocumentsArray["path{$index}"];
        }

        return $vinDocumentLinkArray;
    }

    /**
     * Validate VIN document
     *
     * @param StockUsedCentralEurope $stockUsedCentralEurope
     * @param string $document
     * @return bool
     */
    public function validateDocument(StockUsedCentralEurope $stockUsedCentralEurope, string $document)
    {
        $vinDocument = $stockUsedCentralEurope->getVinDocuments();

        if (!$vinDocument) {
            abort(404);
        }

        $vinDocumentArray = $vinDocument->getAttributes();

        if (!in_array($document, $vinDocumentArray)) {
            abort(404);
        }

        return true;
    }
}
