module.exports = {
	dist: {
		options: {
			// cssmin will minify later
			style: 'expanded'
		},
		files: [{
			expand: true,                       // Enable dynamic expansion.
			cwd: 'assets/css/',                 // Src matches are relative to this path.
			src: [ '*.scss', '!_*.scss' ],   // Actual pattern(s) to match.
			dest: '.tmp/',                      // Destination path prefix.
			ext: '.css'
		}]
	}
}