<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Shared\Html;

class DocumentController extends Controller
{
    public function generateWordDocument(Request $request)
    {
        //dd($request->all());        
        $tutor_comment_data = explode("\n", $request->tutor_comment_hidden);
		
		$tutor_comment_data_final = array();
		foreach($tutor_comment_data as $tutor_comment_data_obj){
			$tutor_comment_data_final[] = self::cleanString($tutor_comment_data_obj);
		}
        
        try {
            $phpWord = new PhpWord();
            
            $rubrics = Auth::user()->definerubrics->where('topic_id', $request->topic_id);

            // Add sections and content
            /*$section = $phpWord->addSection();
            $section->addText('Hello, this is your Word document in the latest format!'); // Customize content here
            $tempFile = $this->createTempFile();
            $phpWord->save($tempFile, 'Word2007', true); // Save as Office 2016 format*/
            
            /*$htmlContent = '<html><body>
<p><strong>Name :</strong> '.$request->student_name.' <strong>Student ID:</strong> '.$request->student_id.'  <strong>Mark:</strong> '.$request->student_mark.'</p>
<strong>Tutor Comments:</strong>
<p>'.$request->tutor_comment.'</p>
<p><strong>Tutor Signature:</strong> '.$request->tutor_sign.' <strong>Date:</strong> '.$request->end_date.'</p>
</body>
</html>';*/

            $htmlContent = '<html><body><table width="752" style="border: 1px solid black;">
  <tr>
    <td width="752" colspan="11" valign="top"><p><strong><u>Tutorial Presentation</u></strong><strong>                                                <u></u></strong>
      <strong>            Name :    '.$request->student_name.'                    Student ID:  '.$request->student_id.'                     Mark: '.$request->student_mark.'</strong></p></td>
  </tr>
  <tr>
    <td width="58" valign="top"><h1>&nbsp;</h1></td>
    <td width="120" colspan="3" valign="top"><p align="center">1st </p></td>
    <td width="110" valign="top"><p align="center">2.1</p></td>
    <td width="110" valign="top"><p align="center">2.2</p></td>
    <td width="110" valign="top"><p align="center">3rd </p></td>
    <td width="111" valign="top"><p align="center">Pass</p></td>
    <td width="37" valign="top"><p align="center">F+</p></td>
    <td width="37" valign="top"><p align="center">F</p></td>
    <td width="37" valign="top"><p align="center">F-</p></td>
  </tr>
  <tr>
    <td width="58" valign="top"><h1>&nbsp;</h1></td>
    <td width="46" valign="top"><p align="center">90-100</p></td>
    <td width="37" valign="top"><p align="center">80-89</p></td>
    <td width="37" valign="top"><p align="center">70-79</p></td>
    <td width="110" valign="top"><p align="center">60-69</p></td>
    <td width="110" valign="top"><p align="center">50-59</p></td>
    <td width="110" valign="top"><p align="center">45-49</p></td>
    <td width="111" valign="top"><p align="center">40-44</p></td>
    <td width="37" valign="top"><p align="center">35-39</p></td>
    <td width="37" valign="top"><p align="center">25-34</p></td>
    <td width="37" valign="top"><p align="center">15-24</p></td>
  </tr>';

foreach ($rubrics as $key => $rubric){

$firstbg = "";
if( in_array(self::cleanString($rubric->first), $tutor_comment_data_final) )
	$firstbg = ' bgcolor="#ffff99"';

$secondbg = "";
if( in_array(self::cleanString($rubric->second), $tutor_comment_data_final) )
	$secondbg = ' bgcolor="#ffff99"';
	
$secondtwobg = "";
if( in_array(self::cleanString($rubric->secondtwo), $tutor_comment_data_final) )
	$secondtwobg = ' bgcolor="#ffff99"';
	
$thirdbg = "";
if( in_array(self::cleanString($rubric->third), $tutor_comment_data_final) )
	$thirdbg = ' bgcolor="#ffff99"';
	
$passbg = "";
if( in_array(self::cleanString($rubric->pass), $tutor_comment_data_final) )
	$passbg = ' bgcolor="#ffff99"';
	
$failbg = "";
if( in_array(self::cleanString($rubric->fail), $tutor_comment_data_final) )
	$failbg = ' bgcolor="#ffff99"';	
	
	
$htmlContent .= '<tr>';
	
$htmlContent .= '<td width="58"><p><strong>'.$rubric->title.'</strong></p></td>';
$htmlContent .= '<td width="120" colspan="3" valign="top"'.$firstbg.'><p>'.$rubric->first.'</p></td>';
$htmlContent .= '<td width="110" valign="top"'.$secondbg.'><p>'.$rubric->second.'</p></td>';
$htmlContent .= '<td width="110" valign="top"'.$secondtwobg.'><p>'.$rubric->secondtwo.'</p></td>'; // 
$htmlContent .= '<td width="110" valign="top"'.$thirdbg.'><p>'.$rubric->third.'</p></td>';
$htmlContent .= '<td width="111" valign="top"'.$passbg.'><p>'.$rubric->pass.'</p></td>';
$htmlContent .= '<td width="111" colspan="3" valign="top"'.$failbg.'><p>'.$rubric->fail.'</p></td>';
    
$htmlContent .= '</tr>';

}
    
$htmlContent .= '<tr>
    <td width="752" colspan="11" valign="top"><p><strong>Tutor    Comments:</strong></p>
      <p>'.$request->tutor_comment.'</p>
      <p><strong>Tutor Signature:     '.$request->tutor_sign.'                                                          Date: '.$request->end_date.'</strong></p></td>
  </tr>
</table></body>
</html>';
            
            //$section = $phpWord->addSection();

            $table = array('borderColor'=>'black', 'borderSize'=> 5, 'cellMargin'=>50, 'valign'=>'center');
        	$phpWord->addTableStyle('table', $table);
            
			$section = $phpWord->addSection(array(
												'marginLeft' => 230, 
												'marginRight' => 300, 
												'marginTop' => 600, 
												'marginBottom' => 600)
										   );
            
            
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
    
    private function cleanString($text)
    {
        $text = str_replace(" ", "", $text);
		$text = str_replace(array("\r", "\n"), "", $text);
        return $text;
    }
    
}