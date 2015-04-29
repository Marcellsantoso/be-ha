<?php

/**
 * Created by PhpStorm.
 * User: MarcelSantoso
 * Date: 1/16/15
 * Time: 2:52 PM
 */
class GalleryModel extends ModelPortalContent {

	//Nama Table
	public $table_name = "sp_content_image";

	//Primary
	public $main_id = 'image_id';

	//Default Coloms for read
	public $default_read_coloms = 'image_id, image_name, image_code, image_url';

	//allowed colom in CRUD filter
	public $coloumlist = 'image_id, image_name, image_desc, image_code, image_url, image_active,  image_tag';

	public $image_id;
	public $image_name;
	public $image_desc;
	public $image_code;
	public $image_url;
	public $image_active;
//	public $image_meta_desc;
//	public $image_price;
//	public $image_price_disc;
//	public $image_meta_title;
//	public $image_tag;

	public function overwriteForm ($return, $returnfull)
	{
		$return = parent::overwriteForm($return, $returnfull);

		$return['image_active'] =
			new \Leap\View\InputSelect($this->arrayYesNO, "image_active", "image_active", $this->image_active);
//		$return['image_price'] = new \Leap\View\InputText("number", "image_price", "image_price", $this->image_price);
//		$return['image_price_disc'] =
//			new \Leap\View\InputText("number", "image_price_disc", "image_price_disc", $this->image_price_disc);
		$return['image_code'] = new \Leap\View\InputText("text", "image_code", "image_code", $this->image_code);
		$return['image_url'] = new Leap\View\InputGallery("image_url", "image_url", $this->image_url);
		$return['image_desc'] = new \Leap\View\InputTextRTE("image_desc", "image_desc", $this->image_desc);
//		unset($return['date_start']);
//		unset($return['date_end']);
//		unset($return['image_meta_desc']);
//		unset($return['image_meta_title']);
//		$return['image_meta_desc'] =
//			new \Leap\View\InputTextArea("image_meta_desc", "image_meta_desc", $this->image_meta_desc);

		return $return;
	}

	public function overwriteRead ($return)
	{
		$return = parent::overwriteRead($return);

		$objs = $return['objs'];
		foreach ($objs as $obj) {
			if (isset($obj->image_active)) {
				$obj->image_active = $this->arrayYesNO[$obj->image_active];
			}
			if (isset($obj->image_url)) {
				$obj->image_url =
					\Leap\View\InputFoto::getAndMakeFoto('' . getMainPic($obj->image_url), "image_" . $obj->image_id);
			}
		}

		return $return;
	}

	public function constraints ()
	{
		//err id => err msg
		$err = array ();

		if (!isset($this->image_name)) {
			$err['image_name'] = Lang::t('Image name cannot be emtpy');
		}
		if (!isset($this->image_url)) {
			$err['image_url'] = Lang::t('Image cannot be empty');
		}

		$this->tag = str_replace(' ', ',', $this->image_tag);

		return $err;
	}

}
