// Generated on 2014-04-10 using generator-webapp 0.4.8
'use strict';

// # Globbing
// for performance reasons we're only matching one level down:
// 'test/spec/{,*/}*.js'
// use this if you want to recursively match all subfolders:
// 'test/spec/**/*.js'

module.exports = function (grunt) {

    // Load grunt tasks automatically
    require('load-grunt-tasks')(grunt);

    // Time how long tasks take. Can help when optimizing build times
    require('time-grunt')(grunt);

    // Define the configuration for all the tasks
    grunt.initConfig({

        // Project settings
        config: {
            // Configurable paths
            app: 'src',
            dist: 'target',
            src: 'src',
            target:'target'	
        },
        // Watches files for changes and runs tasks based on the changed files
        watch: {
            bower: {
                files: ['bower.json'],
                tasks: ['bowerInstall']
            },
            js: {
                files: ['<%= config.app %>/app/scripts/{,*/}*.js'],
                tasks: ['jshint'],
                options: {
                    livereload: true
                }
            },
            jstest: {
                files: ['test/spec/{,*/}*.js'],
                tasks: ['test:watch']
            },
            gruntfile: {
                files: ['Gruntfile.js']
            },
            compass: {
                files: ['<%= config.app %>/app/styles/{,*/}*.{scss,sass}'],
                tasks: ['compass:server', 'autoprefixer', 'copy:app']
            },
            styles: {
                files: ['<%= config.app %>/app/styles/{,*/}*.css'],
                tasks: ['newer:copy:styles', 'autoprefixer']
            },
        },

        // The actual grunt server settings
        connect: {
            options: {
                port: 9000,
                livereload: 35729,
                // Change this to '0.0.0.0' to access the server from outside
                hostname: 'localhost'
            },
            livereload: {
                options: {
                    open: true,
                    base: [
                        '.tmp',
                        '<%= config.src %>'
                    ]
                }
            },
            test: {
                options: {
                    port: 9001,
                    base: [
                        '.tmp',
                        'test',
                        '<%= config.src %>'
                    ]
                }
            },
            dist: {
                options: {
                    open: true,
                    base: '<%= config.target %>',
                    livereload: false
                }
            }
        },

        // Empties folders to start fresh
        clean: {
            dist: {
                files: [{
                    dot: true,
                    src: [
                        '.tmp',
                        '<%= config.target %>',
                    ]
                }]
            },
            server: '.tmp'
        },

        // Make sure code styles are up to par and there are no obvious mistakes
        jshint: {
            options: {
                jshintrc: '.jshintrc',
                reporter: require('jshint-stylish')
            },
            all: [
                'Gruntfile.js',
                '<%= config.app %>/app/scripts/{,*/}*.js',
                '!<%= config.app %>/app/scripts/vendor/*',
                'test/spec/{,*/}*.js'
            ]
        },

        // Mocha testing framework configuration options
        mocha: {
            all: {
                options: {
                    run: true,
                    urls: ['http://<%= connect.test.options.hostname %>:<%= connect.test.options.port %>/index.php']
                }
            }
        },

        // Compiles Sass to CSS and generates necessary files if requested
        compass: {
            options: {
                sassDir: '<%= config.app %>/app/styles',
                cssDir: '.tmp/styles',
                generatedImagesDir: '.tmp/images/generated',
                imagesDir: '<%= config.app %>/app/images',
                javascriptsDir: '<%= config.app %>/app/scripts',
                fontsDir: '<%= config.app %>/app/styles/fonts',
                importPath: '<%= config.app %>/app/bower_components',
                httpImagesPath: '/app/images',
                httpGeneratedImagesPath: '/app/images/generated',
                httpFontsPath: '/app/styles/fonts',
                relativeAssets: false,
                assetCacheBuster: false
            },
            dist: {
                options: {
                    generatedImagesDir: '<%= config.dist %>/app/images/generated',
                    debugInfo: false
                }
            },
            server: {
                options: {
                    debugInfo: true
                }
            }
        },

        // Add vendor prefixed styles
        autoprefixer: {
            options: {
                browsers: ['last 1 version']
            },
            dist: {
                files: [{
                    expand: true,
                    cwd: '.tmp/styles/',
                    src: '{,*/}*.css',
                    dest: '.tmp/styles/'
                }]
            }
        },

        // Automatically inject Bower components into the HTML file
        bowerInstall: {
            app: {
                src: ['<%= config.src %>/index.php'],
                ignorePath: '<%= config.app %>/app',
                exclude: ['<%= config.app %>/app/bower_components/bootstrap-sass/vendor/assets/javascripts/bootstrap.js']
            },
            sass: {
                src: ['<%= config.app %>/app/styles/{,*/}*.{scss,sass}'],
                //ignorePath: '<%= config.app %>/app/bower_components/'
            }
        },

        // Renames files for browser caching purposes
        rev: {
            dist: {
                files: {
                    src: [
                        '<%= config.dist %>/app/scripts/{,*/}*.js',
                        '<%= config.dist %>/app/styles/{,*/}*.css',
                        '<%= config.dist %>/app/images/{,*/}*.*',
                        '<%= config.dist %>/app/styles/fonts/{,*/}*.*',
                        '<%= config.dist %>/app/*.{ico,png}'
                    ]
                }
            }
        },

        // Reads HTML for usemin blocks to enable smart builds that automatically
        // concat, minify and revision files. Creates configurations in memory so
        // additional tasks can operate on them
        useminPrepare: {
            options: {
                dest: '<%= config.dist %>/'
            },
            html: '<%= config.src %>/index.php'
        },

        // Performs rewrites based on rev and the useminPrepare configuration
        usemin: {
            options: {
                assetsDirs: ['<%= config.dist %>/app', '<%= config.dist %>/app/images']
            },
            html: ['<%= config.target %>/{,*/}*.php'],
            css: ['<%= config.dist %>/app/styles/{,*/}*.css']
        },

        // The following *-min tasks produce minified files in the dist folder
        imagemin: {
            dist: {
                files: [{
                    expand: true,
                    cwd: '<%= config.app %>/app/images',
                    src: '{,*/}*.{gif,jpeg,jpg,png}',
                    dest: '<%= config.dist %>/app/images'
                }]
            }
        },

        svgmin: {
            dist: {
                files: [{
                    expand: true,
                    cwd: '<%= config.app %>/app/images',
                    src: '{,*/}*.svg',
                    dest: '<%= config.dist %>/app/images'
                }]
            }
        },

        htmlmin: {
            dist: {
                options: {
                    collapseBooleanAttributes: true,
                    collapseWhitespace: true,
                    removeAttributeQuotes: true,
                    removeCommentsFromCDATA: true,
                    removeEmptyAttributes: true,
                    removeOptionalTags: true,
                    removeRedundantAttributes: true,
                    useShortDoctype: true
                },
                files: [{
                    expand: true,
                    cwd: '<%= config.target %>',
                    src: '{,*/}*.html',
                    dest: '<%= config.target %>'
                }]
            }
        },

        // By default, your `index.php`'s <!-- Usemin block --> will take care of
        // minification. These next options are pre-configured if you do not wish
        // to use the Usemin blocks.
        // cssmin: {
        //     dist: {
        //         files: {
        //             '<%= config.dist %>/styles/main.css': [
        //                 '.tmp/styles/{,*/}*.css',
        //                 '<%= config.app %>/styles/{,*/}*.css'
        //             ]
        //         }
        //     }
        // },
        // uglify: {
        //     dist: {
        //         files: {
        //             '<%= config.dist %>/scripts/scripts.js': [
        //                 '<%= config.dist %>/scripts/scripts.js'
        //             ]
        //         }
        //     }
        // },
        // concat: {
        //     dist: {}
        // },

        // Copies remaining files to places other tasks can use
        copy: {
            dist: {
                files: [{
                    expand: true,
                    dot: true,
                    cwd: '<%= config.src %>',
                    dest: '<%= config.target %>',
                    src: [
                        'app/lib/**/*.*',
                        'app/mceTemplate/**/*.*',
                        'app/images/{,*/}*.webp',
                        'app/styles/fonts/{,*/}*.*',
                        'app/bower_components/bootstrap-sass-official/vendor/assets/fonts/bootstrap/*.*',
                        '{,*/}*.php',
                        '*.{ico,png,txt}',
                        '.htaccess',
                        'filemanager/**/*.*',
                        'content/**/*.*'
                    ]
                }]
            },
            styles: {
                expand: true,
                dot: true,
                cwd: '<%= config.app %>/styles',
                dest: '.tmp/styles/',
                src: '{,*/}*.css'
            },
            app: {
                expand: true,
                dot: true,
                cwd: '.tmp/styles',
                dest: '<%= config.app %>/app/styles/',
                src: '{,*/}*.css'
            }
        },

        // Generates a custom Modernizr build that includes only the tests you
        // reference in your app
        modernizr: {
            devFile: '<%= config.app %>/app/bower_components/modernizr/modernizr.js',
            outputFile: '<%= config.dist %>/app/scripts/vendor/modernizr.js',
            files: [
                '<%= config.dist %>/app/scripts/{,*/}*.js',
                '<%= config.dist %>/app/styles/{,*/}*.css',
                '!<%= config.dist %>/app/scripts/vendor/*'
            ],
            uglify: true
        },

        // Run some tasks in parallel to speed up build process
        concurrent: {
            server: [
                'compass:server',
                'copy:styles'
            ],
            test: [
                'copy:styles'
            ],
            dist: [
                'imagemin',
                'svgmin'
            ]
        }
    });


    grunt.registerTask('serve', function (target) {
        if (target === 'dist') {
            return grunt.task.run(['build', 'connect:dist:keepalive']);
        }

        grunt.task.run([
            'clean:server',
            'concurrent:server',
            'autoprefixer',
            'connect:livereload',
            'watch'
        ]);
    });

    grunt.registerTask('server', function (target) {
        grunt.log.warn('The `server` task has been deprecated. Use `grunt serve` to start a server.');
        grunt.task.run([target ? ('serve:' + target) : 'serve']);
    });

    grunt.registerTask('test', function (target) {
        if (target !== 'watch') {
            grunt.task.run([
                'clean:server',
                'concurrent:test',
                'autoprefixer'
            ]);
        }

        grunt.task.run([
            'connect:test',
            'mocha'
        ]);
    });

    grunt.registerTask('build', [
        'clean:dist',
        'compass:dist',
        'copy:styles',
        'useminPrepare',
        'imagemin',
        'svgmin',
        'autoprefixer',
        'concat',
        'cssmin',
        'uglify',
        'copy:dist',
        'modernizr',
        //'rev',
        'usemin',
        'htmlmin'
    ]);

    grunt.registerTask('default', [
        'newer:jshint',
        'test',
        'build'
    ]);
};
