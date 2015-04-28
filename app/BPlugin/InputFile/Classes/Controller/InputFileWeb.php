<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InputFileWeb
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class InputFileWeb extends WebService {

	public function show ()
	{
		$url = $_GET['gurl'];
		$id = addslashes($_GET['id']);
		if ($id < 0) {
			die("no ID");
		}
		//echo $url;echo "<br>";
		//echo $id;

		$if = new InputFileModel();
		if ($url == "dm") {
			$if = new DocumentsPortal();
			//cek parent id ada 2 "company policy"
			$d = new DMWeb();
			$arrCHild2 = $d->findChildren(2);
			$arrCHild = explode(",", $arrCHild2);
			//pr($arrCHild);

		}
		$if->getByID($id);
		/*
		 * cek folder if apakah ada di child
		 */
		if ($if->file_folder_id == 2 || in_array($if->file_folder_id, $arrCHild)) {
			$if->bolehsave = "reg"; //nosave
		} else {
			$if->bolehsave = "als"; //save
		}
		//pr($if);
		$path = _SPPATH . $if->upload_url;
		$fil = $if->file_filename;
		$inp = new \Leap\View\InputFile();

		if (in_array($if->file_ext, $inp->arrImgExt)) {
			$this->showImage($if);
		} elseif (in_array($if->file_ext, $inp->arrVideoExt)) {
			$this->showVideo($if);
		} elseif ($if->file_ext == "pdf") {
			$this->showPDF($if);
		} else {
			$this->showDefault();
		}
	}

	function showDefault ($if)
	{
		$path = _SPPATH . $if->upload_url;
		$fil = $if->file_filename;
		?>
		<div class="container">
			<div class="content inside-page about">
				<!--				<div class="col-md-8">-->
				<a href="<?= $path . $fil; ?>"><?= $if->file_url; ?></a>
				<!--				</div>-->
			</div>
		</div>
		<?
		$this->fmenu($if);
	}

	function fmenu ($if)
	{
		$acc = new Account();
		$acc->getByID($if->file_author);
		$path = _SPPATH . $if->upload_url;
		$fil = $if->file_filename;
		?>
		<div class="col-md-4">
			<h3 class="h3pv"
			    style="width: 100%; overflow: hidden;"><?= $if->file_url; ?></h3>

			<div class="metadata">Author : <?= $acc->admin_nama_depan; ?> </div>
			<div class="metadata">Size : <?= $if->file_size; ?> Bytes</div>
			<div class="metadata">Date : <?= indonesian_date($if->file_date); ?> </div>
			<? if ($if->file_ext == "pdf") {
				?>
				<button style="margin-top: 5px;"
				        onclick="window.open('<?= _SPPATH; ?>js/ViewerJS/leappdf.php?nn=<?= $if->file_url; ?>&dd=<?= $if->bolehsave; ?>#<?= base64_encode($path .
					        $if->file_filename); ?>.pdf','_blank');"
				        class="btn btn-primary"><?= Lang::t('View'); ?></button>
			<?
			} else {
				?>
				<button style="margin-top: 5px;"
				        onclick="window.open('<?= $path . $fil; ?>','_blank');"
				        class="btn btn-primary"><?= Lang::t('View'); ?></button>
			<?
			}
			//pr($if);
			?>
		</div>
	<?
	}

	function showImage ($if)
	{
		$path = _SPPATH . $if->upload_url;
		$fil = $if->file_filename;
		$inp = new \Leap\View\InputFile();
		?>
		<div class="col-md-8">
			<div style="padding: 10px; text-align: center;">
				<img src="<?= $path . $fil; ?>"
				     class="img-responsive">
			</div>
		</div>

		<?
		$this->fmenu($if);
	}

	function showVideo ($if)
	{
		$path = _SPPATH . $if->upload_url;
		$fil = $if->file_filename;
		?>
		<div class="col-md-8">
			<div style="padding: 10px;">
				<video width="100%"
				       controls>
					<source src="<?= $path . $fil; ?>"
					        type="video/<?= $if->file_ext; ?>">
				</video>
			</div>
		</div>

		<?
		$this->fmenu($if);
	}

	function showPDF ($if)
	{
		//check if ada thumb
		$path = _SPPATH . $if->upload_url;
		$tpath = $if->upload_location;
		$thumb = $tpath . "thumbs/" . $if->file_id . ".jpg";

		if (file_exists($thumb)) {
			$thumburl = $path . "thumbs/" . $if->file_id . ".jpg";
		}

		?>
		<div class="col-md-8">
			<div style="padding: 10px; text-align: center;">
				<iframe src="<?= _SPPATH; ?>js/ViewerJS/leappdf.php?nn=<?= $if->file_url; ?>&dd=<?= $if->bolehsave; ?>#<?= base64_encode($path .
					$if->file_filename); ?>.pdf"
				        width='400'
				        height='300'
				        allowfullscreen
				        webkitallowfullscreen></iframe>
			</div>
		</div>

		<?
		$this->fmenu($if);
	}
}
