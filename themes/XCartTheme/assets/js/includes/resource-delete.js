// JqueryUi conflicts with JqueryEasyUi
require( 'jquery-ui-dist/jquery-ui.js' );
require( 'jquery-ui-dist/jquery-ui.css' );
require( 'jquery-ui-dist/jquery-ui.theme.css' );

import { VsTranslator } from '../includes/bazinga_js_translations.js';

export function VsFormDlete( onOk )
{
    var myButtons = {};
    var _Translator = VsTranslator();
    
    //var translatedDialog    = '<div title="DELETE ITEM">Do you want to delete this Item?</div>';
    var translatedDialog    = '<div title="' + _Translator.trans( 'salary-j.form.vs_form_delete.title' ) + '">' + 
                                _Translator.trans( 'salary-j.form.vs_form_delete.message' ) + 
                            '</div>';
    
    myButtons[_Translator.trans( 'salary-j.form.vs_form_delete.btn_ok' )] = function() { onOk(); };
    myButtons[_Translator.trans( 'salary-j.form.vs_form_delete.btn_cancel' )] = function() { $(this).dialog('close'); };
    
    return $( translatedDialog ).dialog( { buttons: myButtons } );
}
