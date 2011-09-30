<?php
class Lyrdb extends AppModel {    
	var $name = 'Lyrdb';
	var $useTable=false;
	
	function find($artist,$song){
		$artist=urlencode($artist);
		$song=urlencode($song);
		$request=array(
			"url"=>"http://webservices.lyrdb.com/karlookup.php?q={$artist}+{$song}"
		);
		if($return=$this->getUrl($request)){
			$potentialLyrics=explode("\n",$return);
			if(sizeof($potentialLyrics)>0){
				return $this->parseLyricLine($potentialLyrics[0]);
			}
		}
		return false;
	}
	
	function parseLyricLine($str){
		$parts=explode("\\",$str);
		if(sizeof($parts)>0){
			$songId=$parts[0];
			$request=array(
				"url"=>"http://webservices.lyrdb.com/showkar.php?q={$parts[0]}&useid=1"
			);
			if($return=$this->getUrl($request)){
				return ($return);
			}
		}
	}
	
}