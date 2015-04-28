<?php

/**
 * Created by PhpStorm.
 * User: MarcelSantoso
 * Date: 1/19/15
 * Time: 12:52 PM
 */
class GalleryDetails {

	public function showDetails ()
	{
		?>
		<div class="container">
		<div class="content inside-page product-details">
			<? $image = new GalleryModel();
			$image->getByID($_GET["id"]);

			$inputFile = new InputFileModel();

			global $template;
			$template->title = $image->image_meta_title;
			$template->metades = $image->image_meta_desc;
			$template->metakey = $image->image_meta_keyword;
			?>
			<style>
				.foto100 {
					float    : left;
					width    : 100px;
					height   : 100px;
					overflow : hidden;
				}

				.foto100 img {
					width   : 100px;
					opacity : 0.5;
				}

				.foto100 img.selector_active {
					border  : 2px dotted #60ad4f;
					opacity : 1;
				}
			</style>
			<div class="breadcrumb"><a href="<?= _SPPATH; ?>">Home</a> /
				<span><?= $image->image_name ?></span>
			</div>
			<div class="row">
				<div class="col-sm-5">
					<div id="ProductCarousel"
					     class="carousel slide"
					     data-ride="carousel">
						<!-- bisa di for loop untuk carousel -->
						<div class="carousel-inner">
							<?
							$item = getMainPic($image->image_url);
							?>
							<img src="<?= $inputFile->upload_url . $item ?>"
							     class="img-responsive"
							     alt="product"
							     id="img_main">
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-sm-xroffset-1 information">
					<h1><?= $image->image_name ?> </h1>
					<h4><?= $image->image_desc ?></h4>

					<div class="clearfix"
					     style="margin-top: 20px;">
						<div class="selectcolor">
							<?
							//print thumbs
							$arr = removeDuplicates(explode(',', $image->image_url));
							for ($i = 0; $i < count($arr); $i++) {

								?>
								<div class="foto100">
									<img id="thumb_<?= $i; ?>"
									     onclick="selectMe('<?= $arr[$i]; ?>','<?= $i; ?>');"
									     src="<?= $inputFile->upload_url . $arr[$i] ?>">
								</div>
							<?
							}
							?>
							<div class="clearfix"></div>
							<input type="hidden"
							       name="colorme"
							       id="colorme">
						</div>
						<script>
							function selectMe(id, num) {
								$('#colorme').val(id);
								$('.foto100 img').removeClass('selector_active');
								$('#thumb_' + num).addClass('selector_active');
								document.getElementById("img_main").src = '<?= $inputFile->upload_url?>' + id;
							}
						</script>
					</div>

					<!--<div class="description-tabs">-->
					<!-- Nav tabs -->
					<!--<ul class="nav nav-tabs"
					    role="tablist">
						<li class="active"><a href="#description"
						                      role="tab"
						                      data-toggle="tab"><?= Lang::t('Description'); ?></a></li>
					</ul>-->

					<!-- Tab panes -->
					<!--<div class="tab-content">
						<div class="tab-pane active"
						     id="description">
							<?= $image->image_desc;
					if ($image->image_tag) {
						?>
								<br />
								<?= Lang::t('Tags : '); ?>
							<?
					}
					foreach (explode(',', $image->image_tag) as $tag) {
						if (str_replace(' ', '', $tag)) {
							?>
									<a class="tag_links"
									   href="<?= _SPPATH . "?search=" . $tag ?>">#<?= $tag ?></a>
								<?
						}
					}
					?>
						</div>
						<div class="tab-pane"
						     id="size">

							<style>
								table, th, td {
									border          : 1px solid black;
									border-collapse : collapse;
								}

								th, td {
									padding : 5px;
								}
							</style>

							<div>
								<b>Kualitas kaos</b><br>
								Kaos yang kami gunakan adalah Cotton Combed 30s, dimana rajutannya adalah rajutan
								tunggal (single knit) dengan gramasi antara 140 hingga 160 gr/m2. Cotton Combed 30s
								banyak disukai oleh anak muda karena rajutannya rapat, padat, tetapi tidak panas jika
								dipakai.
							</div>

							<div class="pull-left">
								<table border="1"
								       cellpadding="10"
								       style="border-spacing: 10px; margin-top: 10px">
									<tr>
										<td>S</td>
										<td>38 x 58cm</td>
									</tr>
									<tr>
										<td>M</td>
										<td>41 x 63cm</td>
									</tr>
									<tr>
										<td>ML</td>
										<td>44 x 65cm</td>
									</tr>
									<tr>
										<td>L</td>
										<td>50 x 69cm</td>
									</tr>
									<tr>
										<td>XL</td>
										<td>52 x 71cm</td>
									</tr>
								</table>
							</div>
							<div class="pull-left">
								<img src="<?= _SPPATH ?>images/size.png"
								     style="width: 150px; height: 150px; margin-left: 20px; margin-top: 10px;">
							</div>
						</div>
					</div>-->
				</div>
			</div>
		</div>

		<div class="related-products">
			<h4><?= Lang::t('Similar Items'); ?></h4>

			<div class="row">
				<?
				$request = _BPATH . '/Gallery/getRelatedItems?page_id=' . $image->image_id;
				$response = file_get_contents($request);
				$response = json_decode($response);

				foreach ($response as $obj) {
					$mainPic = getMainPic($obj->image_url);
					?>
					<div class="col-sm-3 col-xs-6">
						<div class="product">
							<a href="<?= _SPPATH; ?>details?id=<?= $obj->image_id; ?>">
								<img src="<?= $inputFile->upload_url . $mainPic ?>"
								     class="img-responsive"
								     alt="product">
							</a>

							<div class="overlay">
								<a href="<?= _SPPATH; ?>details?id=<?= $obj->image_id; ?>&page=<?= formatUrl($obj->image_name); ?>"
								   style="display: block; height: 100%; width: 100%; text-decoration: none;">
									<div class="detail">
										<h4>
											<?= $obj->image_name ?>
										</h4>
									</div>
								</a>
							</div>
						</div>
					</div>
				<?
				}
				?>
			</div>
		</div>
		</div>
		</div>

		<script>
			function order() {

				var id = '<?= $_GET["id"]; ?>';
				var qty = $("#inputQty").val();
				var color = $("#colorme").val();
				var size = $("#input_size").val();
				if (color == "")alert("Please select color by clicking the thumbnail image")
				else
					$.get('<?=_BPATH;?>' + 'Gallery/order?id=' + id + '&qty=' + qty + '&color=' + color + '&size=' + size,
						function (data) {
							if (data == 'ok') {
								document.location = '<?=_SPPATH;?>order?id=' + id + '&qty=' + qty + '&color=' + color + '&size=' + size;
							}
						});
			}
		</script>
	<?
	}
} 