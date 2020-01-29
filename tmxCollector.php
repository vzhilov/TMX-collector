<?php

$tmxDir = "/home/";

$tmx_db = mysqli_connect('localhost', 'tmx', 'mypass', 'tmx');

$ruFiles = glob($tmxDir.'*_RU.txt');

//var_dump($files);

foreach ($ruFiles as $ruFile) {

//$fileLang = strtolower(substr($file, -7, 3));
$engFile = substr($ruFile, -7)."_EN.txt";
if (file_exists($engFile)) {
  $ruText=file_get_contents($ruFile);
  $engText = file_get_contents($engFile);
  
  $ruSentencesArray = breakDown2Sentences($ruText);
  $engSentencesArray = breakDown2Sentences($engText);
  
  //Then we insert to SQL
  $stmt = $tmx_db->prepare("INSERT INTO 'tmx' ( `direction`, `source` , `target`, `count` ) VALUES ( ?, ?, ?, ? ); ")
  $stmt->bind_param("issi", $direction, $ruSentence, $engSentence, $count);
  
  $direction = 0;
  $count = 1;
  $i = 0;
  
  foreach ($ruSentenceArray as $ruSentence) {
    $engSentence = $engSentencesArray[i];
    $stmt->execute();
    $i++;
  }
  
  
  //Then we form .tmx file out of SQL table
}
    
    
    
    
    
    
    
function breakDown2Sentences($fullText) {
  $sentecesArray = array();
  $paragraphs = array_filter(explode("\n", $fullText);
  foreach ($paragraphs as $paragraph) {
    if (strpos(".", $paragraph)) {
      $sentences = array_filter(explode(".", $paragraph));
      foreach ($sentences as $sentence) {
        $sentenceArray[] = trim($sentence);
      }
    } else $sentenceArray[] = trim($paragraph);
  }
}

?>
