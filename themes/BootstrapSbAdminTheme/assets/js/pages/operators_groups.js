import { checkAll } from '../includes/change_all_checkboxes.js';

import { VsPath } from '@/js/includes/fos_js_routes.js';
//import { VsGetSubmitButton } from '@/js/includes/vs_form.js';
import { VsFormDlete } from '@/js/includes/resource-delete.js';

require( 'jquery-ui-dist/jquery-ui.css' );
require( 'jquery-ui-dist/jquery-ui.js' );

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
    $( '#checkAll' ).on( 'click', function( e )
    {
        checkAll( true, document.operators_groups_index_form, 'grids' );
    });
    
    $( '#uncheckAll' ).on( 'click', function( e )
    {
        checkAll( false, document.operators_groups_index_form, 'grids' );
    });
    
    $( '#operators_groups_index_form' ).on( 'submit', function( e )
    {
        e.preventDefault();
        e.stopPropagation();
        
        var submitName  = VsGetSubmitButton();
        var formData    = new FormData( this );
        var redirectUrl = VsPath( 'salaryj_operatorsgroups_index', {} );
        switch ( true ) {
          case ( submitName == 'operators_groups_index_form[change_names]' ):
            submitForm ( formData, VsPath( 'app_groups_ext_update', {} ), redirectUrl );
            break;
          case ( submitName == 'operators_groups_index_form[del_groups]' ):
            var onDeleteOk  = function() {
                submitForm ( formData, VsPath( 'app_groups_ext_delete', {} ), redirectUrl );
            }
            var dialog  = VsFormDlete( onDeleteOk );
            break;
        }
    });
});
