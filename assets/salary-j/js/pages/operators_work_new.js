var moment	= require( 'moment' );

require( 'bootstrap-daterangepicker/daterangepicker.css' );
require( 'bootstrap-daterangepicker' );

moment.locale( $( 'html' ).attr( 'lang' ) );
var currentYear	= parseInt( moment().format( 'YYYY' ), 10 );
var start = end = moment();

// See Configurator: https://www.daterangepicker.com/#config
var dateRangePickerLabelsBg	= {
	applyLabel: 'Приложи',
	cancelLabel: 'Затвори'
};

function cb( start, end )
{
    $( '#work_date span' ).html( start.format( 'MMMM D, YYYY' ) );
}

$( function()
{
	$( '#work_date.lang_en' ).daterangepicker({
	    singleDatePicker: true,
	    minYear: currentYear - 10,
	    maxYear: currentYear
	}, cb );
	
	$( '#work_date.lang_bg' ).daterangepicker({
	    singleDatePicker: true,
	    minYear: currentYear - 10,
	    maxYear: currentYear,
	    locale: dateRangePickerLabelsBg
	}, cb );
	cb( start, end );
	
	$( '#work_date' ).on( 'apply.daterangepicker', function( ev, picker )
	{
		var date			= picker.startDate.format( 'YYYY-MM-DD' );
  		document.location	= $( '#work_date' ).attr( 'data-page-url' ) + '?date=' + date;
	});

	$( '#btnAddOperator' ).click( function()
	{
		var operatorId	= $( "#selOperator" ).val();
		if( ! operatorId )
			return;
		
		var row			= $( "#rowOp" + operatorId );
		//$( '#tblWorkCount > tbody:last' ).append( '<tr id="rowOp' + operatorId + '">' + row.html() + '</tr>' );
		row.clone().insertAfter( '#tblWorkCount > tbody:last' );
		row.remove();
		
		$( "#rowOp" + operatorId ).show();
		$( "#selOp" + operatorId ).remove();
	});
	
	$( '#formWorkCount' ).on( 'submit', function()
	{
		/*
		 * Remove Hidden/NotAdded Operator-Rows
		 */
		$('#tblWorkCount > tbody > tr').each( function()
		{
		    if( $( this ).is( ":hidden" ) ) {
		        //alert("EHO");
		        $( this ).remove();
		    }
		});
		
		return true;
	});

	$( '#tblWorkCount' ).on( 'blur', '.textWorkCount', function ()
	{
		var newValue	= parseInt( $( this ).val() ) || 0;
		var oldValue 	= parseInt( $( this ).attr( 'data-currentValue' ) ) || 0;
		if( newValue != oldValue ) {
			var operationId = $( this ).attr( 'data-operationId' );
			
			var oldTotal 	= parseInt( $( "#total" + operationId ).text() ) || 0;
			$( "#total" + operationId ).text( oldTotal + ( newValue - oldValue ) );
			
			$( this ).attr( 'data-currentValue', newValue );
			$( this ).val( newValue );
		}
	});
});
