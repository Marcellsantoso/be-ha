<?php
/**
 * Created by PhpStorm.
 * User: MarcelSantoso
 * Date: 1/19/15
 * Time: 1:30 PM
 */

?>

<script>
	function sort() {
		var sortType = document.getElementById("sort").value;
		var newUrl = document.URL + 'index?order=' + sortType;
		newUrl = '<?= _SPPATH ?>' + 'index?order=' + sortType;

		var page = '<?=$_GET["page"]?>';
		if (page) {
			newUrl += '&page=' + page;
		}

		var search = '<?=$_GET["search"]?>';
		if (search) {
			newUrl += '&search=' + search;
		}

		window.open(newUrl, '_self', false);
	}

	/**
	 * Cloud Tag
	 */
	$(document).ready(function () {
		$("#tagcloud").tx3TagCloud({
			multiplier: 5 // default multiplier is "1"
		});
	});
</script>

<div id="container"
     class="container"
     style="padding-right: 0px; padding-left: 0px;">
	<!--form -->
	<div class="content inside-page collection">
		<div class="pull-right sortby">
			<select id="sort"
			        onchange="sort()">
				<option value="1"><?= Lang::t('Order by A to Z'); ?></option>
				<option value="2"><?= Lang::t('Order by Z to A'); ?></option>
				<option value="3"><?= Lang::t('Order by Price'); ?></option>
				<option value="4"><?= Lang::t('Order by Price Descending'); ?></option>
			</select>
		</div>
		<h2 class="title"><? $setting = new Efiwebsetting();
			$arr = $setting->getWhere('set_id like "H1_title"');
			foreach ($arr as $obj) {
				echo $obj->set_value;
			}?>
		</h2>

		<div class="row">

			<?
			$page = $_GET["page"];
			if (!$page) {
				$page = 0;
			}

			$order = $_GET["order"];

			$keyword = $_GET["search"];
			if ($keyword) {
				$request = _BPATH . 'Gallery/search?search=' . $keyword;
			}

			if (!$request) {
				$request = _BPATH . 'Gallery/getItems?page=' . $page;
			} else {
				if ($page) {
					$request = $request . '&page=' . $page;
				}
			}

			if ($order) {
				$request = $request . "&order=" . $order;
			}

			$response = file_get_contents($request);
			$response = json_decode($response);
			$arrImg = $response->response;

			foreach ($arrImg as $img) {
				$image_url = getMainPic($img->image_url);
				$inputFile = new InputFileModel();
				?>
				<!-- product -->
				<div class="col-sm-4">
					<div class="product">
						<a href="<?= _SPPATH; ?>details?id=<?= $img->image_id; ?>">
							<img src="<?= $inputFile->upload_url . $image_url; ?>"
							     class="img-responsive"
							     alt="product">
						</a>
						<script>
							function click() {
								window.alert('as');
							}
						</script>

						<div class="overlay">
							<a href="<?= _SPPATH; ?>details?id=<?= $img->image_id; ?>&page=<?= formatUrl($img->image_name); ?>"
							   style="display: block; height: 100%; width: 100%; text-decoration: none;">

								<div class="detail">
									<h4><?= $img->image_name; ?></h4>
									<div class="btn btn-default view animated fadeInLeft"><?= Lang::t('View Details'); ?></div>
								</div>
							</a>
						</div>
					</div>
				</div>
			<?
			}
			?>
		</div>

		<div class="center">
			<ul class="pagination">
				<?
				$page = $response->page;
				$pagination = 0;
				if ($page >= 3) {
					$pagination = 3;
				} else {
					$pagination = $page;
				}

				$curPage = $_GET["page"];
				if (!$curPage) {
					$curPage = 1;
				}

				$search = $_GET["search"];
				if ($search) {
					$search = '&search=' . $search;
				}

				$order = $_GET["order"];
				if ($order) {
					$search = '&order=' . $order;
				}

				if ($curPage > 1) {
					?>
					<li><a href="<?= _SPPATH . "index?page=" . ($curPage - 1) . $search ?>">«</a></li>
				<?
				}

				for ($i = $curPage; $i <= $page; $i++) {
					if ($i <= $curPage + 2) {
						?>
						<li><a href="<?= _SPPATH . "index?page=" . $i . $search ?>"><? if ($i == $curPage + 2) {
									echo "...";
								} else {
									echo $i;
								} ?><span class="sr-only">(current)</span></a></li>
					<?
					}
				}
				if ($curPage < $page) {
					?>
					<li><a href="<?= _SPPATH . "index?page=" . ($curPage + 1) . $search ?>">»</a></li>
				<?
				}
				?>
			</ul>
		</div>
	</div>
</div>
