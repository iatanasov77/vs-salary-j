import { VsPath } from '../includes/fos_js_routes.js';
import { VsGetSubmitButton } from '../includes/vs_form.js';
import { VsFormDlete } from '../includes/resource-delete.js';

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

function submitForm( formData, submitUrl, redirectUrl )
{
    $.ajax({
        type: 'POST',
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
	
	$( '#btnWorkTotal' ).on( 'click', function( e )
    {
        var currentGroup    = $( '#operator_filter_form_filter_groups' ).val();
        currentGroup        = ! currentGroup || ! currentGroup.length ? 0 : currentGroup;
        
        document.location   = VsPath( 'app_operators_work_browse_totals', { groupId: currentGroup } );
    });
    
    $( '#operators_index_form' ).on( 'submit', function( e )
    {
        e.preventDefault();
        e.stopPropagation();
        
        var submitName  = VsGetSubmitButton();
        var formData    = new FormData( this );
        var redirectUrl = VsPath( 'salaryj_operators_index', {} );
        switch ( true ) {
          case ( submitName == 'operators_index_form[change_names]' ):
            submitForm ( formData, VsPath( 'app_operators_ext_update', {} ), redirectUrl );
            break;
          case ( submitName == 'operators_index_form[del_operators]' ):
            var onDeleteOk  = function() {
                submitForm ( formData, VsPath( 'app_operators_ext_delete', {} ), redirectUrl );
            }
            var dialog  = VsFormDlete( onDeleteOk );
            break;
        }
    });
});
