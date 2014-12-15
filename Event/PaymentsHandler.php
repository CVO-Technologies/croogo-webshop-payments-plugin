<?php

App::uses('CakeEventListener', 'Event');

class PaymentsHandler implements CakeEventListener {

	public function implementedEvents() {
		return array(
			//'Payment.status' => 'updateBuyStatistic',
		);
	}

	public function __construct() {
		$this->Payment = ClassRegistry::init('WebshopPayments.Payment');
	}

}
