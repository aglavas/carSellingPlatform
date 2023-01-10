<?php

namespace App\Http\Controllers;

use App\Service\DocumentService;
use App\StockUsedCentralEurope;
use Illuminate\Http\Request;

class DocumentsController extends Controller
{
    /**
     * List all VIN documents
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request, StockUsedCentralEurope $vehicle, DocumentService $documentService)
    {
        $vinDocumentCollection = $vehicle->getVinDocuments();

        $vinDocumentLinkArray = $documentService->formatVinDocuments($vinDocumentCollection);

        return view('frontend.detail.documents', [
            'vehicle' => $vehicle,
            'vinDocument' => $vinDocumentLinkArray
        ]);
    }

    /**
     * Download VIN document
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function get(Request $request, StockUsedCentralEurope $vehicle, string $document, DocumentService $documentService)
    {
        $documentService->validateDocument($vehicle, $document);

        return response()->download(storage_path('app/public/' . $document));
    }
}
