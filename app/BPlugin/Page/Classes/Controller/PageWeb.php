<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PageWeb
 *
 * @author User
 */
class PageWeb extends WebService {

	const ID_ABOUT   = 1;
	const ID_CONTACT = 2;
	const ID_TERMS   = 3;

	/*
	 * nama fungsi dan nama kelas harus sama spy crudnya bs jalan
	 * untuk mengisi calendar
	 */
	public function page ()
	{
		//create the model object
		$cal = new Page();
		//send the webclass
		$webClass = __CLASS__;
		$_SESSION['pageConID'] = "";
		//by pass the form
		$cmd = (isset($_GET['cmd']) ? addslashes($_GET['cmd']) : 'read');
		if ($cmd == "edit") {
			//Crud::createForm($obj,$webClass);
			//die('edit');
			$id = (isset($_GET['id']) ? addslashes($_GET['id']) : 0);
			if ($id) {
				$cal->getByID($id);
			}
			$mps['id'] = $id;
			$mps['obj'] = $cal;
			Mold::plugin("Page", "pageForm", $mps);
			exit();
		}

		Crud::run($cal, $webClass);
	}

	public static function portalIndex ($pageId = 0)
	{
		if ($pageId == 0) {
			$pageId = $_GET["id"];
		}

		?>
		<div class="container">
			<!-- form -->
			<div class="content inside-page about">
				<? $page = new Page();
				$page->getByID($pageId);?>
				<div class="breadcrumb"><a href="<?= _SPPATH ?>">Home</a> / <span><?= $page->post_title ?></span></div>
				<?
				$pp = new PageViewer();
				$pp->p($pageId);
				?>
			</div>
		</div>
	<?
	}

}
