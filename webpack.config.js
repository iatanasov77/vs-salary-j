var Encore = require( '@symfony/webpack-encore' );

/**
 *  AdminPanel Default Theme
 */
Encore
    .setOutputPath( 'public/admin-panel/build/default/' )
    .setPublicPath( '/build/default/' )

	// FOS CkEditor
	.copyFiles([
		{from: './node_modules/bootstrap-sass/assets/fonts/bootstrap', to: 'fonts/bootstrap/[name].[ext]'},
		
        {from: './node_modules/ckeditor/', to: 'ckeditor/[path][name].[ext]', pattern: /\.(js|css)$/, includeSubdirectories: false},
        {from: './node_modules/ckeditor/adapters', to: 'ckeditor/adapters/[path][name].[ext]'},
        {from: './node_modules/ckeditor/lang', to: 'ckeditor/lang/[path][name].[ext]'},
        {from: './node_modules/ckeditor/plugins', to: 'ckeditor/plugins/[path][name].[ext]'},
        {from: './node_modules/ckeditor/skins', to: 'ckeditor/skins/[path][name].[ext]'}
    ])
    
    .copyFiles({
         from: './assets/admin-panel/images',
         to: 'images/[path][name].[ext]',
     })
    
    .autoProvidejQuery()
    .enableSassLoader(function(sassOptions) {}, {
        resolveUrlLoader: true
    })
    .configureFilenames({
        js: '[name].js?[contenthash]',
        css: '[name].css?[contenthash]',
        assets: '[name].[ext]?[hash:8]'
    })
    .enableSingleRuntimeChunk()
    .enableVersioning(Encore.isProduction())
    .enableSourceMaps( !Encore.isProduction() )
    
    //////////////////////////////////////////////////////////////////
    // ASSETS
    //////////////////////////////////////////////////////////////////
    .addEntry( 'js/app', './assets/admin-panel/js/app.js' )
    .addStyleEntry( 'css/global', './assets/admin-panel/css/main.scss' )
    
    .addEntry( 'js/settings', './assets/admin-panel/js/pages/settings.js' )
    .addEntry( 'js/applications', './assets/admin-panel/js/pages/applications.js' )
    .addEntry( 'js/profile', './assets/admin-panel/js/pages/profile.js' )
    .addEntry( 'js/taxonomy-vocabolaries', './assets/admin-panel/js/pages/taxonomy-vocabolaries.js' )
    .addEntry( 'js/taxonomy-vocabolaries-edit', './assets/admin-panel/js/pages/taxonomy-vocabolaries-edit.js' )
    
    .addEntry( 'js/pages-categories', './assets/admin-panel/js/pages/pages_categories.js' )
    .addEntry( 'js/pages-categories-edit', './assets/admin-panel/js/pages/pages_categories_edit.js' )
    .addEntry( 'js/pages-index', './assets/admin-panel/js/pages/pages-index.js' )
    .addEntry( 'js/pages-edit', './assets/admin-panel/js/pages/pages-edit.js' )
    .addEntry( 'js/multipage-toc-index', './assets/admin-panel/js/pages/multipage-toc-index.js' )
    
    .addEntry( 'js/users-index', './assets/admin-panel/js/pages/users-index.js' )
    .addEntry( 'js/users-edit', './assets/admin-panel/js/pages/users-edit.js' )
    .addEntry( 'js/users-roles-index', './assets/admin-panel/js/pages/users-roles-index.js' )
    .addEntry( 'js/users-roles-edit', './assets/admin-panel/js/pages/users-roles-edit.js' )
    
    .addEntry( 'js/filemanager-index', './assets/admin-panel/js/pages/filemanager-index.js' )
    .addEntry( 'js/filemanager-file-upload', './assets/admin-panel/js/pages/filemanager-file-upload.js' )
;

const adminPanelConfig = Encore.getWebpackConfig();
adminPanelConfig.name = 'adminPanel';

//=================================================================================================

/**
 *  Application Default Theme
 */
Encore.reset();
Encore
    .setOutputPath( 'public/salary-j/build/default/' )
    .setPublicPath( '/build/default' )
    
    .autoProvidejQuery()
    .enableSassLoader(function(sassOptions) {}, {
        resolveUrlLoader: true
    })
    .configureFilenames({
        js: '[name].js?[contenthash]',
        css: '[name].css?[contenthash]',
        assets: '[name].[ext]?[hash:8]'
    })
    .enableSingleRuntimeChunk()
    .enableVersioning(Encore.isProduction())
    .enableSourceMaps( !Encore.isProduction() )
    
    .copyFiles({
         from: './assets/salary-j/images',
         to: 'images/[path][name].[ext]',
     })
    
    // Add Entries
    .addStyleEntry( 'css/login', './assets/salary-j/css/login.css' )
    .addStyleEntry( 'css/app', './assets/salary-j/css/main.scss' )
    .addEntry( 'js/app', './assets/salary-j/js/app.js' )
    
    .addEntry( 'js/pages/operators', './assets/salary-j/js/pages/operators.js' )
    .addEntry( 'js/pages/models', './assets/salary-j/js/pages/models.js' )
    .addEntry( 'js/pages/operations', './assets/salary-j/js/pages/operations.js' )
    .addEntry( 'js/pages/operators_work', './assets/salary-j/js/pages/operators_work.js' )
    .addEntry( 'js/pages/operators_work_new', './assets/salary-j/js/pages/operators_work_new.js' )
    .addEntry( 'js/pages/print', './assets/salary-j/js/pages/print.js' )
    .addEntry( 'js/pages/users', './assets/salary-j/js/pages/users.js' )
;

const applicationConfig = Encore.getWebpackConfig();
applicationConfig.name = 'salary-j';

//=================================================================================================

/**
 *  Test Theme
 */
 Encore.reset();
Encore
    .setOutputPath( 'public/salary-j/build/test-theme/' )
    .setPublicPath( '/build/test-theme' )
    
    .autoProvidejQuery()
    .enableSassLoader(function(sassOptions) {}, {
        resolveUrlLoader: true
    })
    .configureFilenames({
        js: '[name].js?[contenthash]',
        css: '[name].css?[contenthash]',
        assets: '[name].[ext]?[hash:8]'
    })
    .enableSingleRuntimeChunk()
    .enableVersioning(Encore.isProduction())
    .enableSourceMaps( !Encore.isProduction() )
    
    .copyFiles({
         from: './assets/test-theme/images',
         to: 'images/[path][name].[ext]',
     })
    
    // Add Entries
    .addStyleEntry( 'css/login', './assets/test-theme/css/login.scss' )
    .addEntry( 'js/login', './assets/test-theme/js/pages/login.js' )
    
    .addStyleEntry( 'css/app', './assets/test-theme/css/main.scss' )
    .addEntry( 'js/app', './assets/test-theme/js/app.js' )
    
    .addEntry( 'js/home', './assets/test-theme/js/pages/home.js' )
;

const testThemeConfig = Encore.getWebpackConfig();
testThemeConfig.name = 'test-theme';

//=================================================================================================


module.exports = [adminPanelConfig, applicationConfig, testThemeConfig];
