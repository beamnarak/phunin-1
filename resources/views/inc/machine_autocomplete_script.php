<script type="text/javascript">
$(document).ready(function () {
	 $( "#machine_field" ).autocomplete({
	  source: "{{URL('repairments/autocomplete')}}",
	  minLength: 3,
	  select: function(event, ui) {
	  	$('#machine_field').val(ui.item.value);
	  }
	});
});
</script>