<?php
class EvilLyrics extends AppModel {    
	var $name = 'EvilLyrics';
	var $useTable=false;
	
	function find($artist,$song){
		$artist=urlencode($artist);
		$song=urlencode($song);
		$request=array(
			"url"=>"http://www.evillabs.sk/evillyrics/gc2.php?artist={$artist}&song={$song}"
		);
		if($return=$this->getUrl($request)){
			$parts=explode(";",$return);
			if((isset($parts[1]) && is_numeric($parts[1]) )){
				/*
				 * if kas.split(";")[-1].lower().startswith("http://"):
			url = kas.split(";")[-1]
			lyrics,timeout = plain_lyrics.getLyricsFromUrl(url,proxy=self.proxy)
			if not timeout and lyrics:
				lrc,difference = mergeTextAndKas(lyrics,kas)
				
				if difference <= len(lyrics.splitlines())/3.0:
					try:
						lrc = "[ar:%s]\r\n[ti:%s]\r\n" % (artist,title) + lrc
					except Exception,e:
						sys.stdout.write(e+'\n')
					return (lrc,False)
		urls,timeout = plain_lyrics.getUrlsFromGoogle(artist,title,self.proxy)
				 */
				$url=end($parts);
				if(strpos($url,"http://")===0){
					$lyrics=$this->getUrl(array(
							"url"=>$url,
							"userAgent"=>"Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)"
						)
					);
					
					$lyrics=$this->extractLyrics($lyrics);
					debug("extracting html");
					die;
					debug($lyrics);
					die;
					debug($parts);
				}else return false;
				
			}else return false;
		}else return false;
		die;
	}
	
}