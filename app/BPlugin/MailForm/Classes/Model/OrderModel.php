<?php

/**
 * Created by PhpStorm.
 * User: MarcelSantoso
 * Date: 1/16/15
 * Time: 2:52 PM
 */
class OrderModel extends ModelPortalContent {

	//Nama Table
	public $table_name = "sp_order";

	//Primary
	public $main_id = 'order_id';

	//Default Coloms for read
	public $default_read_coloms = 'order_id,order_name,order_payment_status,order_payment_details,created_at';

	//allowed colom in CRUD filter
	public $coloumlist = 'order_id,order_id_text,order_name,order_mobile,order_city,order_address,order_comment,order_items,order_items_text,order_price,order_shipping_cost,order_email,order_payment_status,order_production_status,created_at,order_payment_details,order_resi';

	public $order_id;
	public $order_id_text;
	public $order_name;
	public $order_mobile;
	public $order_city;
	public $order_address;
	public $order_comment;
	public $order_items;
	public $order_items_text;
	public $order_price;
	public $order_shipping_cost;
	public $order_email;
	public $order_payment_status;
	public $order_production_status;
	public $order_payment_details;
	public $order_resi;
	public $created_at;

	public $arrPayment    = array (0 => "Not Confirmed",
	                               1 => "Waiting for Confirmation from Hulx.net",
	                               2 => "Confirmed");
	public $arrProduction = array (0 => "Pending",
	                               1 => "Processed");

	public function overwriteForm ($return, $returnfull)
	{
		$return = parent::overwriteForm($return, $returnfull);

		$return['created_at'] = new Leap\View\InputText("hidden", "created_at", "created_at", $this->created_at);
		$return['order_payment_status'] =
			new \Leap\View\InputSelect($this->arrPayment, "order_payment_status", "order_payment_status",
				$this->order_payment_status);
		$return['order_production_status'] =
			new \Leap\View\InputSelect($this->arrProduction, "order_production_status", "order_production_status",
				$this->order_production_status);
		$return['date_start'] = new Leap\View\InputText("hidden", "date_start", "date_start", "");
		$return['date_end'] = new Leap\View\InputText("hidden", "date_end", "date_end", "");
		$return['order_items_text'] =
			new \Leap\View\InputTextRTE("order_items_text", "order_items_text", $this->order_items_text);
		$return['order_payment_details'] =
			new \Leap\View\InputTextRTE("order_payment_details", "order_payment_details", $this->order_payment_details);
		$return['order_items_text']->setReadOnly();
		$return['order_name']->setReadOnly();
		$return['order_mobile']->setReadOnly();
		$return['order_city']->setReadOnly();
		$return['order_address']->setReadOnly();
		$return['order_comment']->setReadOnly();
		$return['order_items']->setReadOnly();
		$return['order_price']->setReadOnly();
		$return['order_shipping_cost']->setReadOnly();
		$return['order_email']->setReadOnly();
		$return['order_payment_details']->setReadOnly();

		return $return;
	}

	public function overwriteRead ($return)
	{
		$return = parent::overwriteRead($return);

		$objs = $return['objs'];
		foreach ($objs as $obj) {
			if (isset($obj->created_at)) {
				$obj->created_at = date("d-m-Y", strtotime($obj->created_at));
			}

			if (isset($obj->order_payment_status)) {
				$obj->order_payment_status = $this->arrPayment[$obj->order_payment_status];
			}

			if (isset($obj->order_production_status)) {
				$obj->order_production_status = $this->arrProduction[$obj->order_production_status];
			}
		}

		return $return;
	}

	public function constraints ()
	{
		//err id => err msg
		$err = array ();
		if ($this->order_resi && $this->order_payment_status < 2) {
			$err['order_resi'] = Lang::t("Resi is allowed only when payment_status is confirmed");
		}

		if (!$err) {
			$this->sendMailPayment();
			$this->sendMailDelivery();
		}

		return $err;
	}

	public function sendMailPayment ()
	{
		$objOld = new OrderModel();
		$objOld->getByID($this->order_id);

		if ($objOld->order_payment_status == 1 && $this->order_payment_status == 2) {
			Payment::paymentSuccess($this);
		}
	}

	public function sendMailDelivery ()
	{
		$objOld = new OrderModel();
		$objOld->getByID($this->order_id);

		if (!$objOld->order_resi && $this->order_resi) {
			Payment::orderSent($this);
		}
	}
}
