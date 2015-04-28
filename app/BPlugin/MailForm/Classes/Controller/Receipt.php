<?php

/**
 * Created by PhpStorm.
 * User: MarcelSantoso
 * Date: 2/4/15
 * Time: 11:14 PM
 */
class Receipt extends WebService {

	static function getRekening ()
	{
		return '<strong>Bank BCA</strong> - KCU Serpong<br>Acc No. <strong>4972127888</strong><br>a/n <strong>Elroy Hafidi Hardoyo</strong><br>';
	}

	static function displayReceipt ()
	{
		$id = $_GET['id'];
		$order = new OrderModel();
		$order = $order->getWhere('order_id_text like "' . $id . '"');
		if ($order) {
			$order = $order[0];
		}
		?>
		<style>
			.panel-default > .panel-heading {
				color            : #333333;
				background-color : #60ad4f;
				border-color     : #60ad4f
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

			.form-control {
				border : 1px solid #60ad4f;
			}

			.control-label {
				padding-right : 5px;
			}

		</style>
		<div class="container">
		<div class="content inside-page collection">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<div class="text-center"
					     style="margin-top: 20px;">
						<h2>Receipt for purchase #<?= $order->order_id_text ?></h2>
					</div>
					<hr>
					<?
					$sizeLeft = 6;
					$sizeRight = 6;
					if ($order->order_payment_status > 0) {
						$sizeLeft = 8;
						$sizeRight = 4;
					}
					?>
					<div class="row">
						<div class="col-xs-12 col-md-<?= $sizeLeft ?> pull-left">
							<div class="panel panel-default height">
								<div class="panel-heading">Personal Details</div>
								<div class="panel-body">
									<strong><?= $order->order_name ?></strong><br>
									<?= $order->order_mobile; ?><br>
									<? if ($order->order_comment) { ?>
										<br><strong>Comment</strong><br>
										<? echo $order->order_comment; ?><br>
									<?
									} ?>
									<br>
									<strong>Address</strong><br>
									<?= $order->order_address ?>,<br>
									<?= $order->order_city ?>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-md-<?= $sizeRight ?> pull-right">
							<div class="panel panel-default height">
								<div class="panel-heading">Payment Status</div>
								<div class="panel-body">
									<strong>Status
									        : </strong><?= $order->arrPayment[$order->order_payment_status]; ?>
									<?
									if ($order->order_payment_status == 0) {
										?>
										<br>
										<strong>Transfer to :</strong><br>
										<?= Receipt::getRekening(); ?>
										<form class="form-horizontal"
										      style="margin-top: 10px">
											<fieldset>
												<legend>Personal Details</legend>
												<div class="form-group">
													<label class="col-md-3 control-label"
													       for="input_nama_rek">Nama Pemilik</label>

													<div class="col-md-9">
														<input id="input_nama_rek"
														       name="input_nama_rek"
														       type="text"
														       placeholder="Nama Pemilik Rek."
														       class="form-control input-md">
													</div>
												</div>

												<div class="form-group">
													<label class="col-md-3 control-label"
													       for="input_nama_rek"
													       style="padding-top: 15px;">Tanggal Bayar</label>

													<div class="col-md-9">
														<input id="input_tanggal"
														       name="input_tanggal"
														       type="date"
														       placeholder="DD/MM/YYYY"
														       class="form-control input-md">
													</div>
												</div>

												<div class="form-group">
													<label class="col-md-3 control-label"
													       for="input_nama_rek">Jumlah</label>

													<div class="col-md-9">
														<input id="input_jumlah"
														       name="input_jumlah"
														       type="text"
														       placeholder="Rp. Total,-"
														       class="form-control input-md"
														       onkeypress="validateNumber(event);">
													</div>
												</div>

												<div class="form-group">
													<label class="col-md-3 control-label"
													       for="input_nama_rek">Pembayaran dari Bank</label>

													<div class="col-md-9">
														<input id="input_bank"
														       name="input_bank"
														       type="text"
														       placeholder="Nama Bank"
														       class="form-control input-md">
													</div>
												</div>
											</fieldset>
										</form>

										<button type="button"
										        class="btn btn-success btn-block pull-right"
										        style="width: 60%; margin-top: 0px;"
										        onclick="confirmPayment();">
											Confirm Payment
										</button>
									<?
									}
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="text-center"><strong>Order summary</strong></h3>
						</div>
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-condensed">
									<thead>
									<tr>
										<td><strong>Item Name</strong></td>
										<td class="text-center"><strong>Item Price</strong></td>
										<td class="text-center"><strong>Item Quantity</strong></td>
										<td class="text-center"><strong>Item Size</strong></td>
										<td class="text-right"><strong>Total</strong></td>
									</tr>
									</thead>
									<tbody>
									<?
									$arrItems = json_decode(str_replace('\\', '', $order->order_items));
									$inputModel = new InputFileModel();
									foreach ($arrItems as $item) {
									$item = explode(';', $item);
									$img = new GalleryModel();
									$img->getByID($item[0]);

									?>
									<tr>
										<td><?= $img->image_name ?><br><img class="thumb_image"
										                                    src="<?=
										                                    $inputModel->upload_url .
										                                    'thumbs/' . $item[2] ?>"></td>
										<td class="text-center"><?= rupiah($img->image_price_disc) ?></td>
										<td class="text-center"><?= $item[1] ?></td>
										<td class="text-center"><?= $item[3] ?></td>
										<td class="text-right"><?= rupiah($img->image_price_disc *
												$item[1]); ?></td>
										<?
										}
										?>
									<tr>
										<td class="highrow"></td>
										<td class="highrow"></td>
										<td class="highrow"></td>
										<td class="highrow text-center"><strong>Subtotal</strong></td>
										<td class="highrow text-right"><?= rupiah($order->order_price -
												$order->order_shipping_cost) ?></td>
									</tr>
									<tr>
										<td class="emptyrow"></td>
										<td class="emptyrow"></td>
										<td class="emptyrow"></td>
										<td class="emptyrow text-center"><strong>Shipping Cost</strong></td>
										<td class="emptyrow text-right"><?= rupiah($order->order_shipping_cost); ?></td>
									</tr>
									<tr>
										<td class="emptyrow"><i class="fa"></i></td>
										<td class="emptyrow"></td>
										<td class="emptyrow"></td>
										<td class="emptyrow text-center"><strong>Total</strong></td>
										<td class="emptyrow text-right">
											<strong><?= rupiah($order->order_price); ?></strong></td>
									</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<style>
			.height {
				min -height : 100px;
			}

			.table > tbody > tr > .emptyrow {
				border -top : none;
			}

			.table > thead > tr > .emptyrow {
				border -bottom : none;
			}

			.table > tbody > tr > .highrow {
				border -top : 3px solid;
			}
		</style>
		</div>
		</div>

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

			function confirmPayment() {
				if (validate()) {
					if (confirm('Apakah anda yakin akan meng-confirm payment?')) {
						$.post('<?=_BPATH?>' + 'Payment/confirmPayment',
							{
								id: '<?=$order->order_id;?>',
								name: $('#input_nama_rek').val(),
								date: $('#input_tanggal').val(),
								total: rupiah($('#input_jumlah').val()),
								bank: $('#input_bank').val()
							},
							function (data) {
								document.location = '<?=_SPPATH;?>' + 'receipt?id=' + '<?=$order->order_id_text?>';
							});
					}
				}
			}

			function validate() {
				if (!$.trim($('#input_nama_rek').val())) {
					alert('Nama Pemilik Rekening tidak boleh kosong');
					return false;
				}
				if (!$('#input_tanggal').val()) {
					alert('Tanggal Transfer tidak boleh kosong');
					return false;
				}
				if (!$('#input_jumlah').val()) {
					alert('Jumlah Transfer tidak boleh kosong');
					return false;
				}
				if (!$.trim($('#input_bank').val())) {
					alert('Nama Bank tidak boleh kosong');
					return false;
				}
				return true;
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