export function VsGetSubmitButton()
{
    var clickedName = $( 'input[type=submit][clicked=true]' ).attr( 'name' );
    if ( clickedName == undefined ) {
        clickedName = $( 'button[type=submit][clicked=true]' ).attr( 'name' );
    }
    
    return clickedName;
}

$( function()
{
    $( 'form input[type=submit]' ).on( 'click', function()
    {
        $( 'input[type=submit]', $( this ).parents( 'form' ) ).removeAttr( 'clicked' );
        $( this ).attr( 'clicked', 'true' );
    });
    
    $( 'form button[type=submit]' ).on( 'click', function()
    {
        $( 'input[type=submit]', $( this ).parents( 'form' ) ).removeAttr( 'clicked' );
        $( this ).attr( 'clicked', 'true' );
    });
});
