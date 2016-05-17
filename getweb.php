<!DOCTYPE html>
<html lang="en">
<head>
  <title>Search from PubMet</title>
  <style>
    .highlight{background: #FFFF00;}
    .highlight_important{background: #F8DCB8;}
  </style>
</head>
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Foundation | Welcome</title>
<link rel="stylesheet" href="http://dhbhdrzi4tiry.cloudfront.net/cdn/sites/foundation.min.css">
</head>
<body style='background-color: #B7CBCA;'>
 
<div class="top-bar">
<div class="top-bar-right">
<ul class="menu">
<li><a href="./demo.php" style='font-family: Impact;'>Back to Search Page</a></li>
</ul>
</div>
</div>
 
<div class="row" id="content">
<div class="medium-8 columns">
</div>
</div>
<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="http://dhbhdrzi4tiry.cloudfront.net/cdn/sites/foundation.js"></script>
<script>
      $(document).foundation();
    </script>


<?php
include("simple_html_dom.php");
// Create DOM from URL or file

$term = $_POST['term']; 
$quantity = 5; 
if(isset($_POST['quantity'])){

$quantity=$_POST['quantity'];
}

$key = preg_replace('/\s+/', '+', $term);

$html = file_get_html('http://www.ncbi.nlm.nih.gov/pubmed/?term=brugada+syndrome');

$html1 = file_get_html('http://eutils.ncbi.nlm.nih.gov/entrez/eutils/esearch.fcgi?db=pubmed&term='. $key.'&retmax='.$quantity);

$s ='';
foreach($html1->find('id') as $element) 
       $s = $s.','.$element;
$str = substr($s, 1);
  // echo "$str";
 $html2 = file_get_html('http://eutils.ncbi.nlm.nih.gov/entrez/eutils/efetch.fcgi?db=pubmed&id='.$str.'&retmode=xml');
// Find all article blocks
 $i=1;
//$term = $term.getRNAhighlight();
 //echo "$term";
echo "<div style='font-family: Roman;'>";
 foreach($html2->find('PubmedArticle') as $element) {
  echo "<h3 style='font-family: Impact;'>";
 	$ti = $element->find('ArticleTitle',0)->plaintext;
  echo $i.'. '.hightlight($ti, $term);
  echo "<small style='font-family: Impact; color:rgba(255,255,255,0.6);'>";
 	echo ' - '.$element->find('Article',0)->find('Journal',0)->find('JournalIssue',0)->find('PubDate',0)->plaintext.'<br>';
  echo '</small>';
  echo '</h3>';
 	
  echo '<p>';
  if(isset($element->find('Abstract',0)->plaintext)){
    $abst = $element->find('Abstract',0)->plaintext;
    echo 'Abstract: '.hightlight($abst, $term).'<br>';
  }
  else{
    echo 'No abstract'.'<br>';
  }
  echo '</p>';
  echo '<div class="callout" style="background-color: #CEDDD8;">'.'<ul class="menu simple">';
  echo 'PMID: '.$element->find('MedlineCitation',0)->find('PMID',0)->plaintext.'<br>';
 	echo 'Author: ';
 	foreach($html2->find('AuthorList') as $name) {
 		echo $name->find('lastname',0)->plaintext;
    echo $name->find('forename',0)->plaintext.'. ';
  }
  echo '</div>'.'</ul>';  
  $i++;
  echo '<br>';
  }
  echo "</div>";
  echo '</body>';
 //echo "$html2";
foreach($html->find('div.rprt') as $rprt) {
    $item['title']   = $rprt->find('p.title', 0)->plaintext;
    $item['intro']   = $rprt->find('p.desc', 0)->plaintext;
    $item['details'] = $rprt->find('p.details', 0)->plaintext;
    $articles[] = $item;
}
//print_r($articles);
function hightlight($stri, $keywords = '')
  {
  $keywords = preg_replace('/\s\s+/', ' ', strip_tags(trim($keywords))); // filter

  $style = 'highlight';
  $style_i = 'highlight_important';
   
  /* Apply Style */
   
  $var = '';
   
  foreach(explode(' ', $keywords) as $keyword)
  {
  $replacement = "<span class='".$style."'>".$keyword."</span>";
  $var .= $replacement." ";
   
  $stri = str_ireplace($keyword, $replacement, $stri);
  }
   
  /* Apply Important Style */
   
  //$stri = str_ireplace(rtrim($var), "<span class='".$style_i."'>".$keywords."</span>", $stri);
   
  return $stri;
  }

function getRNAhighlight(){
  $str ='';
  $json = file_get_contents("ftp://ftp.ebi.ac.uk/pub/databases/genenames/new/json/locus_types/RNA_ribosomal.json");
  $jsonIterator = new RecursiveIteratorIterator(
    new RecursiveArrayIterator(json_decode($json, TRUE)),
    RecursiveIteratorIterator::SELF_FIRST);

  foreach ($jsonIterator as $key => $val) {
      if(!is_array($val) && strcmp($key,"name")==0) {
         // echo "$key => $val".'<br>';
          $a = preg_replace('/\s+/', '', $val);
          $a = str_replace(' ', '', $a);
          $str = $str.' '.$a;
      }
  }
  return $str;
}

?>

</body>