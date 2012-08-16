# Starter-Kit #
## WordPress Plugin Foundation ##

**Starter-Kit** is a plugin development template for rapidly building WordPress plugins.
The framework provides some useful services and a clean way to structure your plugin while allowing you to build
libraries of small functional componts .

### Okay. Great.  Why do I want to use a framework? ###

WordPress plugins are an awesome way of adding functionality to your client's WordPress sites. They promise
nice, easily installable nuggets of functionality that you can keep from site to site and even use
to create "value-add" services in your shop -- like adding client branding to the admin, events calendars
or whatever the client can dream up.

The downside is that clients are rarely happy with the catch-all plugin you've built or the one
you built for your last client. Adding option pages are are a wonderful feature, but capturing all the
options *any* client might ever want can take time and can rapidly bloat a plugin.
Adding your own action hooks is a start, but can quickly slow down your development effort and are rarely portable
in the end.

You can create multiple tiny plugins but, personally, I hate having a massive list of installed plugins.

### Starter-Kit Drop-Ins ###

The Kit allows you to add individual files to your WordPress plugin called "Drop-Ins". These files encapsulate
a single piece of functionality. Do you often re-brand the WordPress login screen with your logo and URL?
Create a drop-in file with that code and move it from project to project. Have a few custom post types that always
seem to need? Create a drop-in for each type.

Drop-ins can be as simple as a function and an add_action call, a Widget class and it's registration, a static
class with your custom methods or a class file that assembles multiple pieces of functionality.

The framework provides three folders in the root of the plugin: 'core', 'admin' and 'client'.
Add your core files, like post types or shared code to 'core' folder, add things like shortcodes an UI rendering
code to the 'client' folder, and add drop-ins for administration pages and such to the 'admin' folder.  Starter-Kit
will load the functionality for each context, making your plugin faster.

Making the drop-ins as simple as possible is the key: It's easy to combine multiple drop-ins within your plugin
that collectively create very complex behaviors. You can move each drop-in from project to project and seperate your
customization from the base drop-in.

### Object Oriented WordPress ###
All this Drop-in stuff is great, but Stater-Kit was started off as a way to make building Object Oriented Plugins
simpler. If you want to work with classes, create your drop-ins so that they inherit from the 'DropIn' base class.

The base DropIn class contains methods for adding actions and filters and ajax methods without worrying about
dealing with PHP's callable syntax; just add your actions using $this->add_action() or $this->add_filter() as you
would in a non-object way. The DropIn class will marshall your callable for you. You can also call $this->marshall()
directly for situations where you need to add actions, like when supplying the callback for an add_metabox().

If you don't mind a little boilerplate code, you can add 4 lines of code to the drop-in and the class will
instantiate and register itself.

