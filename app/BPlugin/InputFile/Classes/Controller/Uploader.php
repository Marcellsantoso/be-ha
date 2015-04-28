<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Uploader
 *
 * @author User
 */
class Uploader extends WebService {

	/*
	 *  handle uploads
	 */
	function uploadres ()
	{
		//apakah ada file
		$adafile = (isset($_GET['adafile']) ? $_GET['adafile'] : '');

		//cek if ada file
		if ($adafile) {
			if (file_exists(_PHOTOPATH . $adafile)) {
				//delete old file
				if (unlink(_PHOTOPATH . $adafile)) {
					//delete from log
					PortalFileLogger::deleteFileLog(_PHOTOPATH . $adafile);
					if (file_exists(_PHOTOPATH . 'thumbnail/' . $adafile)) {
						//delete old thumb file
						unlink(_PHOTOPATH . 'thumbnail/' . $adafile);
					}
				}

			}

		}

		// Generate filename
		$filename = md5(mt_rand()) . '.jpg';

		// Read RAW data
		$data = file_get_contents('php://input');

		// Read string as an image file
		$image = file_get_contents('data://' . substr($data, 5));

		// Save to disk
		if (!file_put_contents(_PHOTOPATH . $filename, $image)) {
			header('HTTP/1.1 503 Service Unavailable');
			exit();
		}

		$src = _PHOTOPATH . $filename;
		$dest = _PHOTOPATH . 'thumbnail/' . $filename;
		$this->make_thumb($src, $dest, 200);

		// Clean up memory
		unset($data);
		unset($image);

		if (isset($_SESSION['target_id']['obj'])) {
			$target = get_class($_SESSION['target_id']['obj']);
		} else {
			$target = "unknown";
		}

		$namaasli = $_GET['fname'];
		PortalFileLogger::save2log(_PHOTOPATH . $filename, $target, $namaasli);

		// Return file URL
		echo $filename;
		//exit();

	}

	function make_thumb ($src, $dest, $desired_width)
	{

		/* read the source image */
		$source_image = imagecreatefromjpeg($src);
		$width = imagesx($source_image);
		$height = imagesy($source_image);

		/* find the "desired height" of this thumbnail, relative to the desired width  */
		$desired_height = floor($height * ($desired_width / $width));

		/* create a new, "virtual" image */
		$virtual_image = imagecreatetruecolor($desired_width, $desired_height);

		/* copy source image at a resized size */
		imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);

		/* create the physical thumbnail image to its destination */
		imagejpeg($virtual_image, $dest);
	}

	public function uploadfiles ()
	{

		//apakah ada file
		$adafile = (isset($_GET['adafile']) ? $_GET['adafile'] : '');

		//cek if ada file
		if ($adafile) {
			$if = new InputFileModel();
			$uploadpath = $if->upload_location;
			if (file_exists($uploadpath . $adafile)) {
				//delete old file
				if (unlink($uploadpath . $adafile)) {
					$arrf = $if->getWhere("file_filename = '$adafile' LIMIT 0,1");
					if (count($arrf) > 0) {
						$if->delete($arrf[0]->file_id);
					}
					//delete from log
					PortalFileLogger::deleteFileLog($uploadpath . $adafile);
					/*if(file_exists(_PHOTOPATH.'thumbnail/' . $adafile))
					{
						//delete old thumb file
						unlink(_PHOTOPATH.'thumbnail/' . $adafile);
					}*/
				}

			}

		}

		$data = array ();
		//$tid = (isset($_GET['tid'])?addslashes($_GET['tid']):die('no ID'));
		$t = (isset($_GET['t']) ? addslashes($_GET['t']) : die('no t'));
		$data['files'] = $_GET['files'];
		$data['bool'] = 0;
		$dc = new InputFileModel();

		if (isset($_GET['files'])) {

			$error = false;
			$files = array ();
			$uploaddir = $dc->upload_location;
			foreach ($_FILES as $file) {

				$f = new InputFileModel();
				$q = "INSERT INTO {$f->table_name} SET file_folder_id = '0',file_author = '" . Account::getMyID() . "'";
				global $db;
				$fid = $db->qid($q);
				$f->getByID($fid);
				if ($fid) {
					$newname = $fid;
					$f->file_url = basename($file['name']);
					$ext = end((explode(".", $file['name'])));
					$f->file_ext = $ext;
					$f->file_filename = $fid . "." . $ext;
					$f->file_date = leap_mysqldate();
					// if pdf

					if (move_uploaded_file($file['tmp_name'], $uploaddir . $f->file_filename)) {
						$files[] = $uploaddir . $file['name'];
						$f->file_size = filesize($uploaddir . $f->file_filename);
						/*if($f->file_ext == "pdf"){
							$a = new PDF2Text();
							$a->setFilename($uploaddir.$f->file_filename);
							$a->decodePDF();
							$f->file_isi = preg_replace( "/\r|\n/", " ", $a->output() );

							//the path to the PDF file
							$strPDF = $uploaddir.$f->file_filename;
							$thumb = $uploaddir."thumbs/".$fid.".jpg";
							exec("convert \"{$strPDF}[0]\" \"{$thumb}\"");
						}*/

						$f->load = 1;
						$data['bool'] = $f->save();
						$data['isImage'] = Leap\View\InputFile::isImage($f->file_filename);
						$data['filename'] = $f->file_filename;

						if (isset($_SESSION['target_id']['obj'])) {
							$target = get_class($_SESSION['target_id']['obj']);
						} else {
							$target = "inputfile_unknown";
						}

						PortalFileLogger::save2log($uploaddir . $f->file_filename, $target, $f->file_url);

						die(json_encode($data));
					} else {
						$error = true;
					}
				}
			}
			$data = ($error) ? array ('error' => 'There was an error uploading your files') : array ('files' => $files);
		} else {
			$data = array ('success' => 'Form was submitted', 'formData' => $_POST);
		}
		echo json_encode($data);
	}
}
