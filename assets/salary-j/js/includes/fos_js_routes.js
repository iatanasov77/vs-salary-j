// Manual: https://github.com/FriendsOfSymfony/FOSJsRoutingBundle/blob/master/Resources/doc/usage.rst
// bin/salary-j fos:js-routing:dump --format=json --target=public/salary-j/js/fos_js_routes.json
///////////////////////////////////////////////////////////////////////////////////////////////////////////
const routes = require( '../../../../public/salary-j/js/fos_js_routes.json' );
import Routing from '../../../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';
Routing.setRoutingData( routes );
    
export function VsPath( route, params )
{
    return Routing.generate( route, params )
}
