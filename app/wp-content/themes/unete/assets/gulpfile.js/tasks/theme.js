// ==== THEME ==== //

var gulp        = require( 'gulp' ),
   plugins     = require( 'gulp-load-plugins' )({ camelize: true }),
   config      = require( '../../gulpconfig' ).theme
;

// Copy everything under `src/languages` indiscriminately
gulp.task( 'theme-lang', function() {
  return gulp.src( config.lang.src )
  .pipe( plugins.changed( config.lang.dest ) )
  .pipe( gulp.dest( config.lang.dest ) );
});

// All the theme tasks in one
gulp.task( 'theme', [ 'theme-lang' ]);
