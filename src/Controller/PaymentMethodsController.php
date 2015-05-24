<?php

App::uses('WebshopPaymentsAppController', 'WebshopPayments.Controller');
App::uses('BasicPaymentProvider', 'WebshopPayments.PaymentProvider');

class PaymentMethodsController extends WebshopPaymentsAppController {

	public $components = array('Paginator');

	/**
	 * beforeFilter
	 *
	 * @return void
	 * @access public
	 */
	public function beforeFilter() {
		parent::beforeFilter();

		$this->Security->unlockedActions[] = 'admin_toggle';
	}

	public function admin_index() {
		$this->Paginator->settings = array(
			'order' => array(
				'PaymentProvider.name' => 'ASC',
				'PaymentMethod.name' => 'ASC'
			)
		);
		$payment_methods = $this->Paginator->paginate('PaymentMethod');

		$this->set(compact('payment_methods'));
	}

	/**
	 * Toggle Node status
	 *
	 * @param string $id Node id
	 * @param integer $status Current Node status
	 * @return void
	 */
	public function admin_toggle($id = null, $status = null) {
		$this->Croogo->fieldToggle($this->{$this->modelClass}, $id, $status, 'active');
	}

	public function index() {
		$paymentMethods = $this->PaymentMethod->find('all', array(
			'conditions' => array(
				'PaymentMethod.active'    => true,
				'PaymentMethod.available' => true,
			)
		));

		$this->set(compact('paymentMethods'));
	}

	public function get_usable($amount) {
		return $this->PaymentMethod->find('all', array(
			'conditions' => array(
				'PaymentMethod.minimal_amount >=' => $amount,
				'PaymentMethod.maximum_amount <=' => $amount,
			)
		));
	}

	public function get_active() {
		return $this->PaymentMethod->find('all', array(
			'conditions' => array(
				'PaymentMethod.active' => true,
				'PaymentMethod.available' => true,
			)
		));
	}

	public function get_transaction_costs($id, $money) {
		$this->PaymentMethod->id = $id;
		$payment_method = $this->PaymentMethod->read();
		$PaymentProvider = BasicPaymentProvider::get($payment_method['PaymentProvider']['class']);

		return $PaymentProvider->calculateTransactionCosts($payment_method['PaymentMethod']['alias'], $money);
	}

}