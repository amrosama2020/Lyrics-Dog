<?php
class SearchController extends appController{
	var $uses=array("Lyric");
	function find($artist,$song){
		$result=false;
		$songLyrics=false;
		//search local storage
		if($result=$this->localSearch($artist,$song)){
			//local found
			$songLyrics=$result["Lyric"]["lyrics"];
		}else{
			//remote search
			$this->loadModel("SearchEngine");
			$searchEngines=$this->SearchEngine->find("all",array(
					"conditions"=>array(
						"SearchEngine.active"=>1
					),
					"order"=>"SearchEngine.order asc"
				)
			);
			$searchEngineId=false;
			foreach($searchEngines as $k=>$searchEngine){
				$this->loadModel($searchEngine["SearchEngine"]["model_name"]);
				if(isset($this->{$searchEngine["SearchEngine"]["model_name"]})){
					if($result=$this->{$searchEngine["SearchEngine"]["model_name"]}->find($artist,$song)){
						$searchEngineId=$searchEngine["SearchEngine"]["id"];
					}
				}
			}
			//if match found need to save to db
			if($result){
				//adding artist if needed
				$songLyrics=$result;
				$this->loadModel("Artist");
				$artistAlias=$this->serialize($artist);
				$songAlias=$this->serialize($song);
				$oldArtist=$this->Artist->findByAlias($artistAlias);
				$artistId=false;
				if(!$oldArtist){
					if($this->Artist->save(array(
							"alias"=>$artistAlias,
							"title"=>$artist
						)
					)){
						$artistId=$this->Artist->id;
					}
				}else $artistId=$oldArtist["Artist"]["id"];
				if($artistId){
					//saving lyrics
					$this->Lyric->save(array(
							"search_engine_id"=>$searchEngineId,
							"artist_id"=>$artistId,
							"title"=>$song,
							"alias"=>$songAlias,
							"lyrics"=>$result
						)
					);
				}
			}
		}
		if($songLyrics)print $songLyrics;
		else print "404";
		die;
	}
	
	private function localSearch($artist,$song){
		return  $this->Lyric->find("first",array(
				"conditions"=>array(
					"Artist.alias"=>$this->serialize($artist),
					"Lyric.alias"=>$this->serialize($song)
				)
			)
		);
	}

	function serialize($string){
		return strtolower(strtr($string,array(
				","=>" ",
				"<"=>" ",
				">"=>" ",
				"="=>" ",
				")"=>" ",
				"("=>" "
			)
		));
	
	}
}