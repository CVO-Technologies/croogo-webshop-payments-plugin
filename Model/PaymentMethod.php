<?php

App::uses('WebshopPaymentsAppModel', 'WebshopPayments.Model');

class PaymentMethod extends WebshopPaymentsAppModel {

	public $belongsTo = array(
		'WebshopPayments.PaymentProvider'
	);

}
