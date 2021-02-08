=== Plugin Name === 

Contributors: Xristopher Anderton

Tags: categories, search, taxonomies 

Requires at least: 3.0.1

Tested up to: 3.4 Stable tag: 4.3 License: GPLv2 or later License URI: http://www.gnu.org/licenses/gpl-2.0.html

An example plugin for assigning a primary category to post types and including those in search results.

== Description ==

The use case scenario includes multiple custom taxonomies which may be applied to both built-in posts/pages as well as
custom post types. Tests will be performed with two new custom taxonomies, “genre” and “studio,” utilizing posts, pages,
and a new custom post type of “Review.”

The plugin will provide an interface for individually assigning a primary category for posts, pages, and custom post
types.

There is also a need to query for posts on the front-end based on the primary categories, which in WordPress people will
normally go for the search box first. With this in mind, the plugin will extend the search query to include results
matching the primary category term but only if the category is specified for that specific post type. Posts which share
the category and have the term will not show up unless that category is also set for that post type as well.
