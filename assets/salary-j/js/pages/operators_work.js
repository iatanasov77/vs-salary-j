var moment	= require( 'moment' );

require( 'bootstrap-daterangepicker/daterangepicker.css' );
require( 'bootstrap-daterangepicker' );

moment.locale( $( 'html' ).attr( 'lang' ) );
var start	= moment().subtract( 30, 'days' );
var end 	= moment();

// See Configurator: https://www.daterangepicker.com/#config
var dateRangePickerLabelsBg	= {
	applyLabel: 'Приложи',
	cancelLabel: 'Затвори'
};

function cb( start, end )
{
    $( '#operators_work_period span' ).html( start.format( 'MMMM D, YYYY' ) + ' - ' + end.format( 'MMMM D, YYYY' ) );
}

function changePeriod( startDate, endDate )
{
	$.post( $( '#operators_work_period' ).attr( 'data-url' ), {
		startDate: startDate,
		endDate: endDate,
		dateRangeChanged: true
	}).done( function( data ) {
		$( '#OperationsContainer' ).html( data );
	});
}
    
$( function()
{
	$( "#operators_work_period.lang_en" ).daterangepicker({
		datepickerOptions : {
		    numberOfMonths : 2
		},
		startDate: start,
        endDate: end
	}, cb);
	
	$( "#operators_work_period.lang_bg" ).daterangepicker({
		datepickerOptions : {
		    numberOfMonths : 2
		},
		startDate: start,
        endDate: end,
        locale: dateRangePickerLabelsBg
	}, cb);
	cb( start, end );
	
	$( '#operators_work_period' ).on( 'apply.daterangepicker', function( ev, picker )
	{
		var startDate	= picker.startDate.format( 'YYYY-MM-DD' );
  		var endDate		= picker.endDate.format( 'YYYY-MM-DD' );
  		
  		$( '#fromVsdeDate' ).val( startDate );
  		$( '#toVsdeDate' ).val( endDate );
  		
  		changePeriod( startDate, endDate );
	});
});
