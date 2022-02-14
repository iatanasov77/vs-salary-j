import {  vsOpenPrintPreview } from '../includes/vs_print.js';

var moment  = require( 'moment' );
moment.locale( $( 'html' ).attr( 'lang' ) );

require( 'bootstrap-daterangepicker/daterangepicker.css' );
require( 'bootstrap-daterangepicker' );

var strStartDate    = $( "#operations_work_period" ).attr( 'data-workStartDate' ).split( '-' );
var strEndDate      = $( "#operations_work_period" ).attr( 'data-workEndDate' ).split( '-' );
var start           = moment( new Date( strStartDate[0], strStartDate[1] - 1, strStartDate[2] ) );
var end             = moment( new Date( strEndDate[0], strEndDate[1] - 1, strEndDate[2] ) );

// See Configurator: https://www.daterangepicker.com/#config
var dateRangePickerLabelsBg = {
    applyLabel: 'Приложи',
    cancelLabel: 'Затвори'
};

function cb( start, end )
{
    $( '#operations_work_period span' ).html( start.format( 'MMMM D, YYYY' ) + ' - ' + end.format( 'MMMM D, YYYY' ) );
}

function changePeriod( startDate, endDate, postUrl = null )
{
    var url = postUrl ? postUrl : $( '#operations_work_period' ).attr( 'data-url' );
    
    $.post( url, {
        startDate: startDate,
        endDate: endDate,
        dateRangeChanged: true
    }).done( function( data ) {
        $( '#grpName' ).text( data.groupName );
        $( '#OperationsContainer' ).html( data.workTable );
    });
}

$( function()
{
	$( '#operations_work_period.lang_en' ).daterangepicker({
        datepickerOptions : {
            numberOfMonths : 2
        },
        startDate: start,
        endDate: end
    }, cb );
    
    
    $( '#operations_work_period.lang_bg' ).daterangepicker({
        datepickerOptions : {
            numberOfMonths : 2
        },
        startDate: start,
        endDate: end,
        locale: dateRangePickerLabelsBg
    }, cb );
    
    cb( start, end );
    
    $( '#operations_work_period' ).on( 'apply.daterangepicker', function( ev, picker )
    {
        var startDate   = picker.startDate.format( 'YYYY-MM-DD' );
        var endDate     = picker.endDate.format( 'YYYY-MM-DD' );
        
        changePeriod( startDate, endDate );
    });
    
    $( '#OperationsContainer' ).delegate( '#btnPrint', 'click', function( ev )
    {
        var addr = $( this ).attr( 'data-url' );
        vsOpenPrintPreview( addr );
    });
});	
