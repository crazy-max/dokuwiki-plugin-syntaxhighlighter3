<?php
/**
 * Options for the syntaxhighlighter3 plugin
 *
 * @author Daniel Lindgren <bd.dali@gmail.com>
 */
$meta['theme'] = array('multichoice','_choices' => array('shThemeDefault.css','shThemeEmacs.css','shThemeMidnight.css','shThemeDjango.css','shThemeFadeToGrey.css','shThemeRDark.css','shThemeEclipse.css','shThemeMDUltra.css'));
$meta['brushes'] = array('string');

// defaults
$meta['auto-links'] = array('onoff');
$meta['collapse'] = array('onoff');
$meta['first-line'] = array('numeric');
$meta['gutter'] = array('onoff');
$meta['html-script'] = array('onoff');
$meta['smart-tabs'] = array('onoff');
$meta['tab-size'] = array('numeric');
$meta['toolbar'] = array('onoff');
