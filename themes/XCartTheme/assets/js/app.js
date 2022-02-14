const $ = require( 'jquery' );
global.$ = $;
window.$ = $;

require( 'bootstrap' ); // bootstrap should be before jquery-ui
require( '@fortawesome/fontawesome-free/css/all.css' );
require( '@fortawesome/fontawesome-free/js/all.js' );

//require( 'debug');

/* SalaryJ Layout */
require( './salary-j.js' );
