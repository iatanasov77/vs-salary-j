import { checkAll } from '../includes/change_all_checkboxes.js';
import {  VsPath } from '@/js/includes/fos_js_routes.js';
import {  vsOpenPrintPreview } from '../includes/vs_print.js';

var moment	= require( 'moment' );
moment.locale( $( 'html' ).attr( 'lang' ) );

require( 'bootstrap-daterangepicker/daterangepicker.css' );
require( 'bootstrap-daterangepicker' );

var strStartDate    = $( "#operators_work_period" ).attr( 'data-workStartDate' ).split( '-' );
var strEndDate      = $( "#operators_work_period" ).attr( 'data-workEndDate' ).split( '-' );
var start           = moment( new Date( strStartDate[0], strStartDate[1] - 1, strStartDate[2] ) );
var end             = moment( new Date( strEndDate[0], strEndDate[1] - 1, strEndDate[2] ) );

// See Configurator: https://www.daterangepicker.com/#config
var dateRangePickerLabelsBg	= {
	applyLabel: 'Приложи',
	cancelLabel: 'Затвори'
};

function cb( start, end )
{
    $( '#operators_work_period span' ).html( start.format( 'MMMM D, YYYY' ) + ' - ' + end.format( 'MMMM D, YYYY' ) );
}

function changePeriod( startDate, endDate, postUrl = null )
{
    var url = postUrl ? postUrl : $( '#operators_work_period' ).attr( 'data-url' );
    
    $.post( url, {
        startDate: startDate,
        endDate: endDate,
        dateRangeChanged: true
    }).done( function( data ) {
        $( '#grpName' ).text( data.groupName );
        $( '#OperatorsContainer' ).html( data.workTable );
    });
}

$( function()
{
    $( '#checkAll' ).on( 'click', function( e )
    {
        checkAll( true, document.operators_work_browse_totals, 'op_ids' );
    });
    
    $( '#uncheckAll' ).on( 'click', function( e )
    {
        checkAll( false, document.operators_work_browse_totals, 'op_ids' );
    });
    
    // Because Twig Not Sett This
    $( "#operator_filter_form_filter_groups" ).val( $( "#operator_filter_form_filter_groups" ).attr( 'data-currentGroupId' ) );
    
	$( '#operators_work_period.lang_en' ).daterangepicker({
	    datepickerOptions : {
            numberOfMonths : 2
        },
        startDate: start,
        endDate: end,
        showDropdowns: true
	}, cb );
	
	
	$( '#operators_work_period.lang_bg' ).daterangepicker({
	    datepickerOptions : {
            numberOfMonths : 2
        },
        startDate: start,
        endDate: end,
        showDropdowns: true,
	    locale: dateRangePickerLabelsBg
	}, cb );
	
	cb( start, end );
	
	$( '#operators_work_period' ).on( 'apply.daterangepicker', function( ev, picker )
    {
        var startDate   = picker.startDate.format( 'YYYY-MM-DD' );
        var endDate     = picker.endDate.format( 'YYYY-MM-DD' );
        
        changePeriod( startDate, endDate );
    });
    
    $( '#operator_filter_form_filter_groups' ).on( 'change', function( ev )
    {
        var currentGroup    = $( this ).val();
        currentGroup        = ! currentGroup || ! currentGroup.length ? 0 : currentGroup;
        
        var startDate       = $( '#operators_work_period' ).data( 'daterangepicker' ).startDate.format( 'YYYY-MM-DD' );
        var endDate         =$( '#operators_work_period' ).data( 'daterangepicker' ).endDate.format( 'YYYY-MM-DD' );
        var url             = VsPath( 'app_operators_work_browse_totals', { groupId: currentGroup } );
        
        changePeriod( startDate, endDate, url );
    });
    
    $( '#OperatorsContainer' ).delegate( '#btnPrint', 'click', function( ev )
    {
        var addr = $( this ).attr( 'data-url' );
        vsOpenPrintPreview( addr );
    });
});
