<?php

class BasicPaymentProvider extends Object {

	/**
	 * @var $Payment Payment
	 */
	public $Payment;

	public function __construct() {
		$this->Payment = ClassRegistry::init('WebshopPayments.Payment');
	}


	static public function get($class) {
		list($plugin, $class) = pluginSplit($class, true);

		$class .= 'PaymentProvider';

		App::uses($class, $plugin . 'PaymentProvider');

		return new $class;
	}

	public function startPayment($id) {
		return false;
	}

	public function checkPaymentStatus($id) {
		return false;
	}

	public function calculateTransactionCosts($methodAlias, $money) {
		return 0;
	}

}