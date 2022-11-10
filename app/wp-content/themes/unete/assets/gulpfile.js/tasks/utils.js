// ==== UTILITIES ==== //

var gulp        = require( 'gulp' ),
   plugins     = require( 'gulp-load-plugins' )({ camelize: true }),
   del         = require( 'del' ),
   config      = require( '../../gulpconfig' ).utils
;

// Used to get around Sass's inability to properly @import vanilla CSS; see: https://github.com/sass/sass/issues/556
gulp.task( 'utils-normalize', function() {
  return gulp.src( config.normalize.src )
  .pipe( plugins.changed( config.normalize.dest ) )
  .pipe( plugins.rename( config.normalize.rename ) )
  .pipe( gulp.dest( config.normalize.dest ) );
});

// Clean out junk files after build
gulp.task( 'utils-clean', [ 'build'], function() {

  //return del( config.clean, {force: true});
});
gulp.task( 'utils-clean-dist', [ 'build-dist'], function() {

  //return del( config.clean, {force: true});
});

// Copy files from the `build` folder to `dist/[project]`
gulp.task( 'utils-dist', [ 'utils-clean-dist' ], function() {

  //return gulp.src( config.dist.src )
  //.pipe( gulp.dest( config.dist.dest ) );
});
