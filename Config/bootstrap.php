<?php

CroogoNav::add('sidebar', 'webshop.children.configuration.children.payment_providers', array(
	'title' => __d('webshop', 'Payment providers'),
	'url' => array(
		'plugin' => 'webshop_payments',
		'controller' => 'payment_providers',
		'action' => 'index'
	),
));

CroogoNav::add('sidebar', 'webshop.children.configuration.children.payment_methods', array(
	'title' => __d('webshop', 'Payment methods'),
	'url' => array(
		'plugin' => 'webshop_payments',
		'controller' => 'payment_methods',
		'action' => 'index'
	),
));

App::build(array(
	'PaymentProvider' => array('%s' . 'PaymentProvider' . DS)
), App::REGISTER);

App::uses('CakeEventListener', 'Event');
class PaymentsListener implements CakeEventListener {

	public function implementedEvents() {
		return array(
			'Payment.statusUpdate' => 'updateBuyStatistic',
		);
	}

	public function __construct() {
		$this->Payment = ClassRegistry::init('WebshopPayments.Payment');
	}


	public function updateBuyStatistic($event) {
		debug($event->data);

		$this->Payment->id = $event->data['payment']['id'];
		$this->Payment->saveField('status', $event->data['status']);
	}
}

$statistics = new PaymentsListener();
CakeEventManager::instance()->attach($statistics);

