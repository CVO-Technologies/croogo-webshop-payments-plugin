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

Croogo::hookHelper('*', 'WebshopPayments.Payment');

App::build(array(
	'PaymentProvider' => array('%s' . 'PaymentProvider' . DS)
), App::REGISTER);
