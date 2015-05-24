<?php
$this->extend('/Common/admin_index');

$this->set('displayFields', array(
	'name' => array(
		'label' => __d('webshop_payments', 'Name'),
		'sort'  => true
	),
	'active' => array(
		'label' => __d('webshop_payments', 'Active'),
		'sort'  => false
	),
	'available' => array(
		'label' => __d('webshop_payments', 'Available'),
		'sort'  => false
	)
));

$this->start('table-body');

$previousProvider = null;
foreach ($payment_methods as $payment_method):
	if ($previousProvider != $payment_method['PaymentProvider']['id']):
		$previousProvider = $payment_method['PaymentProvider']['id'];
		?>
		<tr>
			<th><?php echo h($payment_method['PaymentProvider']['name']); ?></th>
		</tr>
	<?php endif; ?>
	<tr>
		<td><?php echo h($payment_method['PaymentMethod']['name']); ?></td>
		<td>
			<?php
			if ($payment_method['PaymentMethod']['available']):
				echo $this->element('admin/toggle', array(
					'id' => $payment_method['PaymentMethod']['id'],
					'status' => (int)$payment_method['PaymentMethod']['active'],
				));
			else:
				echo $this->Html->status($payment_method['PaymentMethod']['active']);
			endif;
			?>
		</td>
		<td><?php echo $this->Html->status($payment_method['PaymentMethod']['available']); ?></td>
	</tr>
<?php
endforeach;

$this->end();
