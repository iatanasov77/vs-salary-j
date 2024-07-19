

export function formWorksSubmited()
{
	return 1;
}
//=========================================================================================

export function setGroupBy( groupBy )
{
	var hidGroupBy     = document.getElementById( 'group_by' );

	hidGroupBy.value   = groupBy;
}
//========================================================================================

export function setOperationsForModel( workId, modelId )
{
	var cbOperations               = document.getElementById( 'operations_' + workId );

	//alert(modelId);
	var lng                        = operations[modelId].length
	cbOperations.options.length    = lng;

	for( var i=0; i<lng; ++i ) {
		cbOperations.options[i].value = operations[modelId][i][0];
		cbOperations.options[i].text  = operations[modelId][i][1]+'.  '+operations[modelId][i][2];

		//currentPrices[i] = operations[modelId][i][3];
	}

}
//==========================================================================================

/*
export function modelChanged(workId, modelId) {
	setOperationsForModel(workId, modelId);

	operationChanged(workId, 0, 0);

	setChk(workId, 1);
}
//=========================================================================================

export function operationChanged(workId, index, count) {
	var cbModels = document.getElementById('models_'+workId);

	//cbModels.value

	var operation = operations[cbModels.value][index];
	var price = operation[3];
	var total = count*price;

	var inputPrice = document.getElementById('price_'+workId);
	var viewPrice = document.getElementById('price_view_'+workId);

	var tiCount = document.getElementById('count_'+workId);
	var viewTotal = document.getElementById('total_view_'+workId);

	inputPrice.value = price;
	viewPrice.innerHTML = price;

	tiCount.value = count;
	viewTotal.innerHTML = total;

	var dflOperation = document.getElementById('dfl_operation_'+workId).innerHTML;

	if(operation[0]!=dflOperation)
		setChk(workId, 1);
}
//==============================================================================
*/

export function countChanged( workId, newValue, oldValue )
{
    if( newValue != oldValue ) {
        var price               = document.getElementById( 'price_' + workId ).value;
        var viewTotal           = document.getElementById( 'total_view_' + workId );
        var grandTotal          = document.getElementById( 'GrandTotal' );
        
        var oldViewTotal        = parseFloat( viewTotal.innerHTML );
        var newViewTotal        = price * newValue;
        var oldTotal            = parseFloat( grandTotal.innerHTML );
        var newTotal            = oldTotal + ( newViewTotal - oldViewTotal );
        
    	viewTotal.innerHTML    = newViewTotal;
    	grandTotal.innerHTML   = newTotal;
    }
}
//=============================================================================

export function chkClicked( workId )
{
	//alert('EHO');
	var chk    = document.getElementById('chk_'+workId);

	//if(chk.checked == '') {
	if( ! chk.checked ) {
		//alert('EHO');
		setDflWork(workId);

	}
	else
		chk.checked   = ''; // Da ne Moje da se Chekva direktno

}
//=========================================================================

export function setDflWork( workId )
{
	//alert(workId);

	var dflModel       = document.getElementById( 'dfl_model_' + workId ).innerHTML;
	var cbModels       = document.getElementById( 'models_' + workId );

	var dflOperation   = document.getElementById( 'dfl_operation_' + workId ).innerHTML;
	var cbOperations   = document.getElementById( 'operations_' + workId );

	var dflCount       = document.getElementById( 'dfl_count_' + workId ).innerHTML;
	var tiCount        = document.getElementById( 'count_' + workId );

	//alert('dfl_model_'+workId+':  '+dflModel);
	//alert('dfl_operation_'+workId+':  '+dflOperation);
	//alert('dfl_count_'+workId+':  '+dflCount);

	tiCount.value      = dflCount;

	for( var i = 0; i < cbModels.length; ++i ) {
		if( cbModels[i].value == dflModel )
			cbModels[i].selected = 'selected';
	}

	setOperationsForModel( workId, dflModel );

	for(var i = 0; i < cbOperations.length; ++i ) {
		if( cbOperations[i].value == dflOperation ) {
			cbOperations[i].selected = 'selected';
			
			break;
		}
	}

	var dflPrice   = document.getElementById( 'dfl_price_' + workId ).innerHTML;
	var inputPrice = document.getElementById( 'price_' + workId );
	var viewPrice  = document.getElementById( 'price_view_' + workId );

	//alert('dfl_price_'+workId+':  '+dflPrice);

	var viewTotal  = document.getElementById( 'total_view_' + workId );

	inputPrice.value       = dflPrice;
	viewPrice.innerHTML    = dflPrice;

	viewTotal.innerHTML    = dflPrice * dflCount;

}
//===========================================================================
