<?php

App::uses('WebshopPaymentsAppModel', 'WebshopPayments.Model');

class PaymentProvider extends WebshopPaymentsAppModel {

	public $hasMany = array('WebshopPayments.PaymentMethod');

}
