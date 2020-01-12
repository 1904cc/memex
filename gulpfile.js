// Requiring Gulp
var gulp = require('gulp'),
    sass = require('gulp-sass'),                 // Requiring gulp-sass (compiles SCSS)
    sourcemaps = require('gulp-sourcemaps'),     // Requiring sourcemaps (helps working locally)
    autoprefixer = require('gulp-autoprefixer'), // Requiring autoprefixer (adds browser prefixes)
    cssnano = require('gulp-cssnano'),           // Requiring cssnano (minifies CSS)
    imagemin = require('gulp-imagemin'),         // Requiring imagemin (lossless image optimization)
    shell = require('gulp-shell'),               // Requiring gulp-shell (used for KSS node)
    kssNode = 'node ' + __dirname + '/node_modules/kss/bin/kss-node '; // Require kss-node



// Start stylesheets task
gulp.task('stylesheets', function() {
  gulp.src('assets/source/stylesheets/*.scss') // Get all *.scss files
    .pipe(sourcemaps.init()) // Initialize sourcemap plugin
    .pipe(sass().on('error', sass.logError)) // Compiling sass
    .pipe(autoprefixer('last 2 version')) // Adding browser prefixes
    .pipe(sourcemaps.write()) // Writing sourcemaps
    .pipe(cssnano()) // Compress
    .pipe(gulp.dest('assets/build/stylesheets'))
});



// Start build task
// gulp.task('build', ['stylesheets'], function() {});
gulp.task('build', gulp.series('stylesheets', function() { 
    // default task code here
    done();
}));

// Start watch groups of tasks
// gulp.task('default', ['stylesheets'], function() {
gulp.task('default', gulp.series('stylesheets', function() { 
  gulp.watch('assets/source/stylesheets/*.scss', ['stylesheets']); // Watch for SCSS changes
  // gulp.watch('source/assets/scripts/**/*.js', ['scripts']); // Watch for JS changes
  // gulp.watch('build/**.html', browserSync.reload);
  // gulp.watch('styleguide/**.html', browserSync.reload);
  done();
}));