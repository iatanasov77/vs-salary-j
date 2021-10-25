
/**
 * JQuery UI is needed by Autocomplete
 */
require( 'jquery-ui-dist/jquery-ui.js' );
require( 'jquery-ui-dist/jquery-ui.css' );
//require( 'jquery-ui-dist/jquery-ui.theme.css' );

function checkAll( flag, form, prefix )
{
	if ( ! form )
		return;

	if ( prefix )
		var reg = new RegExp( "^"+prefix, "" );
	for ( var i = 0; i < form.elements.length; i++ ) {
		if ( form.elements[i].type == "checkbox" && ( ! prefix || form.elements[i].name.search( reg ) == 0 ) && ! form.elements[i].disabled )
			form.elements[i].checked = flag;
	}
}

$( function()
{
	$.getJSON( $( '#filterModel' ).attr( 'data-url-json-models' ), function( json ) {
		$( "#filterModel" ).autocomplete({
			source: json.data,
			select: function( event, data ) {
				document.location = $( '#filterModel' ).attr( 'data-url-operations' ) + '?modid=' + data.item.value;
		        //alert("User selected: " + data.item.label);
		    }
		});
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
		// document.location='{$smarty.server.PHP_SELF}?modid={$mod->id()}'
		document.location	= $( this ).attr( 'data-url' );
	});
	
	$( '.workedOperations' ).on( 'click', function( e )
	{
		// document.location='{$smarty.server.PHP_SELF}?modid={$mod->id()}&mode=work_count'
		document.location	= $( this ).attr( 'data-url' );
	});
	
	$( '.workedOperationsNew' ).on( 'click', function( e )
	{
		// document.location='model_work.php?modid={$mod->id()}'
		document.location	= $( this ).attr( 'data-url' );
	});
});
