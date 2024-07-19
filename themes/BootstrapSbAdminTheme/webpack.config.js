const Encore    = require('@symfony/webpack-encore');
const path      = require('path');

Encore
    .setOutputPath( 'public/shared_assets/build/salaryj-sbadmin-theme/' )
    .setPublicPath( '/build/salaryj-sbadmin-theme/' )
  
    .disableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    
    .addAliases({
        '@': path.resolve( __dirname, '../../vendor/vankosoft/application/src/Vankosoft/ApplicationBundle/Resources/themes/default/assets' ),
    })
    
    .enableSassLoader(function(sassOptions) {}, {
        resolveUrlLoader: true
    })
    
    /**
     * Add Entries
     */
     .autoProvidejQuery()
     .configureFilenames({
        js: '[name].js?[contenthash]',
        css: '[name].css?[contenthash]',
        assets: '[name].[ext]?[hash:8]'
    })
    
    .copyFiles({
         from: './themes/BootstrapSbAdminTheme/assets/images',
         to: 'images/[path][name].[ext]',
     })
     
    .addStyleEntry( 'css/app', './themes/BootstrapSbAdminTheme/assets/css/main.scss' )
    .addEntry( 'js/app', './themes/BootstrapSbAdminTheme/assets/js/app.js' )
    .addEntry( 'js/main', './themes/BootstrapSbAdminTheme/assets/js/main.js' )
    
    .addEntry( 'js/pages/operators', './themes/BootstrapSbAdminTheme/assets/js/pages/operators.js' )
    .addEntry( 'js/pages/models', './themes/BootstrapSbAdminTheme/assets/js/pages/models.js' )
    .addEntry( 'js/pages/operations', './themes/BootstrapSbAdminTheme/assets/js/pages/operations.js' )
    .addEntry( 'js/pages/operators_work', './themes/BootstrapSbAdminTheme/assets/js/pages/operators_work.js' )
    .addEntry( 'js/pages/operators_work_new', './themes/BootstrapSbAdminTheme/assets/js/pages/operators_work_new.js' )
    .addEntry( 'js/pages/users', './themes/BootstrapSbAdminTheme/assets/js/pages/users.js' )
    .addEntry( 'js/pages/users_edit', './themes/BootstrapSbAdminTheme/assets/js/pages/users_edit.js' )
    .addEntry( 'js/pages/operators_work_browse_totals', './themes/BootstrapSbAdminTheme/assets/js/pages/operators_work_browse_totals.js' )
    .addEntry( 'js/pages/operations_work', './themes/BootstrapSbAdminTheme/assets/js/pages/operations_work.js' )
    .addEntry( 'js/pages/operators_groups', './themes/BootstrapSbAdminTheme/assets/js/pages/operators_groups.js' )
    .addEntry( 'js/pages/operators_work_add', './themes/BootstrapSbAdminTheme/assets/js/pages/operators_work_add.js' )
;

const config = Encore.getWebpackConfig();
config.name = 'SbAdminTheme';

module.exports = config;
