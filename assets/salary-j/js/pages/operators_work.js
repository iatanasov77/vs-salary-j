var moment	= require( 'moment' );

require( 'bootstrap-daterangepicker/daterangepicker.css' );
require( 'bootstrap-daterangepicker' );

var strStartDate = $( "#operators_work_period" ).attr( 'data-workStartDate' ).split( '-' );
var strEndDate = $( "#operators_work_period" ).attr( 'data-workEndDate' ).split( '-' );

moment.locale( $( 'html' ).attr( 'lang' ) );
//var start	= moment().subtract( 30, 'days' );
var start	= moment( new Date( strStartDate[0], strStartDate[1] - 1, strStartDate[2] ) );
var end 	= moment( new Date( strEndDate[0], strEndDate[1] - 1, strEndDate[2] ) );

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
