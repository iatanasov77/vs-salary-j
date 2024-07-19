require( '@/js/includes/resource-delete.js' );

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// bin/junona-dimitrovgrad fos:js-routing:dump --format=json --target=public/shared_assets/js/fos_js_routes_application.json
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
var routes  = require( '../../../../../public/shared_assets/js/fos_js_routes_application.json' );
import { VsPath } from '@/js/includes/fos_js_routes.js';

import { VsGetSubmitButton, VsFormSubmit } from '@/js/includes/vs_form.js';
import { checkAll } from '../includes/change_all_checkboxes.js';
require ( '../includes/index_form.js' );

const minuteBonus = $( '#OperationsContainer' ).attr( 'data-minuteBonus' );
const minutePrice = $( '#OperationsContainer' ).attr( 'data-minutePrice' );

$( function()
{
	$( '.textMinutes' ).blur( function () {
		var newValue = parseFloat( $( this ).val() );
		var oldValue = parseFloat( $( this ).attr( 'data-currentValue' ) );
		if( newValue != oldValue ) {
			var operationId 	= $( this ).attr( 'data-operationId' );
			var oldTotal		= parseFloat( $( "#totalMinutes" ).text() );	
			
			var newTotal		= oldTotal + ( newValue - oldValue );
			
			var newBonus 		= new Number( newValue * ( 1 + ( minuteBonus / 100 ) ) );
			var newPrice 		= new Number( newValue * ( 1 + ( minuteBonus / 100 ) ) * minutePrice );
			
			var newBonusTotal 	= new Number( newTotal * ( 1 + ( minuteBonus / 100 ) ) );
			var newPriceTotal 	= new Number( newTotal * ( 1 + ( minuteBonus / 100 ) ) * minutePrice );
			
			$( "#bonus" + operationId ).text( newBonus.toFixed( 2 ) );
			$( "#price" + operationId ).text( newPrice.toFixed( 4 ) );
			
			$( "#totalMinutes" ).text( newTotal );
			$( "#totalBonus" ).text( newBonusTotal.toFixed( 2 ) );
			$( "#totalPrice" ).text( newPriceTotal.toFixed( 4 ) );
			
			$( this ).attr( 'data-currentValue', newValue );
		}
	});
	
	$( '#checkAll' ).on( 'click', function( e )
    {
        checkAll( true, document.operations_index_form, 'opids' );
    });
    
    $( '#uncheckAll' ).on( 'click', function( e )
    {
        checkAll( false, document.operations_index_form, 'opids' );
    });
	
	$( '#btnWorked' ).on( 'click', function( e )
    {
        document.location   = $( this ).attr( 'data-url' );
    });
    
	$( '#btnWorkedNew' ).on( 'click', function( e )
    {
        document.location   = $( this ).attr( 'data-url' );
    });
    
    $( '#operations_index_form' ).on( 'submit', function( e )
    {
        e.preventDefault();
        e.stopPropagation();
        
        var submitName  = VsGetSubmitButton();
        var formData    = new FormData( this );
        
        var modelId     = $( '#operations_index_form_model_id' ).val();
        var redirectUrl = VsPath( 'app_operations_index', {modelId: modelId}, routes );
        
        switch ( true ) {
            case ( submitName == 'operations_index_form[change_names]' ):
                VsFormSubmit( formData, VsPath( 'app_model_operations_ext_update', {modelId: modelId}, routes ), redirectUrl );
                break;
            case ( submitName == 'operations_index_form[del_operations]' ):
                /*
                var onDeleteOk  = function() {
                    VsFormSubmit( formData, VsPath( 'app_model_operations_ext_delete', {modelId: modelId}, routes ), redirectUrl );
                }
                var dialog  = VsFormDlete( onDeleteOk );
                */
                VsFormSubmit( formData, VsPath( 'app_model_operations_ext_delete', {modelId: modelId}, routes ), redirectUrl );
                break;
            default:
                return false;
        }
    });
});	
