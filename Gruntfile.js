module.exports = function(grunt) {
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        sass: {
            dist: {
                options: {
                    sourcemap: true
                },
                files: {
                    'src/styles/main.css': 'src/styles/main.scss'
                }
            }
        }, //sass

        uglify: {
            js: { //target
                src: ['src/scripts/main.js'],
                dest: 'assets/js/main.js'
            }
        }, //uglify

        cssmin: {
            target: {
              files: [{
                  expand: true,
                  cwd: 'src/styles',
                  src: ['*.css', '!*.min.css'],
                  dest: 'assets/css',
                  ext: '.min.css'
              }]
            },
        }, //cssmin

        concat: {
            dist: {
                src: "src/scripts/**/*"
              , dest: "assets/js/main.js"
            }
        },

        watch: {
            css: {
                files: [
                    '**/*/*.scss', 
                    '**/*/*.js'
                ],
                tasks: ['concat', 'sass', 'cssmin', 'uglify']
            }
        }, 

    });

    // Load Grunt Plugins
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-watch');

    // Register Grunt Tasks
    grunt.registerTask('default', ['concat', 'sass', 'cssmin', 'uglify']);

};

