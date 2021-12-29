require( 'jquery-easyui/css/easyui.css' );
require( 'jquery-easyui/js/jquery.easyui.min.js' );

$( function()
{
	// BECAUSE: An invalid form control with name='' is not focusable.
	$( 'form[name="user_form"]' ).attr( 'novalidate', true );
	
	if ( parseInt( $( '#user-id' ).text(), 10 ) > 0 ) {
		$( '#user_form_password_first' ).removeAttr( "required" );
		$( '#user_form_password_second' ).removeAttr( "required" );
	}
	
	/**
     * Submit Checked Roles Tree
     */
	$( 'form[name="user_form"]' ).on( 'submit', function ( e )
	{
        let treeModule  = require( '../includes/tree.js' );
        var element = treeModule.createCheckedTreeElement(
            "selectedRoles",
            $( '#user_form_roles_options' ).combotree( 'tree' ).tree( 'getChecked' )
        );
        $( this ).append( element );
	});
	
	$( '#user_form_applications' ).combobox({
        required: false,
        multiple: true,
        
        formatter: function( row ) {
            var opts    = $( this ).combobox( 'options' );
            return '<input type="checkbox" class="combobox-checkbox">' + row[opts.textField];
        },
        onLoadSuccess: function() {
            var opts    = $( this ).combobox( 'options' );
            var target  = this;
            var values  = $( target ).combobox( 'getValues' );
            $.map( values, function( value ) {
                var el  = opts.finder.getEl( target, value );
                el.find( 'input.combobox-checkbox' )._propAttr( 'checked', true );
            })
        },
        onSelect: function( row ) {
            console.log( row )
            var opts    = $( this ).combobox( 'options' );
            var el      = opts.finder.getEl( this, row[opts.valueField] );
            el.find( 'input.combobox-checkbox' )._propAttr( 'checked', true );
        },
        onUnselect: function( row ) {
            var opts    = $( this ).combobox( 'options' );
            var el      = opts.finder.getEl( this, row[opts.valueField] );
            el.find( 'input.combobox-checkbox' )._propAttr( 'checked', false );
        }
    });
});
 