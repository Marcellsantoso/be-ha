<?php

/**
 * Created by PhpStorm.
 * User: MarcelSantoso
 * Date: 1/16/15
 * Time: 2:52 PM
 */
class TagModel extends ModelPortalContent {

	//Nama Table
	public $table_name = "sp_tag_count";

	//Primary
	public $main_id = 'tag_id';

	//Default Coloms for read
	public $default_read_coloms = 'tag_id, tag_word, tag_count';

	//allowed colom in CRUD filter
	public $coloumlist = 'tag_id, tag_word, tag_count';

	public $tag_id;
	public $tag_word;
	public $tag_count;
}
