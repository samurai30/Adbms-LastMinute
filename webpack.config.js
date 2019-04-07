var Encore = require('@symfony/webpack-encore');
Encore
     .setOutputPath('public/build/')
     .setPublicPath('/build')
    .addEntry('app', './assets/js/app.js')
    .addStyleEntry('app/css', './assets/css/app.css')
     .disableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
;

module.exports = Encore.getWebpackConfig();
