$( function()
{
	$( '#btnPrint' ).on( 'click', function()
	{
		var addr = $( this ).attr( 'data-url' );
		window.open(addr, 'VsPrint', 'width=800,height=500,toolbar=no,status=no,scrollbars=yes,resizable=yes,menubar=no,location=no,direction=no');
	});
});
