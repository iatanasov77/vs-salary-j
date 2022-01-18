// JqueryUi conflicts with JqueryEasyUi

require( 'jquery-ui-dist/jquery-ui.js' );
require( 'jquery-ui-dist/jquery-ui.css' );
require( 'jquery-ui-dist/jquery-ui.theme.css' );

export function VsFormDlete( onOk )
{
    return $( '<div title="DELETE ITEM">Do you want to delete this Item?</div>' ).dialog({
        buttons: {
            "Ok": function () {
                onOk();
            },
            "Cancel": function () {
                $( this ).dialog( "close" );
            }
        }
    });
}
