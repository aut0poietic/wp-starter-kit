module.exports = {
	files: {
		expand: true,                       // Enable dynamic expansion.
		cwd: 'assets/js/',                 // Src matches are relative to this path.
		src: [ '*.js', '!_*.js', '!*.min.js' ],   // Actual pattern(s) to match.
		dest: 'assets/js/',                      // Destination path prefix.
		ext: '.min.js'
	}
}