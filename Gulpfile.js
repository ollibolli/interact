var gulp = require("gulp");
var usemin = require('gulp-usemin');
var uglify = require('gulp-uglify');
var minifyCss = require('gulp-minify-css');
var minifyHtml = require("gulp-minify-html");
var rev = require('gulp-rev');
var sass = require("gulp-sass");
var runSequence = require('run-sequence');
var del = require("del");
var bower = require('gulp-bower');

/**
 * Clean public directory
 * Used before compiling assets
 */
gulp.task("clean", function(done) {
  del(['./target/*'], done);
});

gulp.task('sass', function () {
  gulp.src('./src/app/scss/*.scss')
    .pipe(sass())
    .pipe(gulp.dest('./src/app/css/'));
});

gulp.task('sass-w', function () {
  gulp.src('./src/app/scss/*.scss')
    .pipe(sass())
    .pipe(gulp.dest('./src/app/css/'));
  gulp.watch(['./src/app/**/*.scss'], ['sass'])
    .on('error', function(error){
      console.log('ERROR', error);
    });
});

gulp.task('usemin', function() {
  gulp.src(['./src/**/*.php'])
    .pipe(usemin({
      css: [minifyCss(), 'concat', rev()],
      js: [uglify(),rev()]
    }))
    .pipe(gulp.dest('./target/'));
});

gulp.task('copy', function(){
  gulp.src('./src/app/images/**/*').pipe(gulp.dest('./target/app/images'));
  gulp.src('./src/app/mceTemplates/**/*').pipe(gulp.dest('./target/app/mceTemplates/'));
  gulp.src('./src/bower_components/bootstrap-sass-official/vendor/assets/fonts/bootstrap/**/*').pipe(gulp.dest('./target/app/fonts/'));

  gulp.src([
    './src/**/*',
    './src/.htaccess',
    '!./src/app/**/*',
    '!./src/*.php',
    '!./src/bower_components/**'
  ]).pipe(gulp.dest('./target'));

});

gulp.task('default', function(cb) {
  runSequence('clean','sass', 'copy', 'usemin', cb);
  gulp.watch(['./src/app/**/*.js', './src/app/**/*.scss', './src/app/**/*.php'], ['default'])
    .on('error', function(error){
      console.log('ERROR', error);
    });
});

gulp.task('build', function(cb) {
  runSequence('clean', 'sass', 'copy', 'usemin', cb);
});
