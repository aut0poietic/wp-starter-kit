module.exports = {
	scripts: {
		files: ['assets/js/*.js', 'assets/js/**/*.js'],
		tasks: [ 'jshint', 'uglify'],
//		tasks: [ 'jshint', 'concat', 'uglify'], // if you need concat
		options: {
			spawn: false
		}
	},
	css: {
		files: ['assets/css/*.scss', 'assets/css/**/*.scss'],
		tasks: ['sass', 'autoprefixer', 'cssmin'],
		options: {
			spawn: false
		}
	},
	images: {
		files: ['assets/img/**/*.{png,jpg,gif}', 'assets/img/*.{png,jpg,gif}'],
		tasks: ['imagemin'],
		options: {
			spawn: false
		}
	}
}