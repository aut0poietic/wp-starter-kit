# Starter-Kit #
## WordPress Plugin Foundation ##

**Starter-Kit** is a development template for rapidly building WordPress plugins.
The framework provides some useful services and a clean way to structure your plugin while allowing you to build
libraries of small functional components.

### Okay. Great.  Why do I want to use a framework? ###

WordPress plugins are an awesome way of adding functionality to your client's WordPress sites. They promise
nice, easily installable nuggets of functionality that you can keep from site to site and even use
to create "value-add" services in your shop -- like adding client branding to the admin, events calendars
or whatever the client can dream up.

The downside is that clients are rarely happy with the catch-all plugin you've built or the one
you built for your last client. Adding option pages are are a wonderful feature, but capturing all the
options *every* client might ever want can take time and can rapidly bloat a plugin.
Adding your own action hooks is a start, but takes some consideration, slowing down your development
effort and when you're trying to hit that outrageous deadline never end up portable to the next project.

Multiple, tiny, one-shot plugins can fill these gaps but personally, I hate having a
massive list of installed plugins and having to explain them to an intimidated client.

### My Solution: Starter-Kit Drop-Ins ###

The Kit allows you to add individual files to your WordPress plugin called "Drop-Ins". These files encapsulate
a single piece of functionality. Do you often re-brand the WordPress login screen with your logo and URL?
Create a drop-in file with that code and move it from project to project. Have a few custom post types that always
seem to need? Create a drop-in for each type.

Drop-ins can be as simple as a function and an add_action call, a Widget class and it's registration, a static
class with your custom methods or a class file that assembles multiple pieces of functionality.

Making the drop-ins as simple as possible is the key: It's easy to combine multiple drop-ins within your plugin
that collectively create very complex behaviors. You can move each drop-in from project to project and when you need
to customize, create a drop-in for the custom work.

### Other Features ###
Drop-ins can be pretty nice for making portable code, but there's more to Starter-Kit to make your life easier:

* Templates: A simple template framework for separating your rendering from your PHP logic.
* OOP: A base DropIn class makes working with WordPress actions, filters and AJAX a snap.
Drop-ins that inherit from the base can be made to auto-instantiate and register themselves.
* Options: Centralized WordPress Options handling with defaults and a system for handling new options during plugin upgrades.
* Starter Language files: A `master.po' file already set for your plugin. Just open with PoEdit and click update.

## Getting Started with Starter-Kit ##

Starter-Kit is a template that you customize a few pieces and start working.
1. Download starter kit and rename the 'kit' directory and 'starter-kit.php' to the name of your plugin.
2. Copy this folder to the plugins directory of on your development environment.
3. In your development tool of choice, do a global find-and-replace, changing 'starter_kit' and with the name
   of your plugin; This will become the name of your plugin's class, so PHP Class naming rules apply. You want
   this to be globally unique, so be creative.
4. Start building the next must-have plugin!

When you globally change 'starter_kit', you're changing:
* The main class name
* The textdomain for the plugin
* All class and constant prefixes so your classes don't collide.

### Creating a Simple Drop-In ###

Like we said earlier, drop in's can be as simple as a single function and an action.

Say for instance you wanted to create a drop-in for re-branding the WordPress Login screen to use your logo.
Create a new file in the `client` folder named 'branding.php' and add the code.

```php
function myplugin_rebrand_logo() {
	echo '<style type="text/css">
	h1 a { background-image: url(http://yourwebsite.com/wp-content/uploads/yourimage.jpg) !important; }
	</style>';
}
add_action( 'login_head' , 'myplugin_rebrand_logo' ) ;
```

Starter-Kit will find your file and apply the action.

### Creating an Object Oriented Drop-In ###

Simple drop-ins are all well and good, but Starter-Kit was built to work with classes and adds a few
methods to make working with classes in WordPress a little less confusing.

To start using the methods, create Drop-In class that inherits from the DropIn base class. Assume you renamed
starter_kit to 'xyzPlugin' and you wanted to build the re-branding piece above as a class:

```php
class xyzPlugin_Branding extends xyzPlugin_DropIn {

	public function init( $callable = array( ) ){
		if( is_callable( $callable ) && method_exists( $callable[ 0 ] , $callable[ 1 ] ) ){
			call_user_func_array( $callable , array( new self ) ) ;
		}
	}

	public function __construct( ){
		$this->add_action( 'login_head' , 'rebrand_logo' ) ;
	}

	public function rebrand_logo() {
		echo '<style type="text/css">
    	h1 a { background-image: url(http://yourwebsite.com/wp-content/uploads/yourimage.jpg) !important; }
    	</style>';
	}
} // END CLASS

// Subscribe to the drop-in to the initialization event
add_action( 'xyzPlugin_init' , array( 'xyzPlugin_Branding' , 'init'  ) ) ;
```

In the OOP version we add the action in the constructor which runs on the WordPress `plugins_loaded` action hook
and use `$this->add_action( )` instead of WordPress' `add_action`. Using `$this` "array-wraps" the method ( creating
a callable in PHP lingo ) so WordPress can find and call your method. There's also a $this->add_filter() method
as well -- both of which use the same parameter as the built-in WordPress methods.

The new code here contains a bit of boilerplate:
* The static init function creates the instance of the class.
* The add_action call on the last line of the drop-in file subscribes the class to the
initialization action generated by the plugin. Supply the name of your class as the first parameter of the array.

### Using the Template System ###

Starter-Kit includes a simple template system for helping you separate your rendering from your logic.
Sticking with the rebranding drop-in, we can create a template file that outputs the style tag:

```php
<style type="text/css">
	h1 a { background-image: url(<?php echo $url ; ?>) !important; }
</style>
```
and save that file as `login-icon-style.php` in the `__inc/templates/` folder. Now we can rebuild our Branding class:

```php
class xyzPlugin_Branding extends xyzPlugin_DropIn {

	public function init( $callable = array( ) ){
		if( is_callable( $callable ) && method_exists( $callable[ 0 ] , $callable[ 1 ] ) ){
			call_user_func_array( $callable , array( new self ) ) ;
		}
	}

	public function __construct( ){
		$this->add_action( 'login_head' , 'rebrand_logo' ) ;
	}

	public function rebrand_logo() {
		xyzPlugin::template->set( 'url' , 'http://yourwebsite.com/wp-content/uploads/yourimage.jpg' ) ;
		echo xyzPlugin::template->apply( 'login-icon-style.php' ) ;
	}
} // END CLASS

// Subscribe to the drop-in to the initialization event
add_action( 'xyzPlugin_init' , array( 'xyzPlugin_Branding' , 'init'  ) ) ;
```

### Options Handling ###

Our Branding drop-in is taking shape, but that static URL is a problem. Wouldn't it be better
to add this to the WordPress options for the plugin?

```php
class xyzPlugin_Branding extends xyzPlugin_DropIn {

	public function init( $callable = array( ) ){
		if( is_callable( $callable ) && method_exists( $callable[ 0 ] , $callable[ 1 ] ) ){
			call_user_func_array( $callable , array( new self ) ) ;
		}
	}

	public function __construct( ){
		$this->add_action( 'login_head' , 'rebrand_logo' ) ;
	}

	public function rebrand_logo() {
		xyzPlugin::template->set( 'url' , xyzPlugin::get_option( 'logo_url' , 'http://yourwebsite.com/wp-content/uploads/yourimage.jpg' ) ;
		echo xyzPlugin::template->apply( 'login-icon-style.php' ) ;
	}
} // END CLASS

// Subscribe to the drop-in to the initialization event
add_action( 'xyzPlugin_init' , array( 'xyzPlugin_Branding' , 'init'  ) ) ;
```

The static get_option method will attempt to fetch the option stored with the key 'logo_url' and return it.
If the value doesn't exist, it returns the second parameter.

#### Default Options ####

The main Starter-Kit class file contains a private method `defaults` that when you start returns an empty array.
This method is called when your plugin is initialized and will add the array of options you specify to the
WordPress options for your plugin. In this way, you know the options are always populated initially.

For our Branding drop-in, we could add the default url:

```php
[...]
private static function defaults( )
{
	return array(
		'logo_url' => 'http://yourwebsite.com/wp-content/uploads/yourimage.jpg'
	) ;
}

[...]
```

It's good practice, but there's an additional benefit to using this structure.

Say the next version of this plugin adds the ability to set the title element of the logo as well and you're
storing the title text in your options as well.

```php
[...]
private static function defaults( )
{
	return array(
		'logo_url'      => 'http://yourwebsite.com/wp-content/uploads/yourimage.jpg' ,
		'logo_title'    => 'My Awesome Company'
	) ;
}

[...]
```

By adding this entry to the defaults, Starter-Kit will be sure to sync the keys and values in
the returned by the `defaults` method with the existing plugins options, preserving the values
in stored by WordPress if they exist.

### AJAX Methods ####


