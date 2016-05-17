<?php
	$json = file_get_contents("ftp://ftp.ebi.ac.uk/pub/databases/genenames/new/json/locus_types/RNA_ribosomal.json");
	$jsonIterator = new RecursiveIteratorIterator(
    new RecursiveArrayIterator(json_decode($json, TRUE)),
    RecursiveIteratorIterator::SELF_FIRST);

	foreach ($jsonIterator as $key => $val) {
    	if(!is_array($val) && strcmp($key,"name")==0) {
      	  echo "$key => $val".'<br>';
    	}
	}

?>