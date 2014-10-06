<?php echo $this->Form->create('Payment'); ?>
<strong>Description:</strong> <?php echo h($payment['Payment']['description']); ?><br>
<strong>Amount:</strong> <?php echo $this->Number->currency($payment['Payment']['amount']); ?><br>
<?php echo $this->Form->submit(__d('webshop_payments', 'Pay!')); ?>
<?php echo $this->Form->end(); ?>