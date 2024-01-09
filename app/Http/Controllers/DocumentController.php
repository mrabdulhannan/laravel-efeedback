<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

class DocumentController extends Controller
{
    public function generateWordDocument(Request $request)
    {
        //dd($request->all());        
        try {
            $phpWord = new PhpWord();

            // Add sections and content
            /*$section = $phpWord->addSection();
            $section->addText('Hello, this is your Word document in the latest format!'); // Customize content here
            $tempFile = $this->createTempFile();
            $phpWord->save($tempFile, 'Word2007', true); // Save as Office 2016 format*/
            
            $htmlContent = '<html><body>
<p><strong>Name :</strong> '.$request->student_name.' <strong>Student ID:</strong> '.$request->student_id.'  <strong>Mark:</strong> '.$request->student_mark.'</p>
<strong>Tutor Comments:</strong>
<p>'.$request->tutor_comment.'</p>
<p><strong>Tutor Signature:</strong> '.$request->tutor_sign.' <strong>Date:</strong> '.$request->end_date.'</p>
</body>
</html>';

            $section = $phpWord->addSection();
            
            \PhpOffice\PhpWord\Shared\Html::addHtml($section, $htmlContent, false, false);

//            $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
//            $objWriter->save('output.docx');
            
            $tempFile = $this->createTempFile();
            $phpWord->save($tempFile, 'Word2007', true);            
            
            return response()->download($tempFile, 'document.docx')->deleteFileAfterSend(true);

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
