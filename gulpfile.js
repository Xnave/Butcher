var elixir = require('laravel-elixir');
var git = require('gulp-git');
/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */
var paths = {
    'jquery': './vendor/bower_components/jquery/',
    'angular': './vendor/bower_components/angular/',
    'bootstrap': './vendor/bower_components/bootstrap-sass/assets/',
    'moments': './vendor/bower_components/moment/min/',
    'angucomplete': './vendor/bower_components/angucomplete-alt/dist/'
    //'ng_route': './vendor/bower_components/angular-route/'
};

elixir(function(mix) {

    mix.scripts([
            paths.jquery + "dist/jquery.js",
        paths.angular + "angular.js",
        paths.bootstrap + "javascripts/bootstrap.min.js",
        paths.moments + "moment.min.js",
        paths.angucomplete + "angucomplete-alt.min.js"
        //paths.ng_route + "angular-route.min.js"
        ], 'public/js/external_libs.js', './');

    mix.scriptsIn('public/js/app', 'public/js/app.js');

    mix.stylesIn("public/css/app", 'public/css/app.css');

    mix.version('public/css/app.css')
                    .pipe(git.add());

});
