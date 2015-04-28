<?php

/**
 * Created by PhpStorm.
 * User: MarcelSantoso
 * Date: 2/12/15
 * Time: 5:09 PM
 */
class Payment extends WebService {

	public static function sendMail ($emailTo, $message)
	{
		$headers = "From: " . Efiwebsetting::getOrderFrom() . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		mail($emailTo, Efiwebsetting::getOrderSubject(), $message, $headers);
	}

	public static function orderSent (OrderModel $order)
	{
		$message = "Dear " . $order->order_name . ",<br><br>
					Order Anda telah dikirim dengan menggunakan jasa JNE ke alamat berikut <br>" .
			$order->order_address .
			"<br><br>
					No. Resi Anda : " . $order->order_resi . "<br>
					<br>
					Bila Anda tidak menerima paket Anda, <br>
					silakan hubungi kami melalui website kami <a href=\"" . _BPATH . "ask\">Hulx.net Inquiry</a><br>
					<br>
					Terima kasih.<br>
					<br>
					Warmest Regards,<br>
					Team <a href=\"http://hulx.net\">Hulx.net</a>";

		Payment::sendMail($order->order_email, $message);
	}

	public static function paymentSuccess (OrderModel $order)
	{
		$message = "Dear " . $order->order_name . ",<br><br>
					Pembayaran Invoice No. <a href=\"" . _BPATH . "receipt?id=" . $order->order_id_text . "\">" .
			$order->order_id_text . "</a> telah kami terima.<br>
					Pesanan anda akan segera kami proses.<br>
					<br>
					Terima kasih atas kepercayaan anda untuk berbelanja dengan <a href=\"http://hulx.net\">Hulx.net</a>.<br>
					Kami senang dapat melayani anda.<br>
					<br>
					Warmest Regards,<br>
					Team <a href=\"http://hulx.net\">Hulx.net</a>";

		Payment::sendMail($order->order_email, $message);
	}

	public function confirmPayment ()
	{
		$orderId = $_POST['id'];
		$paymentDetails = "<style type=\"text/css\">
								.tg {
									border-collapse : collapse;
									border-spacing  : 0;
								}

								.tg td {
									overflow     : hidden;
									word-break   : normal;
								}
							</style>
							<table class=\"tg\">
								<tr>
									<td class=\"tg-031e\"
									    style=\"padding-right: 5px;\">Nama Pemilik Rek.
									</td>
									<td class=\"tg-031e\">: <strong>" . $_POST['name'] . "</strong>
									</td>
								</tr>
								<tr>
									<td class=\"tg-031e\"
									    style=\"padding-right: 5px;\">Tanggal Pembayaran
									</td>
									<td class=\"tg-031e\">: <strong>" . $_POST['date'] . "</strong></td>
								</tr>
								<tr>
									<td class=\"tg-031e\"
									    style=\"padding-right: 5px;\">Jumlah Transfer
									</td>
									<td class=\"tg-031e\">: <strong>" . $_POST['total'] . "</strong></td>
								</tr>
								<tr>
									<td class=\"tg-031e\"
									    style=\"padding-right: 5px;\">Nama Bank
									</td>
									<td class=\"tg-031e\">: <strong>" . $_POST['bank'] . "</strong></td>
								</tr>
							</table>";

		$model = new OrderModel();
		$model->getByID($_POST['id']);

		$model->order_payment_status = 1;
		$model->order_payment_details = $paymentDetails;
		$model->save();

		$message = "Dear " . $model->order_name . ",<br><br>
					Anda baru saja mengkonfirm pembayaran dengan details sebagai berikut :
					<br>" . $paymentDetails . "
					<br>
					Status pembayaran anda sekarang : <strong>" . $model->arrPayment[$model->order_payment_status] . "</strong>.<br><br>
					Anda dapat melihat invoice beserta status pembayaran anda melalui link berikut <br>
					Invoice Number : <a href=\"" . _BPATH . "receipt?id=" . $model->order_id_text . "\">" .
			$model->order_id_text . "</a><br>
					<br>
					Kami akan memberikan konfirmasi lebih lanjut,<br>
					setelah pembayaran masuk ke akun kami.<br>
					<br>
					Terima kasih.<br><br>
					Warmest Regards,<br>
					Team <a href=\"http://hulx.net\">Hulx.net</a>";

		$this::sendMail($model->order_email, $message);

		print_r($orderId);
	}

	function checkout ()
	{
		$nama = $_POST['name'];
		$mobile = $_POST['mobile'];
		$kota = $_POST['kota'];
		$address = $_POST['address'];
		$comment = $_POST['comment'];
		$shippingCost = $_POST['shipping_cost'];
		$email = $_POST['email'];

		$arrItems = $_SESSION['hulx_items'];
		$totalPrice = 0;

		$message = '';
		$order = "<style type=\"text/css\">
					.items {
						border-collapse : collapse;
						border-spacing  : 0;
					}

					.items td {
						padding    : 5px 10px 5px 10px;
						overflow   : hidden;
						word-break : normal;
						text-align : center;
					}

					.items tr {
						border-left  : 1px solid;
						border-right : 1px solid;
					}

					.items th {
						font-weight : bold;
						padding     : 5px 10px 5px 10px;
						border      : 1px solid;
						overflow    : hidden;
						word-break  : normal;
					}

					.total {
						border : 1px solid;
					}
				</style>
				<br><strong>Order Details</strong><br>
				<table class=\"items\">
					<tr>
						<th class=\"tg-031e\">Item Name</th>
						<th class=\"tg-031e\">Item Price</th>
						<th class=\"tg-031e\">Item Quantity</th>
						<th class=\"tg-031e\">Item Size</th>
						<th class=\"tg-031e\">Total</th>
					</tr>";

		foreach ($arrItems as $item) {
			$arr = explode(';', $item);
			$id = $arr[0];
			$qty = $arr[1];
			$color = $arr[2];
			$size = $arr[3];

			$img = new GalleryModel();
			$img->getByID($id);
			$totalPrice += $img->image_price_disc * $qty;

			$input = new InputFileModel();
			$order .= "<tr>
						<td>$img->image_name<br><img style=\"width: 70px;\" src=\"" . _BPATH . $input->upload_url .
				$color . "\"></td>
						<td>" . rupiah($img->image_price_disc) . "</td>
						<td>" . $qty . "</td>
						<td>" . $size . "</td>
						<td>" . rupiah($img->image_price_disc * $qty) . "</td>
					</tr>";
		}

		$order .= "<tr class=\"total\">
						<td></td>
						<td></td>
						<td></td>
						<td style=\"text-align: left\"><strong>Subtotal</strong></td>
						<td style=\"text-align: right\">" . rupiah($totalPrice) . "</td>
					</tr>
					<tr class=\"total\">
						<td></td>
						<td></td>
						<td></td>
						<td style=\"text-align: left\"><strong>Shipping Cost</strong></td>
						<td style=\"text-align: right\">" . rupiah($shippingCost) . "</td>
					</tr>
					<tr class=\"total\">
						<td></td>
						<td></td>
						<td></td>
						<td style=\"text-align: left\"><strong>Total</strong></td>
						<td style=\"text-align: right\"><strong>" . rupiah($totalPrice + $shippingCost) . "</strong></td>
					</tr>
					<tr>
				</table>";

		$obj = new OrderModel();
		$obj->order_name = $nama;
		$obj->order_email = $email;
		$obj->order_mobile = $mobile;
		$obj->order_city = $kota;
		$obj->order_address = $address;
		$obj->order_comment = $comment;
		$obj->order_items_text = str_replace("width: 70px;", "width: 100px;", $order);
		$obj->order_items = json_encode($arrItems);
		$obj->order_shipping_cost = $shippingCost;
		$obj->order_price = $totalPrice + $shippingCost;
		$obj->created_at = leap_mysqldate();
		$id = $obj->save();

		$newObj = new OrderModel();
		$newObj->getByID($id);
		$newObj->order_id_text = strtoupper("HLX-" . strstr($email, '@', true) . "-" . $id);
		$newObj->save();

		$message = "<div>
					Dear $obj->order_name,<br>
					Terima kasih telah melakukan transaksi melalui <a href=\"http://hulx.net\">Hulx.net</a>,<br><br>Silakan
					melakukan pembayaran via transfer sejumlah <strong>" . rupiah($obj->order_price) . "</strong> ke rekening Hulx.net :
					<br><br>
					" . Receipt::getRekening() . "

					<br>Bila sudah melakukan pembayaran,
					<br>silakan konfirmasi pembayaran via website melalui link berikut : <a href=\"" . _BPATH .
			"receipt?id=$newObj->order_id_text\">Konfirmasi Pembayaran</a>

					<br>
					<br>
					<strong>Personal Details</strong><br>
					<style type=\"text/css\">
						.tg {
							border-collapse : collapse;
							border-spacing  : 0;
						}

						.tg td {
							overflow     : hidden;
							word-break   : normal;
						}
					</style>
					<table class=\"tg\">
						<tr>
							<td class=\"tg-031e\"
							    style=\"padding-right: 5px;\">Name
							</td>
							<td class=\"tg-031e\">: $nama
							</td>
						</tr>
						<tr>
							<td class=\"tg-031e\"
							    style=\"padding-right: 5px;\">Email
							</td>
							<td class=\"tg-031e\">: $email</td>
						</tr>
						<tr>
							<td class=\"tg-031e\"
							    style=\"padding-right: 5px;\">Mobile
							</td>
							<td class=\"tg-031e\">: $mobile</td>
						</tr>
						<tr>
							<td class=\"tg-031e\"
							    style=\"padding-right: 5px;\">City
							</td>
							<td class=\"tg-031e\">: $kota</td>
						</tr>
						<tr>
							<td class=\"tg-031e\"
							    style=\"padding-right: 5px;\">Address
							</td>
							<td class=\"tg-031e\">: $address</td>
						</tr>
						<tr>
							<td class=\"tg-031e\"
							    style=\"padding-right: 5px;\">Panduan
							</td>
							<td class=\"tg-031e\">: $comment</td>
						</tr>
						<tr>
							<td class=\"tg-031e\"
							    style=\"padding-right: 5px;\">Receipt Link
							</td>
							<td class=\"tg-031e\">: " . _BPATH . "receipt?id=$newObj->order_id_text</td>
						</tr>
					</table>
				</div>";

		$message .= $order;
		$message .= "<br>
					 <br>
					Warmest Regards,<br>
					Team <a href=\"" . _BPATH . "\">Hulx.net</a>";

		$this::sendMail($email, $message);
		session_destroy();

		print_r($newObj->order_id_text);
	}

	public function getOngkir ()
	{
		$kota = $_POST['city'];

		$url = 'http://api.ongkir.info/cost/find';
		$fields = array (
			'API-Key' => '0a9265457ab194cceffd5a7104ff4a9c',
			'format'  => 'json',
			'courier' => 'jne',
			'weight'  => '1',
			'from'    => 'jakarta',
			'to'      => $kota
		);

		$fields_string = '';
		foreach ($fields as $key => $value) {
			$fields_string .= $key . '=' . $value . '&';
		}

		rtrim($fields_string, '&');

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, count($fields));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

		$result = curl_exec($ch);

		curl_close($ch);
	}
} 