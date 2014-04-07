module.exports = {
	combine : {
		files : [{
			expand : true ,       // Enable dynamic expansion.
			cwd    : '.tmp/' ,    // Src matches are relative to this path.
			src    : [ '*.css'] , // Actual pattern(s) to match.
			dest   : 'assets/css/' ,     // Destination path prefix.
			ext    : '.css'       // Dest filepaths will have this extension.
		}]
	}
}