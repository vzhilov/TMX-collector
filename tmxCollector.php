<?php

$tmxDir = "/home/";

$tmx_db = mysqli_connect('localhost', 'tmx', 'mypass', 'tmx');

$ruFiles = glob($tmxDir.'*_[rR][uU].[tT][xX][tT]');

foreach ($ruFiles as $ruFile) {

	$enFile = substr($ruFile, 0, -7)."_en.txt";
	if (file_exists($enFile)) {
	  $ruText=file_get_contents($ruFile);
	  $enText = file_get_contents($enFile);
	  
	  $ruSentencesArray = breakDown2Sentences($ruText);
	  $enSentencesArray = breakDown2Sentences($enText);
	  //Then we insert to SQL
	  
	  $direction = 0;
	  $count = 1;
	  $i = 0;
	  $ruSentence = "";
	  $enSentence = "";
	  
	  $stmtSelect = $tmx_db->prepare("SELECT id FROM `tmx` where `source` = ?;");
	  $stmtSelect->bind_param("s", $ruSentence); 
	  
	  $stmtInsert = $tmx_db->prepare("INSERT INTO `tmx` ( `direction`, `source`, `target`, `count` ) VALUES ( ?, ?, ?, ? );");
//echo $tmx_db->error;
	  $stmtInsert->bind_param("issi", $direction, $ruSentence, $enSentence, $count);
	  
	  $stmtUpdate = $tmx_db->prepare("UPDATE `tmx` SET `count` = `count`+1 WHERE id = ?;");
	  $stmtUpdate->bind_param("i", $id);

	  foreach ($ruSentencesArray as $ruSentence) {
		$enSentence = $enSentencesArray[$i];
		
		$stmtSelect->execute();
		$stmtSelect->store_result();
		if ($stmtSelect->num_rows == 0) {
		  $stmtInsert->execute();
		} else {
		  $row = $stmtSelect->fetch(); 
		  $id = $row['id'];
		  $stmtUpdate->execute();
		}
		$i++;
	  }
	  
	  
	  //Then we form .tmx file out of SQL table
	}
}
    
    
    
    
    
    
    
function breakDown2Sentences($fullText) {
  $fullText = mb_convert_encoding($fullText, 'UTF-8');
  $sentecesArray = array();
  $paragraphs = array_filter(explode("\n", $fullText));
  foreach ($paragraphs as $paragraph) {
    if (strpos(".", $paragraph)) {
      $sentences = array_filter(explode(".", $paragraph));
      foreach ($sentences as $sentence) {
        $sentencesArray[] = trim($sentence);
      }
    } else $sentencesArray[] = trim($paragraph);
  }

  return $sentencesArray;
}

?>
