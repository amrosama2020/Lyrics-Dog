<?php
class Lyric extends AppModel {    
	var $name = 'Lyric';
	var $belongsTo=array(
		 'Artist' => array(
		 	'className'=> 'Artist',
			'foreignKey'=> 'artist_id'
		)
	);
}