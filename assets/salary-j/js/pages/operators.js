$( function()
{
	$( '#operator_filter_form_filter_groups' ).on( 'change', function( e )
	{
		document.location	= '?group=' + $( this ).val();
	});
});
