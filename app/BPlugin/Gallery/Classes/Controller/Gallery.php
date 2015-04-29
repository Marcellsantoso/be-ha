<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AccountLoginWeb
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class Gallery extends WebService {

	const PAGE_LIMIT          = 24;
	const ORDER_ALPHABET_ASC  = 1;
	const ORDER_ALPHABET_DESC = 2;
	const ORDER_PRICE_ASC     = 3;
	const ORDER_PRICE_DESC    = 4;
	public $arrImage = array ();

	public function __construct ()
	{
		$this->arrImage[1] = ' ORDER BY image_name ASC ';
		$this->arrImage[2] = ' ORDER BY image_name DESC ';
		$this->arrImage[3] = ' ORDER BY image_price_disc ASC ';
		$this->arrImage[4] = ' ORDER BY image_price_disc DESC ';
	}

	public function GalleryModel ()
	{
		//create the model object
		$cal = new GalleryModel();
		//send the webclass
		$webClass = __CLASS__;

		// JS
		if ($_GET["cmd"] == 'edit') {
			?>
			<script>
				$(document).ready(function () {
					$("#warning_image_meta_desc").text('count : ' + $("#image_meta_desc").val().length);
					$("#warning_image_meta_title").text('count : ' + $("#image_meta_title").val().length);

					$("#image_meta_desc").keyup(function () {
						$("#warning_image_meta_desc").text('count : ' + $("#image_meta_desc").val().length);
					});

					$("#image_meta_title").keyup(function () {
						$("#warning_image_meta_title").text('count : ' + $("#image_meta_title").val().length);
					});
				});
			</script>
		<?
		}

		//run the crud utility
		Crud::run($cal, $webClass);
	}

	public function getRelatedItems ()
	{
		$pageId = $_GET["page_id"];
		if (!$pageId) {
			return false;
		}

		$pageModel = new GalleryModel();
		$pageModel->getByID($pageId);

		global $db;
		$arrTag = explode(',', $pageModel->image_tag);
		if (count($arrTag)) {
			$query = 'SELECT * FROM sp_content_image WHERE ';

			$query = $query . '(';
			for ($i = 0; $i < count($arrTag); $i++) {
				$query = $query . ' image_tag like "%' . $arrTag[$i] . '%" ';
				if ($i < count($arrTag) - 1) {
					$query = $query . ' OR ';
				}
			}
			$query = $query . ')';

			$query = $query . ' AND image_id NOT IN (' . $pageId . ') AND image_active = 1 ORDER BY RAND() LIMIT 4';
		}

		$result = $db->query($query, 2);
		if ($result) {
			print_r(json_encode($result));
		}
	}

	public function getItems ()
	{
		$search = $_GET["search"];
		if ($search) {
			$search = '(image_name like "%' . $search . '%" OR image_tag like "%' . $search . '%")';
		}
		$model = new GalleryModel();
		$this->query($model, $search, $this->arrImage);
	}

	public function search ()
	{
		$query = $_GET["search"];
		$dbQuery = '(image_name like "%' . $query . '%" OR image_tag like "%' . $query . '%")';
		$model = new GalleryModel();

		$this->query($model, $dbQuery, $this->arrImage);
	}

	function query ($model, $query, $arrSort)
	{
		$page = $_GET["page"];
		if ($page > 0) {
			$page -= 1;
		}

		$order = $_GET["order"];
		if (!$order) {
			$order = ' ORDER BY image_id ';
		} else {
			$order = $arrSort[$order];
		}

		if ($query) {
			$query = $query . ' AND ';
		}

		$result = $model->getWhere($query . 'image_active = 1 ' . $order . 'limit ' . $this::PAGE_LIMIT .
			' OFFSET ' . $page * $this::PAGE_LIMIT);
		$count = $model->getJumlah($query . 'image_active = 1' . $order);

		$response = new stdClass();
		$response->response = $result;
		$response->total = $count;
		$response->page = ceil($count / $this::PAGE_LIMIT);

		print_r(json_encode($response));
	}

	function order ()
	{
		$id = $_GET["id"];
		$qty = $_GET["qty"];
		$color = $_GET["color"];
		$size = $_GET["size"];
		$_SESSION["hulx_items"][] = "$id;$qty;$color;$size";

		if ($id && $qty) {
			print_r('ok');
		}
	}

	function removeOrder ()
	{
		$index = $_GET["index"];

		unset($_SESSION["hulx_items"][$index]);

		print_r('ok');
	}

	function getOngkir ()
	{
		$kota = $_POST['city'];
		print_r('halo');
	}
}
