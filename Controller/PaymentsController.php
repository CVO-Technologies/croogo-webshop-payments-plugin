<?php

App::uses('WebshopPaymentsAppController', 'WebshopPayments.Controller');
App::uses('BasicPaymentProvider', 'WebshopPayments.PaymentProvider');

class PaymentsController extends WebshopPaymentsAppController {

	public $uses = array('WebshopPayments.Payment', 'WebshopPayments.PaymentMethod');

	public function panel_process($paymentId) {
		$this->Payment->id = $paymentId;
		$payment = $this->Payment->read();

		if ($payment['Payment']['payment_method_id'] === null) {
			$this->redirect(array(
				'action' => 'select_method',
				$paymentId
			));

			return;
		}

		if ($payment['Payment']['status'] === 'new') {
			$this->redirect(array(
				'action' => 'start',
				$paymentId
			));

			return;
		}
	}

	public function panel_select_method($paymentId) {
		$this->Payment->id = $paymentId;
		if (!$this->Payment->exists()) {
			throw new NotFoundException();
		}

		$payment = $this->Payment->read();

		$payment_methods = $this->PaymentMethod->find('list', array(
			'conditions' => array(
				'PaymentMethod.minimum_amount <=' => $payment['Payment']['amount'],
				'PaymentMethod.maximum_amount >=' => $payment['Payment']['amount'],
			)
		));

		debug($payment_methods);

		$this->set(compact('payment_methods'));

		if (!$this->request->is('post')) {
			return;
		}

		$this->Payment->save(array(
			$this->Payment->alias => array(
				'payment_method_id' => $this->request->data['Payment']['payment_method_id']
			)
		));

		$this->redirect(array('action' => 'process', $paymentId));
	}

	public function panel_start($id) {
		$this->Payment->id = $id;
		$this->Payment->recursive = 2;
		$payment = $this->Payment->read();

		$this->set(compact('payment'));

		if (!$this->request->is('post')) {
			return;
		}

		debug($payment);

		$provider = BasicPaymentProvider::get($payment['PaymentMethod']['PaymentProvider']['class']);
		$paymentUrl = $provider->startPayment($payment['Payment']['id'], $payment['Payment']['amount'], $payment['Payment']['description']);
		debug($paymentUrl);
		if (!$paymentUrl) {
			throw new CakeException(':(');
		}

		$this->Payment->saveField('status', 'start');

		$this->redirect($paymentUrl);
	}


}
