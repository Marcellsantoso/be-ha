<?php

/**
 * Created by PhpStorm.
 * User: MarcelSantoso
 * Date: 2/2/15
 * Time: 10:05 AM
 */
class MailForm extends WebService {

	const API_KEY_JNE = "0a9265457ab194cceffd5a7104ff4a9c";
	public $arrKota = array ();

	public function __construct ()
	{
		$this->arrKota[] = 'Balikpapan';
		$this->arrKota[] = 'Bandar Lampung';
		$this->arrKota[] = 'Bandung';
		$this->arrKota[] = 'Banjarmasin';
		$this->arrKota[] = 'Batam';
		$this->arrKota[] = 'Bekasi';
		$this->arrKota[] = 'Bengkulu';
		$this->arrKota[] = 'Bogor';
		$this->arrKota[] = 'Cilegon';
		$this->arrKota[] = 'Cirebon';
		$this->arrKota[] = 'Denpasar';
		$this->arrKota[] = 'Depok';
		$this->arrKota[] = 'Jakarta';
		$this->arrKota[] = 'Jambi';
		$this->arrKota[] = 'Karawang';
		$this->arrKota[] = 'Kediri';
		$this->arrKota[] = 'Magelang';
		$this->arrKota[] = 'Malang';
		$this->arrKota[] = 'Mataram';
		$this->arrKota[] = 'Medan';
		$this->arrKota[] = 'Mojokerto';
		$this->arrKota[] = 'Padang';
		$this->arrKota[] = 'Palangkaraya';
		$this->arrKota[] = 'Palembang';
		$this->arrKota[] = 'Pangkal Pinang';
		$this->arrKota[] = 'Pekanbaru';
		$this->arrKota[] = 'Pontianak';
		$this->arrKota[] = 'Probolinggo';
		$this->arrKota[] = 'Semarang';
		$this->arrKota[] = 'Solo';
		$this->arrKota[] = 'Sukabumi';
		$this->arrKota[] = 'Surabaya';
		$this->arrKota[] = 'Tangerang';
		$this->arrKota[] = 'Ujung Pandang';
		$this->arrKota[] = 'Yogyakarta';
	}

	public function OrderModel ()
	{
		//create the model object
		$cal = new OrderModel();

		//send the webclass
		$webClass = __CLASS__;

		if ($_GET["cmd"] == 'edit') {
			?>
			<script>
				$(document).ready(function () {
					$("#order_name").keyup(function () {
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

	public static function mail ()
	{
		if ($_GET['mode'] == "ins") {
			$id = addslashes($_GET['id']);
			$qty = addslashes($_GET['qty']);
			$color = addslashes($_GET['color']);
			//add to session
			$_SESSION['hulx_items'][] = $id . ";" . $qty . ";" . $color;
		}
		if ($_GET['mode'] == 'del') {
			$num = addslashes($_GET['num']);
			unset($_SESSION['hulx_items'][$num]);
		}
		?>
		<div class="container">
			<div class="content inside-page collection">

				<?
				$total = 0;
				$inputFile = new InputFileModel();

				foreach ($_SESSION["hulx_items"] as $num => $item) {
					$arr = explode(';', $item);
					$id = $arr[0];
					$qty = $arr[1];
					$color = $arr[2];
					$size = $arr[3];

					$img = new GalleryModel();
					$img->getByID($id);

					$total += $img->image_price_disc * $qty;
					?>
					<div class="row">
						<div class="">
							<div class="panel">
								<div class="panel-body">
									<div class="row">
										<div class="col-xs-4">
											<h4 class="product-name"><?= $img->image_name ?></h4>

											<div class="foto100">
												<img src="<?= $inputFile->upload_url; ?><?= $color; ?>">
											</div>
										</div>

										<div class="col-xs-8">
											<div class="pull-left"
											     style="margin-right: 10px;">
												<h6><strong><?= rupiah($img->image_price_disc); ?>
														<span class="text-muted">x </span><?= $qty ?></strong>
													<br><br>
													<strong>Size : </strong><?= $size; ?>
												</h6>

											</div>
											<div class="pull-left">
												<button onclick="deleteCart('<?= $num; ?>');"
												        type="button"
												        class="btn btn-link btn-xs">
													<span class="glyphicon glyphicon-trash"> </span>
												</button>
											</div>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>
				<?
				}
				?>

				<div class="panel-footer"
				     style="padding-bottom: inherit">
					<div class="row text-center">
						<h4 class="text-right"
						    id="total_price">Total : <strong><?= rupiah($total) ?></strong></h4>
					</div>
				</div>

				<form class="form-horizontal">
					<fieldset>

						<!-- Form Name -->
						<legend>Personal Details</legend>

						<!-- Text input-->
						<div class="form-group">
							<label class="col-md-4 control-label"
							       for="input_name">Name</label>

							<div class="col-md-5">
								<input id="input_name"
								       name="input_name"
								       type="text"
								       placeholder="Name"
								       class="form-control input-md">

							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label"
							       for="input_email">Email</label>

							<div class="col-md-5">
								<input id="input_email"
								       name="input_email"
								       type="email"
								       placeholder="Email"
								       class="form-control input-md">

							</div>
						</div>

						<!-- Text input-->
						<div class="form-group">
							<label class="col-md-4 control-label"
							       for="input_mobile">Mobile No.</label>

							<div class="col-md-4">
								<input id="input_mobile"
								       name="input_mobile"
								       type="text"
								       placeholder="Mobile No."
								       class="form-control input-md"
								       onkeypress="validateNumber(event)">

							</div>
						</div>

						<!-- Text input-->
						<div class="form-group">
							<label class="col-md-4 control-label"
							       for="input_postal">City</label>

							<div class="col-md-4">
								<select onchange="checkOngkir();"
								        id="select_kota">
									<option value=""></option>
									<?
									$mail = new MailForm();
									foreach ($mail->arrKota as $kota) {
										?>
										<option value="<?= $kota ?>"><?= $kota ?></option>
									<?
									}
									?>
								</select>

								<div id="loadingtop"
								     class="blink_me"
								     style="display: none;">Fetching data from JNE..
								</div>

								<div id="jne_div"
								     style="display: none;"> Shipping Cost :
									<span id="jne_price"></span>
									<span id="jne_price_hidden"
									      style="display: none"></span>
								</div>
							</div>
						</div>

						<!-- Textarea -->
						<div class="form-group">
							<label class="col-md-4 control-label"
							       for="input_address">Address</label>

							<div class="col-md-4">
								<textarea class="form-control"
								          id="input_address"
								          placeholder="Address"
								          name="input_address"></textarea>
							</div>
						</div>

						<!-- Textarea -->
						<div class="form-group">
							<label class="col-md-4 control-label"
							       for="input_address">Panduan ke Lokasi</label>

							<div class="col-md-4">
								<textarea class="form-control"
								          id="input_comment"
								          placeholder="Jika alamat susah dicari, silakan tulis info lokasi di sini"
								          name="input_comment"></textarea>
							</div>
						</div>

					</fieldset>
				</form>
				<div class="pull-right col-md-3"
				     style="padding-bottom: inherit">
					<button type="button"
					        class="btn btn-success btn-block"
					        onclick="checkout();">
						Checkout
					</button>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>

		<style>
			.form-control {
				border : 1px solid #60ad4f;
			}

			.panel-footer {
				padding                    : 0;
				background-color           : #ffffff;
				border-top                 : 0;
				border-bottom-right-radius : 0;
				border-bottom-left-radius  : 0;
			}

			.foto100 {
				float    : left;
				width    : 100px;
				height   : 100px;
				overflow : hidden;
			}

			.foto100 img {
				width : 100px;

			}

			.foto100 img.selector_active {
				border : 2px dotted #60ad4f;

			}

			.btn {
				text-transform : uppercase;
				background     : none;
				border         : 1px solid #60ad4f;
				border-radius  : 0;
				color          : #60ad4f;
				font-family    : sans-serif;
				font-size      : 12px;
				padding        : 4px 25px 2px;
				letter-spacing : 1px;
			}

			.btn:hover {
				text-transform : uppercase;
				background     : #60ad4f;
				border         : 1px solid #60ad4f;
				border-radius  : 0;
				color          : #ffffff;
				font-family    : sans-serif;
				font-size      : 12px;
				padding        : 4px 25px 2px;
				letter-spacing : 1px;
			}

			.blink_me {
				-webkit-animation-name            : blinker;
				-webkit-animation-duration        : 2s;
				-webkit-animation-timing-function : linear;
				-webkit-animation-iteration-count : infinite;

				-moz-animation-name               : blinker;
				-moz-animation-duration           : 2s;
				-moz-animation-timing-function    : linear;
				-moz-animation-iteration-count    : infinite;

				animation-name                    : blinker;
				animation-duration                : 2s;
				animation-timing-function         : linear;
				animation-iteration-count         : infinite;

				margin-top                        : 5px;
				color                             : #60ad4f;
			}

			@-moz-keyframes blinker {
				0% {
					opacity : 1.0;
				}
				50% {
					opacity : 0.0;
				}
				100% {
					opacity : 1.0;
				}
			}

			@-webkit-keyframes blinker {
				0% {
					opacity : 1.0;
				}
				50% {
					opacity : 0.0;
				}
				100% {
					opacity : 1.0;
				}
			}

			@keyframes blinker {
				0% {
					opacity : 1.0;
				}
				50% {
					opacity : 0.0;
				}
				100% {
					opacity : 1.0;
				}
			}
		</style>

		<script>
			function validateNumber(evt) {
				var theEvent = evt || window.event;
				var key = theEvent.keyCode || theEvent.which;
				key = String.fromCharCode(key);
				var regex = /[0-9]|\./;
				if (!regex.test(key)) {
					theEvent.returnValue = false;
					if (theEvent.preventDefault) theEvent.preventDefault();
				}
			}

			function checkOngkir() {
				var kota = $('#select_kota').val();
				if(kota == 'Jakarta'){
					kota = 'Tangerang';
				}
				$('#select_kota').attr('disabled', true);
				$('#loadingtop').show();
				$.post('<?=_BPATH?>' + 'Payment/getOngkir', {city: kota}, function (data) {
					$('#loadingtop').hide();
					$('#select_kota').attr('disabled', false);
					var obj = JSON.parse(data);
					if (obj['status']['code'] == 0) {
						var arr = obj['price'];
						$('#jne_div').show();
						$('#jne_price').text(rupiah(arr[1]['value']));
						$('#jne_price_hidden').text(arr[1]['value']);
					} else {
						$('#jne_price').text('Price Not Found');
					}

				});
			}

			function deleteCart(num) {
				if (confirm("Are you sure?")) {
					document.location = '<?=_SPPATH;?>order?mode=del&num=' + num;
				}
			}

			function checkout() {
				var name = $.trim($('#input_name').val());
				var mobile = $('#input_mobile').val();
				var kota = $('#select_kota').val();
				var address = $.trim($('#input_address').val());
				var comment = $('#input_comment').val();
				var shippingCost = $('#jne_price_hidden').text();
				var email = $.trim($('#input_email').val());

				if ('<?=count($_SESSION['hulx_items']) <= 0?>') {
					alert('No item in shopping cart');
					return;
				}
				if (!name) {
					alert('Name is required');
					return;
				}
				if (!email) {
					alert('Email is required');
					return;
				}
				if (!mobile) {
					alert('Mobile No. is required');
					return;
				}
				if (!kota) {
					alert('City is required');
					return;
				}
				if (!shippingCost) {
					alert('Shipping Cost is required');
					return;
				}
				if (!address) {
					alert('Address is required');
					return;
				}

				$.post('<?=_BPATH?>' + 'Payment/checkout', {
					name: name,
					mobile: mobile,
					kota: kota,
					address: address,
					comment: comment,
					shipping_cost: shippingCost,
					email: email
				}, function (data) {
					if (data) {
						document.location = '<?=_SPPATH;?>receipt?id=' + data;
					}
				});
			}
			function rupiah(angka) {
				var rev = parseInt(angka, 10).toString().split('').reverse().join('');
				var rev2 = '';
				for (var i = 0; i < rev.length; i++) {
					rev2 += rev[i];
					if ((i + 1) % 3 === 0 && i !== (rev.length - 1)) {
						rev2 += '.';
					}
				}
				return 'Rp. ' + rev2.split('').reverse().join('') + ',-';
			}
		</script>
	<?
	}
}