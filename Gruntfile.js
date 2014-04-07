// Borrowed from https://github.com/chriscoyier/My-Grunt-Boilerplate
// Thanks to Chris for an awesome introduction to grunt!

module.exports = function ( grunt ) {

	function loadConfig( path ) {
		var glob = require( 'glob' );
		var object = {};
		var key;
		glob.sync( '*' , { cwd : path } ).forEach( function ( option ) {
			key = option.replace( /\.js$/ , '' );
			object[key] = require( path + option );
		} );
		return object;
	}

	// Initial config
	var config = {
		pkg : grunt.file.readJSON( 'package.json' )
	}

	// Load tasks from the tasks folder
	grunt.loadTasks( 'grunt' );
	// Load all the tasks options in tasks/options base on the name
	grunt.util._.extend( config , loadConfig( './grunt/options/' ) );
	grunt.initConfig( config );

	require( 'load-grunt-tasks' )( grunt );
	// Default Task is basically a rebuild
	grunt.registerTask( 'default' , [ 'jshint', 'uglify', 'sass', 'autoprefixer', 'cssmin', 'imagemin' ] );
};