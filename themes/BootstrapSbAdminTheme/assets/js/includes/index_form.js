$( function()
{
    $( '.indexFormRowTextInput' ).on( 'input', function( e ) {
        let checkbox = $( this ).closest( "tr" ).find( '.indexFormRowCheckbox' );
        checkbox[0].checked = true;
    });
    
    $( '.indexFormRowSelectInput' ).on( 'change', function() {
        let checkbox = $( this ).closest( "tr" ).find( '.indexFormRowCheckbox' );
        checkbox[0].checked = true;
    });
});