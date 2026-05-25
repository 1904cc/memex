var gulp = require('gulp'),
    sass = require('gulp-sass')(require('sass')),
    sourcemaps = require('gulp-sourcemaps'),
    autoprefixer = require('gulp-autoprefixer'),
    cssnano = require('gulp-cssnano');

gulp.task('stylesheets', function(done) {
  gulp.src('assets/source/stylesheets/*.scss')
    .pipe(sourcemaps.init())
    .pipe(sass().on('error', sass.logError))
    .pipe(autoprefixer({ overrideBrowserslist: ['last 2 versions'] }))
    .pipe(sourcemaps.write())
    .pipe(cssnano())
    .pipe(gulp.dest('assets/build/stylesheets'));
  done();
});

gulp.task('build', gulp.series('stylesheets', function(done) {
  done();
}));

gulp.task('default', gulp.series('stylesheets', function(done) {
  gulp.watch('assets/source/stylesheets/*.scss', gulp.series('stylesheets'));
  done();
}));