// ==== STYLES ==== //

var gulp          = require( 'gulp' ),
   plumber       = require( 'gulp-plumber' ),
   gutil         = require( 'gulp-util' ),
   plugins       = require( 'gulp-load-plugins' )({ camelize: true }),
   config        = require( '../../gulpconfig' ).styles,
   autoprefixer  = require( 'autoprefixer' ),
   md5 = require( 'gulp-md5' ),
   del = require( 'del' ),
   processors    = [ autoprefixer( config.autoprefixer ) ] // Add additional PostCSS plugins to this array as needed
;

gulp.task( 'styles-cleanup', function() {

    del.sync([ config.build.dest + '*.css*' ], {force: true});
});

// Build stylesheets from source Sass files, autoprefix, and write source maps (for debugging) with rubySass
gulp.task( 'styles-rubysass', function() {
  return plugins.rubySass( config.build.src, config.rubySass )
  .pipe( plumber() )
  .on( 'error', gutil.log ) // Log errors instead of killing the process
  .pipe( plugins.postcss( processors ) )
  .pipe( plugins.cssnano( config.minify ) )
  .pipe( plugins.sourcemaps.write( './' ) ) // No need to init; this is set in the configuration
  .pipe( gulp.dest( config.build.dest ) ); // Drops the unminified CSS file into the `build` folder
});

// Build stylesheets from source Sass files, autoprefix, and write source maps (for debugging) with libsass
gulp.task( 'styles-libsass', function() {
  return gulp.src( config.build.src )
  .pipe( plumber() )
  .pipe( plugins.sourcemaps.init() )
  .pipe( plugins.sass( config.libsass ) )
  .pipe( plugins.postcss( processors ) )
  .pipe( plugins.cssnano( config.minify ) )
  .pipe( plugins.sourcemaps.write( './' ) ) // Writes an external sourcemap
  .pipe( gulp.dest( config.build.dest ) )
  .pipe( md5( 10 ) )
  .pipe( gulp.dest( config.build.dest ) ); // Drops the unminified CSS file into the `build` folder
});

// Build stylesheets from source Sass files, autoprefix, and write source maps (for debugging) with libsass
gulp.task( 'styles-libsass-dist', function() {
  return gulp.src( config.build.src )
  .pipe( plumber() )
  .pipe( plugins.sass( config.libsass ) )
  .pipe( plugins.postcss( processors ) )
  .pipe( plugins.cssnano( config.minify ) )
  .pipe( gulp.dest( config.build.dest ) )
  .pipe( md5( 10 ) )
  .pipe( gulp.dest( config.build.dest ) );
});


// Easily configure the Sass compiler from `/gulpconfig.js`
gulp.task( 'styles', [ 'styles-cleanup', 'styles-' + config.compiler ]);
gulp.task( 'styles-dist', [ 'styles-cleanup', 'styles-' + config.compiler + '-dist' ]);
