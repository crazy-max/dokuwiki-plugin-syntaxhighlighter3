<?php
/**
* DokuWiki Plugin syntaxhighlighter3 (Action Component)
*
* @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
* @author  Daniel Lindgren <bd.dali@gmail.com>, based on syntaxhighlighter plugin by David Shin.
*/

// must be run within Dokuwiki
if (!defined('DOKU_INC')) die();

if (!defined('DOKU_LF')) define('DOKU_LF', "\n");
if (!defined('DOKU_TAB')) define('DOKU_TAB', "\t");
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');

require_once DOKU_PLUGIN.'action.php';

class action_plugin_syntaxhighlighter3_action extends DokuWiki_Action_Plugin {

    public function register(Doku_Event_Handler &$controller) {
        $controller->register_hook('TPL_METAHEADER_OUTPUT', 'BEFORE', $this, '_hooksh');
        $controller->register_hook('TPL_ACT_RENDER', 'AFTER', $this, '_hookjsprocessing');
    }

    public function _hooksh(Doku_Event &$event, $param) {
        // Add SyntaxHighlighter stylesheets. At least two, shCore.css and a theme.
        $event->data['link'][] = array( 'rel'   => 'stylesheet',
            'type'  => 'text/css',
            'href'  => DOKU_BASE.'lib/plugins/syntaxhighlighter3/sxh3/styles/shCore.css',
            );
        $event->data['link'][] = array( 'rel'   => 'stylesheet',
            'type'  => 'text/css',
            'href'  => DOKU_BASE.'lib/plugins/syntaxhighlighter3/sxh3/styles/'.$this->getConf('theme'),
            );

        // Register core brush and autoloader.
        $event->data["script"][] = array ("type"   => "text/javascript",
            "src"   => DOKU_BASE."lib/plugins/syntaxhighlighter3/sxh3/scripts/shCore.js",
            "_data" => ""
            );
        $event->data["script"][] = array ("type"   => "text/javascript",
            "src"   => DOKU_BASE."lib/plugins/syntaxhighlighter3/sxh3/scripts/shAutoloader.js",
            "_data" => ""
            );
        // Always load XML brush, needed for the option html-script.
        $event->data["script"][] = array ("type"   => "text/javascript",
            "src"   => DOKU_BASE."lib/plugins/syntaxhighlighter3/sxh3/scripts/shBrushXml.js",
            "_data" => ""
            );

    }

    public function _hookjsprocessing(Doku_Event &$event, $param) {

        global $ID;
        global $INFO;

        //this ensures that code will be written only on base page
        //not on other inlined wiki pages (e.g. when using monobook template)
        if ($ID != $INFO["id"]) return;

        ptln("");
        ptln("<script type='text/javascript'>");
        ptln("  SyntaxHighlighter.autoloader(");

        // Get brushes.
        $brushes = $this->getConf('brushes');
        $brushes_split = explode(',', $brushes);
        $lastbrush = array_pop($brushes_split);
        foreach ($brushes_split as $brush) {
            //ptln("<! DEBUG: ".$brush.">");
            $brush_split = explode(' ', $brush);
            $brush_script = array_pop($brush_split);
            $brush_alias = strtolower(implode(' ', $brush_split));
            ptln("    '".$brush_alias." ".DOKU_BASE."lib/plugins/syntaxhighlighter3/sxh3/scripts/".$brush_script."',");
        }

        // Last brush, no comma at the end of the line.
        $brush_split = explode(' ', $lastbrush);
        $brush_script = array_pop($brush_split);
        $brush_alias = strtolower(implode(' ', $brush_split));
        ptln("    '".$brush_alias." ".DOKU_BASE."lib/plugins/syntaxhighlighter3/sxh3/scripts/".$brush_script."'");
        ptln("  );");
        ptln("  SyntaxHighlighter.defaults['auto-links'] = " . ($this->getConf('auto-links') == 1 ? 'true' : 'false') . ";");
        ptln("  SyntaxHighlighter.defaults['collapse'] = " . ($this->getConf('collapse') == 1 ? 'true' : 'false') . ";");
        $firstLine = $this->getConf('first-line');
        if ($firstLine > 0) {
            ptln("  SyntaxHighlighter.defaults['first-line'] = " . $this->getConf('first-line') . ";");
        }
        ptln("  SyntaxHighlighter.defaults['gutter'] = " . ($this->getConf('gutter') == 1 ? 'true' : 'false') . ";");
        ptln("  SyntaxHighlighter.defaults['html-script'] = " . ($this->getConf('html-script') == 1 ? 'true' : 'false') . ";");
        ptln("  SyntaxHighlighter.defaults['smart-tabs'] = " . ($this->getConf('smart-tabs') == 1 ? 'true' : 'false') . ";");
        $tabSize = $this->getConf('tab-size');
        if ($tabSize > 0) {
            ptln("  SyntaxHighlighter.defaults['tab-size'] = " . $this->getConf('tab-size') . ";");
        }
        ptln("  SyntaxHighlighter.defaults['toolbar'] = " . ($this->getConf('toolbar') == 1 ? 'true' : 'false') . ";");
        ptln("  SyntaxHighlighter.all();");
        ptln("</script>");
    }

}

// vim:ts=4:sw=4:et:
