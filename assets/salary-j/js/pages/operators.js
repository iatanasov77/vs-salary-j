
function checkAll( flag, form, prefix )
{
	if ( ! form )
		return;

	if ( prefix )
		var reg = new RegExp( "^"+prefix, "" );
	for ( var i = 0; i < form.elements.length; i++ ) {
		if ( form.elements[i].type == "checkbox" && ( ! prefix || form.elements[i].name.search( reg ) == 0 ) && !form.elements[i].disabled )
			form.elements[i].checked = flag;
	}
}

$( function()
{
	$( '#operator_filter_form_filter_groups' ).on( 'change', function( e )
	{
		document.location	= '?group=' + $( this ).val();
	});
	
	$( '#checkAll' ).on( 'click', function( e )
	{
		checkAll( true, document.operatorsform, 'op_ids' );
	});
	
	$( '#uncheckAll' ).on( 'click', function( e )
	{
		checkAll( false, document.operatorsform, 'op_ids' );
	});
	
	$( '.browseOperations' ).on( 'click', function( e )
	{
		document.location	= $( this ).attr( 'data-url' );
	});
	
	$( '.addOperations' ).on( 'click', function( e )
	{
		document.location	= $( this ).attr( 'data-url' );
	});
});
