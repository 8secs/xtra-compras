module.exports = function(grunt) {

    grunt.initConfig({
        sass: {
            dist: {
                files: {
                    'assets/css/theme.css' : 'assets/scss/theme.scss'
                }
            }
        },
        postcss: {
            options: {
                map: true,
                processors: [
                    require('postcss-font-magician'),
                    require('postcss-flexbugs-fixes')
                ]
            },
            dist: {
                src: 'assets/css/theme.css',
                dest: 'assets/css/theme.css'
            }
        },
        autoprefixer: {
            dist: {
                files: {
                    'assets/css/theme.css' : 'assets/css/theme.css'
                }
            }
        },
        watch: {
            css: {
                files: '**/*.scss',
                tasks: ['sass', 'postcss', 'autoprefixer']
            }
        }
    });
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-postcss');
    grunt.loadNpmTasks('grunt-autoprefixer');
    grunt.registerTask('default', ['watch']);
};