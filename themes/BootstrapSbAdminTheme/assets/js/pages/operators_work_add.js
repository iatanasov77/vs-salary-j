require( 'jquery-ui-dist/jquery-ui.css' );
require( 'jquery-ui-dist/jquery-ui.js' );
require( '@/js/includes/resource-delete.js' );

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// bin/junona-dimitrovgrad fos:js-routing:dump --format=json --target=public/shared_assets/js/fos_js_routes_application.json
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
var routes  = require( '../../../../../public/shared_assets/js/fos_js_routes_application.json' );
import { VsPath } from '@/js/includes/fos_js_routes.js';

import { VsGetSubmitButton, VsFormSubmit } from '@/js/includes/vs_form.js';
import { checkAll } from '../includes/change_all_checkboxes.js';

$( function()
{
    $.getJSON( $( '#filterModel' ).attr( 'data-url-json-models' ), function( json ) {
        $( "#filterModel" ).autocomplete({
            source: json.data,
            select: function( event, data ) {
                document.location = VsPath( 'app_operations_index', {modelId: data.item.value}, routes );
            }
        });
    });
    
    $( '#checkAll' ).on( 'click', function( e )
    {
        checkAll( true, document.models_index_form, 'modids' );
    });
    
    $( '#uncheckAll' ).on( 'click', function( e )
    {
        checkAll( false, document.models_index_form, 'modids' );
    });
    
    $( '.browseOperations' ).on( 'click', function( e )
    {
        // document.location='{$smarty.server.PHP_SELF}?modid={$mod->id()}'
        document.location   = $( this ).attr( 'data-url' );
    });
    
    $( '.workedOperations' ).on( 'click', function( e )
    {
        // document.location='{$smarty.server.PHP_SELF}?modid={$mod->id()}&mode=work_count'
        document.location   = $( this ).attr( 'data-url' );
    });
    
    $( '.workedOperationsNew' ).on( 'click', function( e )
    {
        // document.location='model_work.php?modid={$mod->id()}'
        document.location   = $( this ).attr( 'data-url' );
    });
    
    $( '#models_index_form' ).on( 'submit', function( e )
    {
        e.preventDefault();
        e.stopPropagation();
        
        var submitName  = VsGetSubmitButton();
        var formData    = new FormData( this );
        var redirectUrl = VsPath( 'app_models_index', {}, routes );
        switch ( true ) {
          case ( submitName == 'models_index_form[change_names]' ):
            VsFormSubmit( formData, VsPath( 'app_models_ext_update', {}, routes ), redirectUrl );
            break;
          case ( submitName == 'models_index_form[del_models]' ):
            /*
            var onDeleteOk  = function() {
                VsFormSubmit( formData, VsPath( 'app_models_ext_delete', {}, routes ), redirectUrl );
            }
            var dialog  = VsFormDlete( onDeleteOk );
            */
            break;
        }
    });
});
