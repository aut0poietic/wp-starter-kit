# Starter-Kit #
## WordPress Plugin Foundation ##

**Starter-Kit** is a development kit for rapidly building WordPress plugins, providing some useful
services and a clean way to structure a plugin.

## New in 0.9 ##

+   Starter-Kit now makes use of namespaces and reflection available in **PHP 5.3 or better**.
+   Streamlined Feature-based development process ("Drop-ins" are out ).
+   Classes extending Feature no longer need the init function.
+   All basic Starter-Kit behavior has been moved to separate classes and can be removed from
	the plugin if not needed.
+   Template and option services live in the `Feature` class/subclasses.
+   Nearly all boilerplate has been moved into the `Kit` or `Feature` classes and out of the way.
+   Added Grunt support
	+   SASS, autoprefixer and cssmin for CSS
	+   JavaScript inspected JSHint and compressed with Uglify
	+   Images compressed with imagemin
	+   Default grunt task and watch task `dev`
	+   npm install from package.json

### Feature-based Development ###

I can't speak for other developers, but when I build a plugin I want to think about
what the plugin does, the features I plan to build. I want to use OOP. I want a clean separation of my PHP
logic and HTML views. I want to start a project running with everything I need -- then I never want to see it,
much less think about it, again. That's what this framework is designed to provide.

With Starter-Kit, you build Features -- small classes that extend from the framework's `Feature`
class -- and drop them into one of three folders (`admin`, `client`, or `core`). These files are automatically loaded
in the correct context so you're only loading the functionality you need, when you need it.

Your classes aren't required to extend Feature, but doing so adds some useful services:
+   Auto-initializing static method for instantiating your feature from an action-hook.
+   A template class for separating your class's logic from HTML output.
+   WordPress-options handling methods, with values namespaced to your plugin.
+   Class-Friendly methods for adding actions &amp; filters to WordPress without array-wrapping.
+   WordPress AJAX methods wrapped for easy implementation.

In addition to auto-class loading, the base plugin itself:
+   handles default plugin options, with the ability to handle defaults between plugin versions.
+   adds an init hook for your plugin that triggers Feature initiation.
+   sets default template directory for your rendering
+   provides ready for use activation and deactivation hooks

And if that's not enough for you, the project comes ready for use with SASS, autoprefixer, jshint, uglify
and imagemin -- and of course it's just a starting point. Grunt being grunt means you can tweak it
to your heart's content.

## Getting Started with Starter-Kit ##

Starter-Kit is a template that you customize:

1.  Download Starter-Kit and copy the files to your development directory and rename
	'starter-kit.php' to the name of your plugin.
2.  In your development tool of choice, do a **global** find-and-replace:
	+   Replace all instances of the "irresponsible_art\starter_kit" namespace to reflect your organization
	+   Replace all instances of "StarterKit" to your class name.
	+   Replace all instances of "starter_kit" with your plugin's slug -- this will replace things like the
		WP text-domain, options key, and a few other strings.

If you plan to use grunt in your project:

1.  Open `package.json` and change the name and version of the plugin.
2.  In a console, navigate to your development directory and run 'npm install'.
3.  In that same console, run 'grunt' to test your build
4.  When you're ready to work, run the 'grunt dev' to start the watch task ( ctrl + C stops it ).

## A Sample Feature ##

The framework comes with a sample feature already in the assets/core folder ("rebrand.php") which rebrands the
WordPress login screen and utilizes the majority of the frameworks features, if only in a basic way.

The examples below are all pulled from the Rebrand class. Keep in mind that the examples do not change the default
namespace or plugin slug -- but you must.

#### Warning: Lame Example Ahead ####

The "rebrand" feature is not only one of the stupidest examples of a plugin known to man, it also goes
to near idiotic lengths to make use of SASS, JavaScript, templates, actions, filters and options.
No one in their right mind would use it.

That said, the animation is still kind cool to watch.
<p align="center"><img src="rebrand.gif"></p>

### Feature Subclasses ###

Features are classes that extend Starter-Kit's Feature class, inheriting useful methods for interacting with
WordPress, rendering HTML and initialization. Here's a minimal example:

```php
namespace irresponsible_art\starter_kit;
class LoginBranding extends Feature {
	public function __construct() {
		...
	}
}
// Subscribe to the drop-in to the initialization event
add_action( 'starter_kit_init', array( 'irresponsible_art\starter_kit\LoginBranding', 'init' ) );
```

Again, you'd need to replace "irresponsible_art\starter_kit" namespace at the top and bottom of the document,
as well as changing 'starter_kit_init' to use your slug instead of "starter_kit".

### Actions & Filters ###

Your feature should then add actions or filters in the constructor and handle them in the body of the class.
The Feature class exposes three methods for making handling actions & filter methods.

<dl>
<dt><code>$this->marshal( $methodName )</code></dt>
<dd>Creates a <code>callable</code> array for the method corresponding to the string <code>$methodName</code>.</dd>

<dt><code>$this->add_action( $action, $method_name, $priority = 10, $accepted_args = 2 )</code></dt>
<dd>Marshaled version of <a href="https://codex.wordpress.org/Function_Reference/add_action" target="_blank">
WordPress add_action method</a></dd>

<dt><code>$this->add_filter( $action, $method_name, $priority = 10, $accepted_args = 2 )</code></dt>
<dd>Marshaled version of <a href="https://codex.wordpress.org/Function_Reference/add_filter" target="_blank">
WordPress add_filter method</a></dd>
</dl>

The Rebrand feature adds a filter for `login_message` and the method to handle the filter:

```php
namespace irresponsible_art\starter_kit;
class LoginBranding extends Feature {
	public function __construct() {
		$this->add_filter( 'login_message', 'plugin_login_message' );
	}
	public function plugin_login_message( $message ) {
		// Handle the filter here.
		return $message ;
	}
}
// Subscribe to the drop-in to the initialization event
add_action( 'starter_kit_init', array( 'irresponsible_art\starter_kit\LoginBranding', 'init' ) );
```

### Options ###

The rebrand feature stores the name of the plugin as a WordPress option, and Starter-Kit stores
options within a plugin namespace -- in this case a single variable in the WordPress options.  But
you don't have to worry about any of that. Just use the `get_option` method.

```php
namespace irresponsible_art\starter_kit;
class LoginBranding extends Feature {
	public function __construct() {
		$this->add_filter( 'login_message', 'plugin_login_message' );
	}
	public function plugin_login_message( $message ) {
		$plugin_name = $this->get_option( 'plugin_name', 'Starter Kit!' ) ;

		// Do something with $plugin_name....
		return $message ;
	}
}
// Subscribe to the drop-in to the initialization event
add_action( 'starter_kit_init', array( 'irresponsible_art\starter_kit\LoginBranding', 'init' ) );
```

The `get_option` method takes 2 parameters; The name of the option and a fallback value -- so you
never get back a null or empty value from WordPress (unless you want to).

Another way of dealing with unset values is the `defaults` method in the core plugin file. This method
contains an array of option values your plugin needs and saves them all when the plugin is activated.
This ensures that you always have meaningful values when the user installs the plugin.

You can also update the defaults array as your plugin grows. Each time the plugin is activated (such as
when a new version is installed) your plugin will update the options, removing unused values, adding new values,
and preserving existing ones.

The rebrand feature would update the defaults array:

```php
private static function defaults() {
		return array(
			'plugin_name' => 'Starter Kit'
		);
	}
```

### Templates ###

The Rebrand feature should output the string "$plugin_name Activate!" in an HTML formatted message.
We could use inline strings to output the message (and in reality, you probably should with an HTML string
this simple), but Starter-Kit attempts to separate HTML rendering from PHP logic by using templates.

```php
namespace irresponsible_art\starter_kit;
class LoginBranding extends Feature {
	public function __construct() {
		$this->add_filter( 'login_message', 'plugin_login_message' );
	}
	public function plugin_login_message( $message ) {
		$plugin_name = $this->get_option( 'plugin_name', 'Starter Kit!' ) ;
		$template = $this->get_template();
        $template->set( 'plugin_name', $plugin_name );
        $message = $template->apply( 'login-message.php' );
		return $message ;
	}
}
// Subscribe to the drop-in to the initialization event
add_action( 'starter_kit_init', array( 'irresponsible_art\starter_kit\LoginBranding', 'init' ) );
```

Calling the Feature class' `get_template()` method returns a shiny new `Template` class for your string output.
The `Template` class is very simple, having only a few methods:

<dl>
<dt><code>$template->set( $name, $value )</code></dt>
<dd>Sets a variable in the template scope with the name <code>$name</code> and the value <code>$value</code>.</dd>

<dt><code>$template->set_vars( $pairs, $append = TRUE )</code></dt>
<dd>Sets an array of name/value pairs -- Same as calling <code>set()</code> multiple times. The second optional
parameter can be set to `FALSE` if you want to remove any previously set values.</dd>

<dt><code>$template->clear()</code></dt>
<dd>Clears any values previously set with <code>set()</code> or <code>set_vars()</code></dd>

<dt><code>apply( $file, $use_default_path = TRUE )</code></dt>
<dd>Applies the previously set values to the template with the name in `$file` and returns the rendered string.
Template files are assumed to be in the <code>assets/templates</code> folder. If your template is in another
location, specify the full path in the <code>$file</code> value and use the optional second parameter,
setting it to <code>FALSE</code></dd>
</dl>

Template files themselves are PHP -- no confusing syntax or regex/string replacement to slow down your plugin.

```php
<div class="message hidden"><?php echo $plugin_name ; ?> has been activated</div>
```

### AJAX ###

The plugin exposes two additional method not used in the Rebrand Feature.

<dl>
<dt><code>$this->add_admin_ajax( $action )</code></dt>
<dd>Using the method provided in <code>$action</code>, creates an WordPress AJAX action of the same name.
 This action will only be available to users who are logged into WordPress.</dd>

<dt><code>$this->add_client_ajax( $action )</code></dt>
<dd>Using the method provided <code>$action</code>, creates an WordPress AJAX action of the same name.
 This action will be available to all users.</dd>
</dl>

Like the action / filter hooks, the ajax methods attach themselves to methods in your `Feature` subclasses.
The method names become the "actions" that WordPress recognizes when an AJAX request is made and routes the
 request to your class' method. A quick-and-dirty example:

The Feature class:
```php
namespace irresponsible_art\starter_kit;
class BasicMath extends Feature {
	public function __construct() {
		$this->add_admin_ajax( 'add_numbers' );
	}
	public function add_numbers(){
		$num_1 = intval( $_POST[ 'num_1' ] );
		$num_2 = intval( $_POST[ 'num_2' ] );
		echo $num_1 + $num_2 ;
		die( ) ;
	}
}
// Subscribe to the drop-in to the initialization event
add_action( 'starter_kit_init', array( 'irresponsible_art\starter_kit\BasicMath', 'init' ) );
```

The JavaScript, somewhere in our page:
```JavaScript
jQuery( document ).ready( function( $ ) {
	var data = {
		action: 'add_numbers',
		num_1: 2,
		num_1: 3
	};

	$.post( ajaxurl, data, function( response ) {
		alert( 'Got this from the server: ' + response );
	});
});
```

AJAX in WordPress is a fairly large topic. For more information on using AJAX with WordPress, see the codex
 article [AJAX in Plugins](http://codex.wordpress.org/AJAX_in_Plugins).

### Using Grunt ###

Starter-Kit now comes with a **very** basic grunt configuration. The setup is fairly simple:

+   grunt tasks are in the root of the `grunt` folder.
+   grunt task options are in the `grunt/options` folder.

The structure is fairly flexible, and you should be able to add additional tasks and options or edit the existing
elements at will. But the nuts and bolts of using grunt is far beyond the scope of this readme.
The best tutorial (IMO) is from [Chris Coyier on 24 Ways](http://24ways.org/2013/grunt-is-not-weird-and-hard/).
You can also view his [screen cast](http://css-tricks.com/video-screencasts/130-first-moments-grunt/)
on the subject.

#### JavaScript ####
JavaScript goes in the in the `assets/js` folder. The grunt task will lint (that means, check your code quality
using jshint) and then uglify ( that means, make it really really tiny ) the JavaScript files in this
directory, with a few exceptions:

+   Files with the extension '.min.js' are assumed to be uglified already, and are ignored.
+   Files that begin with an underscore ('_') are assumed to be included in some other way and are ignored.
+   Any files in a **subdirectory** of `assets/js` are assumed to be included in some other way and are ignored.

#### SASS/CSS ####
Starter-Kit uses [SASS (.scss)](http://sass-lang.com/) and these files live in the in the `assets/css` folder.
The grunt task will compile the sass files, run [autoprefixer](https://github.com/nDmitry/grunt-autoprefixer),
and minifiy the resulting css file. Grunt will ignore:

+   Files with the extension '.css' - assumed to have already been processed.
+   Files that begin with an underscore ('_') are assumed to have been included using @import.
+   Any files in a **subdirectory** of `assets/css` are assumed to have been included using @import.

#### Images ####
The grunt task will minify all images placed in the `assets/img` folder using imagemin. Don't worry,
imagemin is smart enough to know what images have been previously minified.

#### The 'dev' Grunt Task ####
The default task, that is, just typing 'grunt' into the command line while in your plugin folder, will perform
all of the above actions.

However, the 'dev' ( that is, typing 'grunt dev' ) will start the watch task. This task will monitor the files in
your development directory, waiting for changes. So when you edit a JavaScript file in the `assets/js` folder
the dev task will see the change and run the appropriate tasks (jshint and uglify), even if that file is in a subfolder.
The same goes for the editing an .scss file or adding an image to the `assets/img` folder.

#### Grunt Gotchas ####
grunt creates a few temporary folders -- be sure to avoid uploading these to your server or including them in SVN
(if you add them to wordpress.org/plugins). These folders are:

+   `.sass-cache` - created when compiling sass
+   `.tmp` - created when running autoprefixer and cssmin
+   `node_modules` - contains code necessary to run grunt and grun tasks

## Future ##

I should mention that this is a living codebase -- I use this any time I'm building plugin. As a result,
the code changes frequently. I attempt to keep the code updated (mostly happens) as well as the documentation
(mostly doesn't happen). Feel free to submit issues, or browse the issues list to see what other features are planned.

Thanks for playing.





