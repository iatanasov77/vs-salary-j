import {  VsGetSubmitButton } from '../includes/vs_form.js';
import {  VsPath } from '../includes/fos_js_routes.js';
require( 'jquery-ui-dist/jquery-ui.css' );
require( 'jquery-ui-dist/jquery-ui.js' );

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
	
	$( '#models_index_form' ).on( 'submit', function( e )
    {
        e.preventDefault();
        e.stopPropagation();
        
        var submitName  = VsGetSubmitButton();
        var formData    = new FormData( this );
        var submitUrl   = null;
        var redirectUrl = VsPath( 'salaryj_models_index', {} );
        switch ( true ) {
          case ( submitName == 'change_names' ):
            submitUrl = VsPath( 'app_models_ext_update', {} );
            break;
          case ( submitName == 'del_models' ):
            submitUrl = VsPath( 'app_models_ext_delete', {} );
            break;
        }
        
        if ( submitUrl ) {
            $.ajax({
                type: $( this ).attr( 'method' ),
                url: submitUrl,
                data: formData,
                success: function ( data ) {
                    document.location = redirectUrl;
                }, 
                error: function( XMLHttpRequest, textStatus, errorThrown ) {
                    alert( 'FATAL ERROR!!!' );
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }
    });
});
