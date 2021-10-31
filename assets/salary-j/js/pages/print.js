

$( function()
{

	$( '#btnPrintOperatorWork' ).on( 'click', function()
	{
		var opId = document.getElementById('operator_id').innerHTML;
		var from = document.getElementById('fromVsdeDate');
		var to = document.getElementById('toVsdeDate');

		var addr = "print.php?view="+view+"&op_id="+opId+"&fromVsdeDate="+from.value+"&toVsdeDate="+to.value;
		//alert(form.action);
		window.open(addr, 'VsPrint', 'width=800,height=500,toolbar=no,status=no,scrollbars=yes,resizable=yes,menubar=no,location=no,direction=no');
	});
	
	$( '#btnPrintOperatorWorkGrouped' ).on( 'click', function()
	{
		var opId = document.getElementById('operator_id').innerHTML;
		var from = document.getElementById('fromVsdeDate');
		var to = document.getElementById('toVsdeDate');

		var addr = "print.php?view="+view+"&op_id="+opId+"&group_by=operation&fromVsdeDate="+from.value+"&toVsdeDate="+to.value;
		//alert(form.action);
		window.open(addr, 'VsPrint', 'width=800,height=500,toolbar=no,status=no,scrollbars=yes,resizable=yes,menubar=no,location=no,direction=no');
	});
});
