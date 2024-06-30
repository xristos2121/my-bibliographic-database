<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Smalot\PdfParser\Parser;
use App\Models\Publication; // Assuming you have a Publication model
use Illuminate\Support\Facades\Log;

class ProcessPdf implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;
    protected $publicationId;

    public function __construct($filePath, $publicationId)
    {
        $this->filePath = $filePath;
        $this->publicationId = $publicationId;
    }

    public function handle()
    {

        $parser = new Parser();
        $pdf = $parser->parseFile($this->filePath);

        // Extract text from the PDF
        $text = $pdf->getText();

        $textWithoutNewLines = preg_replace('/\s+/', ' ', $text);

        $publication = Publication::find($this->publicationId);
        if ($publication) {
            $publication->pdf_text = $textWithoutNewLines;
            $publication->save();
        }
    }

}
