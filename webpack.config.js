var Encore = require( '@symfony/webpack-encore' );

/**
 *  AdminPanel Default Theme
 */
const themePath         = './vendor/vankosoft/application/src/Vankosoft/ApplicationBundle/Resources/themes/default';
const adminPanelConfig  = require( themePath + '/webpack.config' );

//=================================================================================================

/**
 *  Bootstrap SbAdmin Theme
 */
Encore.reset();
const sbadminThemeConfig          = require('./themes/BootstrapSbAdminTheme/webpack.config');

//=================================================================================================

module.exports = [
    adminPanelConfig,
    sbadminThemeConfig
];
