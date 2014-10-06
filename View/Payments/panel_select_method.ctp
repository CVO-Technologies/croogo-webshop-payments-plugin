<?php echo $this->Form->create('Payment'); ?>
<?php echo $this->Form->input('payment_method_id', array('options' => $payment_methods)); ?>
<?php echo $this->Form->submit(__d('webshop_payments', 'Go!')); ?>
<?php echo $this->Form->end(); ?>