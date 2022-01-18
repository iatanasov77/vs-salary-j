
function checkAll( flag, form, prefix )
{
    if ( ! form )
        return;

    if ( prefix )
        var reg = new RegExp( "^"+prefix, "" );
    for ( var i = 0; i < form.elements.length; i++ ) {
        if ( form.elements[i].type == "checkbox" && ( ! prefix || form.elements[i].name.search( reg ) == 0 ) && ! form.elements[i].disabled )
            form.elements[i].checked = flag;
    }
}

$( function()
{
    $( '#checkAll' ).on( 'click', function( e )
    {
        checkAll( true, document.operatorsform, 'op_ids' );
    });
    
    $( '#uncheckAll' ).on( 'click', function( e )
    {
        checkAll( false, document.operatorsform, 'op_ids' );
    });
});
