require( 'jquery-easyui/css/easyui.css' );
require( 'jquery-easyui/js/jquery.easyui.min.js' );
// Need copy of: jquery-easyui/images/*

$( function()
{
    if ( parseInt( $( '#user-id' ).text(), 10 ) > 0 ) {
        $( '#user_form_plain_password_first' ).removeAttr( "required" );
        $( '#user_form_plain_password_second' ).removeAttr( "required" );
    }
    
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
