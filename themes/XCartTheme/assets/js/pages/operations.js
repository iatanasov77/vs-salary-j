
/*
var minuteBonus = {$settings.minuteBonus};
var minutePrice =  {$settings.minutePrice};
*/

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
});	
