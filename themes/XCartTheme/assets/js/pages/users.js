import { checkAll } from '../includes/change_all_checkboxes.js';

$( function()
{
    $( '#checkAll' ).on( 'click', function( e )
    {
        checkAll( true, document.processuserform, 'user' );
    });
    
    $( '#uncheckAll' ).on( 'click', function( e )
    {
        checkAll( false, document.processuserform, 'user' );
    });
});
