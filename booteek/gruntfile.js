module.exports = function (grunt) {
    require('jit-grunt')(grunt);
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-cssmin');


    var pkgConfig = grunt.file.readJSON('package.json');

    grunt.initConfig({

        pkg: pkgConfig,

        cssmin: {
            options: {
                mergeIntoShorthands: false,
                roundingPrecision: -1,
                sourceMap:true
            },
            target: {
                files: {
                    'css/style.min.css': ["css/style.css"]
                }
            }
        },
        less: {
            development: {
                options: {
                    paths: ["css"]
                },
                files: {"css/style.css": "less/**/*.less"}
            }
        },
        watch: {
            styles: {
                files: ['less/**/*.less'], // which files to watch
                tasks: ['less', 'cssmin'],
                options: {
                    nospawn: true,
                    livereload: false
                }
            }
        }
    });

    grunt.registerTask('booteek', ['less', 'cssmin','watch']);
};