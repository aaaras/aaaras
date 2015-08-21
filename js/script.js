// autocomplet : this function will be executed every time we change the text
function autocomplet() {
	var min_length = 0; // min caracters to display the autocomplete
	var keyword = $('#scuola_id').val();
	if (keyword.length >= min_length) 
	{
		$.ajax({
			url: 'ajax_refresh.php',
			type: 'POST',
			data: {keyword:keyword},
			success:function(data)
			{
				$('#lista_scuole_id').show();
				$('#lista_scuole_id').html(data);
			}
		});
	} 
	else 
	{
		$('#lista_scuole_id').hide();
	}
}

// set_item : this function will be executed when we select an item
function set_item(item) 
{
	$stringa=item.split("-");	
	// change input value
	$('#scuola_id').val($stringa[0]);
	// hide proposition list
	$('#lista_scuole_id').hide();
	$('#selected_id').val($stringa[1]);
}