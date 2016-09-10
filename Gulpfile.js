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
var nodemon = require('gulp-nodemon');

/**
 * Clean public directory
 * Used before compiling assets
 */
gulp.task("clean", function() {
    return del(['./target/**/*', "!./target/content"]);
});

gulp.task('sass', function () {
    return gulp.src('./src/app/scss/*.scss')
        .pipe(sass())
        .pipe(gulp.dest('./target/app/css/'));
});

gulp.task('sass-watch', function () {
    gulp.watch(['./src/app/**/*.scss'], ['sass'])
        .on('error', function(error){
            console.log('ERROR', error);
        });
});

gulp.task('cp-php', function(){
    return gulp.src('./src/**/*.php')
        .pipe(gulp.dest('./target'))
});

gulp.task('php-watch', function () {
    gulp.watch('./src/**/*.php', ['cp-php']);
});


gulp.task('usemin', function() {
    return gulp.src(['./src/app/**/*.php'])
        .pipe(usemin({
            js: [uglify()]
        }))
        .pipe(gulp.dest('target/app'));
});

gulp.task('copy', function(done){
    var count = 4;
    function countDown() {
        count--;
        if ( count == 0 ){
            done();
        }
    }

    gulp.src('./src/app/images/**/*')
        .pipe(gulp.dest('./target/app/images')).on("end", countDown);
    gulp.src('./src/app/mceTemplates/**/*')
        .pipe(gulp.dest('./target/app/mceTemplates/')).on("end", countDown);;
    gulp.src('./src/bower_components/bootstrap-sass-official/vendor/assets/fonts/bootstrap/**/*')
        .pipe(gulp.dest('./target/app/fonts/')).on("end", countDown);
    gulp.src([
        './src/**/*',
        './src/.htaccess',
        '!./src/app/**/*',
        '!./src/bower_components'
    ])
        .pipe(gulp.dest('./target')).on("end", countDown)
});

gulp.task('js-copy', function(){
    return gulp.src('./src/**/*.js')
        .pipe(gulp.dest('./target'));
});

gulp.task('js-watch',function(){
    gulp.watch('./src/app/js/**/*.js',['js-copy'] );
});

gulp.task('default', function (done) {
    runSequence('sass',['copy', 'sass-watch', 'php-watch', 'js-watch'], done);
});

gulp.task('build', function(cb) {
    runSequence('clean', 'sass', 'usemin', 'copy',  cb);
});
