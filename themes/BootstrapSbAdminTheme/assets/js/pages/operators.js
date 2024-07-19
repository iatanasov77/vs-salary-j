require( '@/js/includes/resource-delete.js' );

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// bin/salary-j fos:js-routing:dump --format=json --target=public/shared_assets/js/fos_js_routes_application.json
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
var routes  = require( '../../../../../public/shared_assets/js/fos_js_routes_application.json' );
import { VsPath } from '@/js/includes/fos_js_routes.js';

import { VsGetSubmitButton, VsFormSubmit } from '@/js/includes/vs_form.js';
import { checkAll } from '../includes/change_all_checkboxes.js';
require ( '../includes/index_form.js' );

function getCurrentGroup()
{
    var currentGroup    = $( '#operator_filter_form_filter_groups' ).val();
    currentGroup        = ! currentGroup || ! currentGroup.length ? 0 : currentGroup;
    
    return currentGroup;
}

$( function()
{
	$( '#operator_filter_form_filter_groups' ).on( 'change', function( e )
	{
		var groupId = $( this ).val();
		if ( groupId ) {
			document.location	= VsPath( 'salaryj_operators_index', { groupId: groupId }, routes );
		}
	});
	
	$( '#checkAll' ).on( 'click', function( e )
	{
		checkAll( true, document.operators_index_form, 'submitedOperators' );
	});
	
	$( '#uncheckAll' ).on( 'click', function( e )
	{
		checkAll( false, document.operators_index_form, 'submitedOperators' );
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
        let currentGroup    = getCurrentGroup();
        document.location   = VsPath( 'app_operators_work_browse_totals', { groupId: currentGroup }, routes );
    });
    
    $( '#operators_index_form' ).on( 'submit', function( e )
    {
        e.preventDefault();
        e.stopPropagation();
        
        let currentGroup    = getCurrentGroup();
        
        var submitName      = VsGetSubmitButton();
        var formData        = new FormData( this );
        var redirectUrl     = VsPath( 'salaryj_operators_index', { groupId: currentGroup}, routes );
        
        switch ( true ) {
          case ( submitName == 'operators_index_form[change_names]' ):
            VsFormSubmit( formData, VsPath( 'app_operators_ext_update', {}, routes ), redirectUrl );
            break;
          case ( submitName == 'operators_index_form[del_operators]' ):
            /*
            var onDeleteOk  = function() {
                VsFormSubmit( formData, VsPath( 'app_operators_ext_delete', {}, routes ), redirectUrl );
            }
            var dialog  = VsFormDlete( onDeleteOk );
            */
            VsFormSubmit( formData, VsPath( 'app_operators_ext_delete', {}, routes ), redirectUrl );
            break;
        }
    });
});
