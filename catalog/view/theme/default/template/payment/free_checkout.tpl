<div class="buttons">
  <div class="right">
	  <button id="button-confirm" class="btn btn-success pull-right">
		  <?php echo $button_confirm; ?> <i class="fa fa-check"></i>
	  </button>
  </div>
</div>
<script type="text/javascript"><!--
$('#button-confirm').bind('click', function() {
	$.ajax({ 
		type: 'get',
		url: 'index.php?route=payment/free_checkout/confirm',
		success: function() {
			location = '<?php echo $continue; ?>';
		}		
	});
});
//--></script> 
