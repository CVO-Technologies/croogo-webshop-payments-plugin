<?php

App::uses('WebshopPaymentsAppModel', 'WebshopPayments.Model');

class Payment extends WebshopPaymentsAppModel {

	public $actsAs = array(
		'Webshop.Status'
	);

	public $belongsTo = array(
		'WebshopPayments.PaymentMethod'
	);

	public function afterFind($results, $primary = false) {
		if ($primary) {
			foreach ($results as &$result) {
				if (isset($result[$this->alias]['redirect_route'])) {
					$result[$this->alias]['redirect_route'] = unserialize($result[$this->alias]['redirect_route']);
				} else {
					$result[$this->alias]['redirect_route'] = false;
				}
			}
		} else {
			if (isset($results['redirect_route'])) {
				$results['redirect_route'] = unserialize($results['redirect_route']);
			} else {
				$results['redirect_route'] = false;
			}
		}

		return $results;
	}

	public function beforeSave($options = array()) {
		if (isset($this->data[$this->alias]['redirect_route'])) {
			$this->data[$this->alias]['redirect_route'] = serialize($this->data[$this->alias]['redirect_route']);
		}

		return true;
	}

}
