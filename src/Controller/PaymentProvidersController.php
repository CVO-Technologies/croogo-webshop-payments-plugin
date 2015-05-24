<?php

App::uses('WebshopPaymentsAppController', 'WebshopPayments.Controller');

class PaymentProvidersController extends WebshopPaymentsAppController {

	public $components = array('Paginator');

	public function admin_index() {
		$payment_providers = $this->Paginator->paginate('PaymentProvider');

		$this->set(compact('payment_providers'));
	}

}