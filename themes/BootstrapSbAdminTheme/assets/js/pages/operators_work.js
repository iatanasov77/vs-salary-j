import {  vsOpenPrintPreview } from '../includes/vs_print.js';

var moment  = require( 'moment' );
moment.locale( $( 'html' ).attr( 'lang' ) );

require( 'bootstrap-daterangepicker/daterangepicker.css' );
require( 'bootstrap-daterangepicker' );

var strStartDate = $( "#operators_work_period" ).attr( 'data-workStartDate' ).split( '-' );
var strEndDate = $( "#operators_work_period" ).attr( 'data-workEndDate' ).split( '-' );
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

function initWorksTable()
{
    $( '#checkAll' ).on( 'click', function( e )
    {
        checkAll( true, document.formOperatorWorks, 'work_ids' );
    });
    
    $( '#uncheckAll' ).on( 'click', function( e )
    {
        checkAll( false, document.formOperatorWorks, 'work_ids' );
    });
    
    $( '.operatorWorkCount' ).blur( function() {
        let workId      = $( this ).attr( 'data-workId' );
        let oldCount    = $( this ).attr( 'data-currentValue' );
        let newCount    = $( this ).val();
        
        Work.countChanged( workId, newCount, oldCount );
    });
    
    $( '#btnPrint' ).on( 'click', function( ev )
    {
        var addr = $( this ).attr( 'data-url' );
        vsOpenPrintPreview( addr );
    });
}

$( function()
{
	initWorksTable();
	
	$( "#operators_work_period.lang_en" ).daterangepicker({
		datepickerOptions : {
		    numberOfMonths : 2
		},
		startDate: start,
        endDate: end,
        showDropdowns: true
	}, cb);
	
	$( "#operators_work_period.lang_bg" ).daterangepicker({
		datepickerOptions : {
		    numberOfMonths : 2
		},
		startDate: start,
        endDate: end,
        showDropdowns: true,
        locale: dateRangePickerLabelsBg
	}, cb);
	
	cb( start, end );
	
	$( '#operations_work_period' ).on( 'apply.daterangepicker', function( ev, picker )
    {
        var startDate   = picker.startDate.format( 'YYYY-MM-DD' );
        var endDate     = picker.endDate.format( 'YYYY-MM-DD' );
        
        changePeriod( startDate, endDate );
    });
});
