"use strict";

var path = require("path"),
  gulp = require("gulp"),
  gutil = require("gulp-util"),
  gPlugins = require("gulp-load-plugins"),
  runSequence = require("run-sequence"),
  glob = require("glob"),
  source = require("vinyl-source-stream"),
  browserify = require("browserify"),
  watchify = require("watchify");

var plugins = gPlugins();

/** Configuration **/
var config = {
  autoprefixerBrowsers: [
    "last 2 versions",
    "IE >= 8"
  ]
};

var state = {
  watch : false
};

/**
 * Helper: Plumber error handler
 */
var errorHandler = function(error) {
  gutil.log(gutil.colors.red(error.message));
  gutil.beep();
  this.emit("end");
};

/**
 * Clean public directory
 * Used before compiling assets
 */
gulp.task("clean", function() {
  return gulp.src("target", { read: false })
    .pipe(plugins.rimraf());
});

/**
 * Compile SCSS into CSS
 */
gulp.task("css", function() {
  var src = "src/app/styles/*.scss",
    dest = "target/app/styles/";

  return gulp.src(src)
    .pipe(state.watch ? plugins.plumber(errorHandler) : gutil.noop())
    .pipe(plugins.cssGlobbing({ extensions: [".css", ".scss"] }))
    .pipe(plugins.sass())
    .pipe(plugins.importCss())
    .pipe(plugins.pixrem(1))
    .pipe(plugins.autoprefixer({ browsers: config.autoprefixerBrowsers }))
    .pipe(plugins.combineMediaQueries())
    .pipe(gulp.dest(dest));
});

/**
 * Compile JavaScript with Browserify
 */
gulp.task("js", function(done) {
  var src = "src/app/scripts/main.js";
  var dest = "target/app/scripts/main.js";

  var options = {
    debug: true
  };

  var bundlePaths = glob.sync(path.join(__dirname, src));
  var bundleQueue = bundlePaths.length;

  var createBundler = function(filePath) {
    var bundler = browserify({
      cache: {},
      packageCache: {},
      entries: filePath,
      basedir: process.cwd(),
      fullPaths: false,
      debug: options.debug
    });

    var bundle = function() {
      gutil.log("bundling", gutil.colors.magenta(path.basename(filePath)));

      return bundler
        .bundle()
        .on("error", errorHandler)
        .pipe(source(path.basename(filePath)))
        .pipe(gulp.dest(dest))
        .on("end", reportFinished);
    };

    if (state.watch) {
      bundler = watchify(bundler);
      bundler.on("update", bundle);
    }

    return bundle();
  };

  var reportFinished = function() {
    if (bundleQueue) {
      bundleQueue--;

      if (bundleQueue === 0) {
        done();
      }
    }
  };

  bundlePaths.forEach(createBundler);
});

gulp.task("images", function() {
  return gulp.src("src/app/images/**/*.*")
    .pipe(gulp.dest("target/app/images"));
});

/**
 * Compile front-end assets
 */
gulp.task("build", function(done) {
  runSequence("clean", ["css", "js", "images"], done);
});

/**
 * Watch for changes in front end files and rebuild
 **/
gulp.task("watch", function(done) {
  state.watch = true;

  // Re-compile scss on change
  plugins.watch("src/app/styles/**/*.scss", { name: "css" }, function(files, done) {
    gulp.start("css");
    done();
  });

  done();
});

gulp.task("pause", function(done) {
  setTimeout(done, 1000);
});


gulp.task("default", function() {
  runSequence("watch", "build");
});
