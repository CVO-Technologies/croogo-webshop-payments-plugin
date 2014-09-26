<?php
$this->extend('/Common/admin_index');

$this->set('displayFields', array(
	'name' => array(
		'label' => __d('webshop_payments', 'Name'),
		'sort'  => true
	)
));

$this->start('table-body');

foreach ($payment_providers as $payment_provider):
?>
<tr>
	<td><?php echo h($payment_provider['PaymentProvider']['name']); ?></td>
	<td></td>
</tr>
<?php
endforeach;

$this->end();
