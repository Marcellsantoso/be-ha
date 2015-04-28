<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Page
 *
 * @author User
 */
class Page extends Model {

	var $table_name = "jp_posts";

	var $ID;
	var $post_author;
	var $post_date;
	var $post_date_gmt;
	var $post_content;
	var $post_title;
	var $post_excerpt;
	var $post_status;
	var $ping_status;
	var $post_password;
	var $post_name;
	var $to_ping;
	var $pinged;
	var $post_modified;
	var $post_modified_gmt;
	var $post_content_filtered;
	var $post_parent;
	var $guid;
	var $menu_order;
	var $post_type;
	var $post_mime_type;
	var $post_image;
	var $post_webtitle;
	var $post_webmetakey;
	var $post_metadesc;
	var $post_event_id;
	var $main_id             = "ID";
	var $default_read_coloms = "ID,post_title,post_content,post_date,post_status";
	var $coloumlist          = "ID,post_title,post_content,post_author,post_date,post_modified,post_status,post_files";
	var $post_files;

	/*
	 * waktu read alias diganti objectnya/namanya
	 */
	public function overwriteRead ($return)
	{
		$objs = $return['objs'];
		foreach ($objs as $obj) {
//			if (isset($obj->post_author)) {
//				$aut = new Account();
//				$aut->getByID($obj->post_author);
//				$obj->post_author = $aut->admin_nama_depan;
//			}
			if (isset($obj->post_content)) {

				$obj->post_content = stripslashes($obj->post_content);
			}
//			if (isset($obj->post_image)) {
//
//				$obj->post_image =
//					\Leap\View\InputFoto::getAndMakeFoto($obj->post_image, "post_image_" . $obj->post_image);
//
//			}
		}

		//pr($return);
		return $return;
	}

	public function getLatestNewsFeature ()
	{

		global $db;
		$q =
			"SELECT * FROM {$this->table_name} WHERE ID!=1 AND ID!=6 AND post_image !='' ORDER BY  post_modified DESC LIMIT 0,1";
		$obj = $db->query($q, 1);
		$this->fill(toRow($obj));
	}

	public function setSEO ()
	{
		global $template;
		//set title
		if ($this->post_webtitle != "") {
			$template->setTitle($this->post_webtitle);
		}
		if ($this->post_webmetakey != "") {
			$template->setMetaKey($this->post_webmetakey);
		}
		if ($this->post_metadesc != "") {
			$template->setMetaDesc($this->post_metadesc);
		}
	}

	/*
	* fungsi untuk ezeugt select/checkbox
	*
	*/
	public function overwriteForm2 ($return, $returnfull)
	{
		//$return  = parent::overwriteForm($return, $returnfull);
		$return['post_event_id'] =
			new Leap\View\InputText("hidden", "post_event_id", "post_event_id", $this->post_event_id);

		$return['post_author'] = new Leap\View\InputText("hidden", "post_author", "post_author", Account::getMyID());
		if ($_GET['load']) {
			$return['post_date'] = new Leap\View\InputText("hidden", "post_date", "post_date", $this->post_date);
		} else {
			$return['post_date'] = new Leap\View\InputText("hidden", "post_date", "post_date", leap_mysqldate());
		}
		$return['post_content'] = new Leap\View\InputTextRTE("post_content", "post_content", $this->post_content);
		$return['post_status'] = new Leap\View\InputSelect(array ("draft"   => "Draft",
		                                                          "publish" => "Publish"), "post_status", "post_status",
			$this->post_status);
		// $return['post_modified'] = new Leap\View\InputText("hidden","post_modified","post_modified", leap_mysqldate());
		$return['post_modified'] =
			new Leap\View\InputText("hidden", "post_modified", "post_modified", leap_mysqldate());
//		$return['post_image'] = new \Leap\View\InputFoto("foto", "post_image", $this->post_image);
		$return['post_image'] = new \Leap\View\InputText("hidden", "foto", "post_image", $this->post_image);

		return $return;
	}

	public function constraints ()
	{
		//err id => err msg
		$err = array ();

		if (!isset($this->post_title)) {
			$err['post_title'] = Lang::t('Title cannot be empty');
		}

		if (!isset($this->post_content)) {
			$err['post_content'] = Lang::t('Please provide content');

		}

		return $err;
	}
}
