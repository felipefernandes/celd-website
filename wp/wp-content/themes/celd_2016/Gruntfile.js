module.exports = function(grunt) {
  grunt.initConfig({
     // configurações das tasks
     less: {
       'css/main.css': 'css-less/main.less'
     }, //less     

      uglify: {
          js: { //target
              src: ['js/main.js'],
              dest: 'js/main.min.js'
          }
      }, //uglify

      cssmin: {
        options: {
          shorthandCompacting: false,
          roundingPrecision: -1
        },
        target: {
          files: {
            'css/main.min.css': 'css/main.css'
          }
        }
      }, //cssmin

      watch : {
        dist : {
          files : [
            'js/*',
            'css-less/*'
          ],

          tasks : [ 'less', 'cssmin', 'uglify' ]
        }
      } // watch


  });

  // carrega plugins
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-less');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks( 'grunt-contrib-watch' );

  // Tarefa para o comando default
  grunt.registerTask('default', ['less', 'cssmin', 'uglify']);

  // Tarefa para Watch
  grunt.registerTask( 'w', [ 'watch' ] );
};