<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PageViewer
 *
 * @author User
 */
class PageViewer extends WebService {

	function p ($id = 0)
	{
		if ($id == 0) {
			$id = (isset($_GET['id']) ? addslashes($_GET['id']) : 0);
		}

		if ($id) {

			$page = new Page();
			$page->getByID($id);
			if (!isset($page->post_title) || $page->post_title == '') {
				die('Not Found');
			}
			$page->setSEO();
			?>
			<style>
				.pl_file_item {
					padding          : 10px;
					clear            : both;
					text-decoration  : underline;
					color            : #0072b1;
					cursor           : pointer;
					background-color : #efefef;
				}

				.if_text {
					height      : 30px;
					line-height : 30px;
					float       : left;
					margin-left : 10px;
				}

				.fotoIF {
					width    : 30px;
					height   : 30px;
					overflow : hidden;
					float    : left;
				}

				.fotoIF img {
					width : 30px;
				}

				.h3pv {
					font-size      : 18px;
					border-bottom  : 1px dashed #333;
					padding-bottom : 10px;
					margin-bottom  : 0px;
				}
			</style>
			<h1 style="padding-bottom: 0; margin-bottom: 0; margin-bottom: 10px;"><?= stripslashes($page->post_title); ?></h1>
			<small style="font-size: 12px;"><?= indonesian_date($page->post_modified); ?></small>

			<div class="postcontent">
				<?= stripslashes($page->post_content); ?>
			</div>

			<? if ($page->post_files != "") {
				?>
				<!--<div class="clearfix"
				     style="padding:  10px 0 10px 0;">

					<h3 class="h3pv"><?= Lang::t('Attachments'); ?></h3>

					<div style="">
						<?/*
						$exp = explode(",", trim(rtrim($page->post_files)));
						$arrNames = array ();
						foreach ($exp as $fil) {
							// echo $fil."<br>";
							if ($fil == "") {
								continue;
							}
							$exp2 = explode(".", $fil);
							$if = new \InputFileModel();

							// echo $exp2[0]."<br>";
							$if->getByID($exp2[0]);
							$arrNames[] = $if;
							$text .= $if->printLink();
						}
						echo $text;*/
				?>
					</div>
				</div>-->
			<?
			}
		}
	}
}
