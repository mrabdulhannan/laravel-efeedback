<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

class DocumentController extends Controller
{
    public function generateWordDocument(Request $request)
    {
        dd($request->all());
        try {
            $phpWord = new PhpWord();

            // Add sections and content
            $section = $phpWord->addSection();
            $section->addText('Hello, this is your Word document in the latest format!'); // Customize content here
            $tempFile = $this->createTempFile();
            $phpWord->save($tempFile, 'Word2007', true); // Save as Office 2016 format

            return response()->download($tempFile, 'document.docx')->deleteFileAfterSend(true);

            // ... (continue with file saving and download)
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
    }
    }
    private function createTempFile()
    {
        $tempFile = tempnam(sys_get_temp_dir(), 'word_document');
        // Ensure deletion on script termination
        // register_shutdown_function(function () use ($tempFile) {
        //     unlink($tempFile);
        // });
        $newTempFile = pathinfo($tempFile, PATHINFO_DIRNAME) . DIRECTORY_SEPARATOR . pathinfo($tempFile, PATHINFO_FILENAME) . '.docx';

        rename($tempFile, $newTempFile);
        return $newTempFile;
        

    }
}
