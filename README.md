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
+   Template and option services live in the Feature class/subclasses.
+   Nearly all boilerplate has been moved into the Kit or Feature classes and out of the way.
+   Added Grunt support
	+   SASS, autoprefixer and cssmin for CSS
	+   JavaScript inspected JSHint and compressed with Uglify
	+   Images compressed with imagemin
	+   Default grunt task and watch task "dev"
	+   npm install from package.json

### Feature-based Development ###

I can't speak for other developers, but when I build a plugin I want to think about
what the plugin does, the features I plan to build. I want to use OOP. I want a clean separation of my PHP
logic and HTML views. I want to start a project running with everything I need &emdash; then I never want to see it,
much less think about it, again. That's what this framework is designed to provide.

With Starter-Kit, you build Features -- small classes that extend from the framework's "Feature"
class -- and drop them into one of three folders (admin, client, or core). These files are automatically loaded
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
2.  In your development tool of choice, do a global find-and-replace:
	+   Replace all instances of the "irresponsible_art\starter_kit" namespace to reflect your organization
	+   Replace all instances of "StarterKit" to your class name.
	+   Replace all instances of "starter_kit" with your plugin's slug -- this will replace things like the
		WP text-domain, options key, and a few other strings.

If you plan to use grunt in your project:

1.  In a console, navigate to your development directory and run "npm install".
2.  In that same console, run "grunt" to test your build
3.  When you're ready to work, run the "grunt dev" to start the watch task ( ctrl + C stops it ).

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

Your feature should then add actions or filters in the constructor and handle them in the body of the class.
The Feature class exposes three methods for making handling actions & filter methods.

<dl>
<dt><code>$this->marshal( $methodName )</code></dt>
<dd>Creates a <code>callable</code> array for the method corresponding to the string <code>$methodName</code>.</dd>

<dt><code>$this->add_action( $action, $method_name, $priority = 10, $accepted_args = 2 )</code></dt>
<dd>Marshaled version of [WordPress' add_action method](https://codex.wordpress.org/Function_Reference/add_action)</dd>

<dt><code>$this->add_filter( $action, $method_name, $priority = 10, $accepted_args = 2 )</code></dt>
<dd>Marshaled version of [WordPress' add_filter method](https://codex.wordpress.org/Function_Reference/add_filter)</dd>
</dl>

