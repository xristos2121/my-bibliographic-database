<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Smalot\PdfParser\Parser;
use App\Models\Publication;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

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
        ini_set('memory_limit', env('PHP_MEMORY_LIMIT', '1024M'));

        try {
            $parser = new Parser();
            $pdf = $parser->parseFile($this->filePath);

            $text = $pdf->getText();

            $textUtf8 = mb_convert_encoding($text, 'UTF-8', 'auto');

            $textWithoutNewLines = preg_replace('/\s+/', ' ', $textUtf8);

            // First, strip HTML tags using strip_tags
            $plainText = strip_tags($textWithoutNewLines);

            // Further remove any remaining tags using a regex pattern
            $plainText = preg_replace('/<[^>]*>/', '', $plainText);

            Cache::put('publication_' . $this->publicationId . '_pdf_text', $plainText, now()->addDays(30));

            $publication = Publication::find($this->publicationId);
            if ($publication) {
                $publication->pdf_text = $plainText;
                $publication->save();
            }

        } catch (\Exception $e) {
            Log::error('Error processing PDF: ' . $e->getMessage());
        }
    }
}
