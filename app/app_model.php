<?php
class AppModel extends model{
	function getUrl($params){
		$ch = curl_init();
		$curlOptions=array(
			CURLOPT_RETURNTRANSFER=>TRUE,
		    CURLOPT_TIMEOUT=> 30,
		    CURLOPT_URL=>$params["url"]
		);
		if(isset($params["post"]) && $params["post"]){
			$curlOptions[CURLOPT_POST]=true;
			$curlOptions[CURLOPT_POSTFIELDS]=$params["postData"];
		}
		if(isset($params["userAgent"])){
			$curlOptions[CURLOPT_USERAGENT]=$params["userAgent"];
		}
		curl_setopt_array($ch,$curlOptions);
		$return=curl_exec($ch);
		if(curl_errno($ch)){
			curl_close($ch);
			return false;
		}
		curl_close($ch);
		return $return;
	}
	
	function extractLyrics($htmlText){
		/*
		App::import('Vendor', 'simplehtml/simple_html_dom');
		$html = new simple_html_dom();
		$html->load($htmlText);
		$body=$html->find("body",0);
		$scripts=$body->find("script");
		foreach($scripts as $k=>&$v)$v->outertext="";
		$scripts=$body->find("noscript");
		foreach($scripts as $k=>&$v)$v->outertext="";
		$scripts=$body->find("style");
		foreach($scripts as $k=>&$v)$v->outertext="";
		$scripts=$body->find("comment");
		foreach($scripts as $k=>&$v)$v->outertext="";
		
		
		
		$scripts=$body->find("br");
		foreach($scripts as $k=>&$v)$v->outertext="\n";
		$scripts=$body->find("&nbsp;");
		foreach($scripts as $k=>&$v)$v->outertext=" ";
		
		var_dump($body->outertext); 
		die;
		*/
		//getting body
		$matches=array();
		if(preg_match('#<body.*>(.*)</body>#sim',$htmlText, $matches) && isset($matches[0])){
			$htmlText=$matches[0];
			$disallowedTags=array("script","noscript","style");
			foreach($disallowedTags as $tag)
				$htmlText=preg_replace ( '@<'.$tag.'[^>]*>[^>]*</'.$tag.'>@im', "" , $htmlText );
				
			$allowedTagsContent=array("u","strike","a","b","i","big","small","em","strong","tt","font");
			foreach($allowedTagsContent as $tag){
				$htmlText=preg_replace ( '@<'.$tag.'.*>(.*)</'.$tag.'>@im', '$1' , $htmlText );
			}
			$htmlText=preg_replace ( '@<.*/>@im', '' , $htmlText );
			$htmlText=preg_replace ( '@<!--.*-->@im', '' , $htmlText );
				$htmlText=preg_replace ( '@<'.$tag.'.*>(.*)</'.$tag.'>@im', '$1' , $htmlText );
			debug($htmlText);
		}
		die;
		return false;
	}
}