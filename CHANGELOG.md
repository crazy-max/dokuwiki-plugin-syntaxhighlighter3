# Changelog

## 2016/12/08

* Add ANT build tools
* Add StyleCI and Codacy

## 2016/06/19

* Update to Syntaxhighlighter 3.0.90
* New brushes: Haxe, TAP, TypeScript

## 2016/06/18

* Defaults configuration can be overrided in the Config Manager (Issue #11)
* Add documentation from plugin page

## 2016/06/13

* Hide box shadow (Issue #1)
* Add build bash script
* Add archives releases

## 2016/06/12

* Allow ranges for highlight parameter
* Add screenshots
* Add .editorconfig
* Update README and several infos
* Add build tools
* Extract content of plugin in the repository
* Fork of Daniel Lindgren's syntaxhighlighter3 plugin

## 2013/08/07

> Release available in `archives` folder.

* Fixed problem with the option html-script, always load shBrushXml.js to make it work.
* Convert brush aliases and options to lowercase, SyntaxHighlighter is case sensitive.

## 2011/06/07

> Release available in `archives` folder.

* Plugin adapted to [current plugin layout](https://www.dokuwiki.org/devel:plugin_file_structure).
* Uses Autoloader instead of always loading all brushes on all pages.
* Uses [Config Manager](https://www.dokuwiki.org/plugin:config) to select theme and configure Autoloader brush list. No longer necessary to edit action.php, i.e. plugin updates will not overwrite extra brushes.
* Add support for block title attribute.
