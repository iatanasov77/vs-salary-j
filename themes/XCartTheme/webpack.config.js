const Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath( 'public/shared_assets/build/salaryj-xcart-theme/' )
    .setPublicPath( '/build/salaryj-xcart-theme/' )
  
    .disableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    
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
         from: './themes/XCartTheme/assets/images',
         to: 'images/[path][name].[ext]',
     })
     
    .addStyleEntry( 'css/login', './themes/XCartTheme/assets/css/login.css' )
    .addStyleEntry( 'css/app', './themes/XCartTheme/assets/css/main.scss' )
    .addEntry( 'js/app', './themes/XCartTheme/assets/js/app.js' )
    
    .addEntry( 'js/pages/operators', './themes/XCartTheme/assets/js/pages/operators.js' )
    .addEntry( 'js/pages/models', './themes/XCartTheme/assets/js/pages/models.js' )
    .addEntry( 'js/pages/operations', './themes/XCartTheme/assets/js/pages/operations.js' )
    .addEntry( 'js/pages/operators_work', './themes/XCartTheme/assets/js/pages/operators_work.js' )
    .addEntry( 'js/pages/operators_work_new', './themes/XCartTheme/assets/js/pages/operators_work_new.js' )
    .addEntry( 'js/pages/users', './themes/XCartTheme/assets/js/pages/users.js' )
    .addEntry( 'js/pages/users_edit', './themes/XCartTheme/assets/js/pages/users_edit.js' )
    .addEntry( 'js/pages/operators_work_browse_totals', './themes/XCartTheme/assets/js/pages/operators_work_browse_totals.js' )
    .addEntry( 'js/pages/operations_work', './themes/XCartTheme/assets/js/pages/operations_work.js' )
    .addEntry( 'js/pages/operators_groups', './themes/XCartTheme/assets/js/pages/operators_groups.js' )
;

const config = Encore.getWebpackConfig();
config.name = 'xcartTheme';

module.exports = config;
