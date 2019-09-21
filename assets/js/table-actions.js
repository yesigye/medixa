$(function() {

	// Copy a table row and its data.
	$('table').on('click', '.copy-row', function() {
		// To set a new unique field name for the 'to-be-cloned' row, we need to obtain the current highest index id from the existing field names.
		var input_name = $(this).closest('tr').find('input, select, textarea').not('input:radio').first().attr('name');
		input_name = input_name.substring(input_name.indexOf(']')+1);
		
		// Loop through all field names and check if the index id is higher than the currently set highest.
		var highest_id = 0;
		$('input[name$="'+input_name+'"], select[name$="'+input_name+'"], textarea[name$="'+input_name+'"]').each(function()
		{
			var row_name = $(this).attr('name');
			if (parseInt(row_name.substring(row_name.indexOf('[')+1, row_name.indexOf(']'))) > highest_id)
			{
				highest_id = parseInt(row_name.substring(row_name.indexOf('[')+1, row_name.indexOf(']')));
			}			
		});

		// Get row to be cloned and increment the index id.
		var cloned_row = $(this).closest('tr');
		var new_id = highest_id+1;
		
		// Clone target row.
		var new_row = cloned_row.clone().insertAfter(cloned_row);

		// Set names for new elements by incrementing the current elements index (Example: name="insert[0][xxx]" updates to name="insert[1][xxx]").
		// Note: This example requires the first square bracket value must be the index value. Change the code below if your naming convention differs.
		new_row.find('input, select, textarea').not('input:radio').each(function()
		{
			if (typeof($(this).attr('name')) != 'undefined')
			{
				var cloned_name = $(this).attr('name');
				var new_name = cloned_name.substring(0, cloned_name.indexOf('[')+1) + new_id + cloned_name.substring(cloned_name.indexOf(']'));			
				$(this).attr('name', new_name);
			}
		});
		
		// Copy text from select boxes and textareas that are not otherwise copied.
		cloned_row.find('select, textarea').each(function(i)
		{
			var value = $(this).val();
			new_row.find('select, textarea').eq(i).val(value);
		});
		
		// Check if any dependent select menus are on the page.
		// Note: The user customised 'initialise_dependent_menu()' function must have been called on page load to initialise the new dependent menus. 
		if (typeof(initialise_dependent_menu) == 'function')
		{
			new_row.find('.dependent_menu').each(function(i)
			{
				// Copy the default dependent menu options to the new copied select menus.
				// !IMPORTANT NOTE: This example uses jQuery's $.data function to obtain the html of the dependent menu options that haven't yet been
				// manipulated by the 'dependent_menu()' function.
				var master_options = $('body').data('dependent_menu_'+i);
				var cloned_menu_value = $(this).val();
				$(this).html(master_options).val(cloned_menu_value);
			
				// Set id for new dependent menu by incrementing the current elements index (Example: id="xxx_country_1" updates to id="xxx_country_2").
				// Note: This example requires the index value of the element must be set after the last underscore. Change the code below if your naming convention differs.
				var cloned_menu_id = $(this).attr('id');
				var new_menu_id = cloned_menu_id.substring(0, cloned_menu_id.lastIndexOf('_')+1) + new_id;
				$(this).attr('id', new_menu_id);			
			});
			
			// Initialise the new dependent menus.
			new_menu_id = new_row.find('.dependent_menu:first').attr('id');
			initialise_dependent_menu(new_menu_id);
		}
		
		// Enable remove button.
		new_row.find('.remove_row').attr('disabled', false);
	});
	// Remove a table row and its data.
	$('table').on('click', '.remove-row', function(){
		// To set a new unique field name for the 'to-be-cloned' row, we need to obtain the current highest index id from the existing field names.
		var input_name = $(this).closest('tr').find('input, select, textarea').not('input:radio').first().attr('name');
		input_name = input_name.substring(input_name.indexOf(']')+1);
		
		// Loop through all field names and check if the index id is higher than the currently set highest.
		var highest_id = 0;
		$('input[name$="'+input_name+'"], select[name$="'+input_name+'"], textarea[name$="'+input_name+'"]').each(function()
		{
			var row_name = $(this).attr('name');
			if (parseInt(row_name.substring(row_name.indexOf('[')+1, row_name.indexOf(']'))) > highest_id)
			{
				highest_id = parseInt(row_name.substring(row_name.indexOf('[')+1, row_name.indexOf(']')));
			}			
		});
		if (highest_id > 0) {
			$(this).closest('tr').remove();
		}
	});
});