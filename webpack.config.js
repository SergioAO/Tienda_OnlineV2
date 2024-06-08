const Encore = require('@symfony/webpack-encore');
const path = require('path');
// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .addEntry('app', './assets/js/app.js')
    .addStyleEntry('styles', './assets/styles/app.css')
    .splitEntryChunks()
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = '3.23';
    })
    .autoProvidejQuery()
    .addAliases({
        // Aquí defines tus alias
        'bootstrap-js': path.resolve(__dirname, 'node_modules/bootstrap/dist/js/bootstrap.esm.js'),

    })
;

module.exports = Encore.getWebpackConfig();
