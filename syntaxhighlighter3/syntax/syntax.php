<?php
/**
* DokuWiki Plugin syntaxhighlighter3 (Syntax Component)
*
* @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
* @author  Daniel Lindgren <bd.dali@gmail.com>, based on syntaxhighlighter plugin by David Shin.
*/

// must be run within Dokuwiki
if (!defined('DOKU_INC')) die();

if (!defined('DOKU_LF')) define('DOKU_LF', "\n");
if (!defined('DOKU_TAB')) define('DOKU_TAB', "\t");
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');

require_once DOKU_PLUGIN.'syntax.php';

class syntax_plugin_syntaxhighlighter3_syntax extends DokuWiki_Syntax_Plugin {

    public function getType() {
        return 'protected';
    }

    public function getPType() {
        return 'block';
    }

    public function getSort() {
        return 195;
    }

    public function connectTo($mode) {
        $this->Lexer->addEntryPattern('<sxh(?=[^\r\n]*?>.*?</sxh>)',$mode,'plugin_syntaxhighlighter3_syntax');
    }

    public function postConnect() {
        $this->Lexer->addExitPattern('</sxh>','plugin_syntaxhighlighter3_syntax');
    }

    public function handle($match, $state, $pos, &$handler){

        switch ($state) {
        case DOKU_LEXER_ENTER:
            $this->syntax = substr($match, 1);
            return false;

        case DOKU_LEXER_UNMATCHED:
            // will include everything from <sxh ... to ... </sxh>
            list($attr, $content) = preg_split('/>/u',$match,2);

            if ($this->syntax == 'sxh') {
                $attr = trim($attr);
                if ($attr == NULL) {
                    // No brush and no options, use "text" with default options.
                    $attr = 'text';
                } else if (substr($attr,0,1) == ";") {
                    // Options but no brush, add "text" brush.
                    $attr = 'text' . $attr;
                }
            } else {
                $attr = NULL;
            }

            return array($this->syntax, $attr, $content);
        }
        return false;

    }

    public function render($mode, &$renderer, $data) {

        if($mode != 'xhtml') return false;

        if (count($data) == 3) {
            list($syntax, $attr, $content) = $data;
            if ($syntax == 'sxh') {
                // Check if there's a title in the $attr string. Block title can't be passed along as a normal parameter to SyntaxHighlighter.
                if (preg_match("/title:/i", $attr)) {
                    // Extract title(s) from $attr string.
                    $attr_array = explode(";",$attr);
                    $title_array = preg_grep("/title:/i", $attr_array);
                    // Extract everything BUT title(s) from $attr string.
                    $not_title_array =  preg_grep("/title:/i", $attr_array, PREG_GREP_INVERT);
                    $attr = implode(";",$not_title_array);
                    // If there are multiple titles, use the last one.
                    $title = array_pop($title_array);
                    $title = preg_replace("/.*title:\s{0,}(.*)/i","$1",$title);
                    // Make sure that SyntaxHighlighter brush alias and options are lowercase.
                    $attr = strtolower($attr);
                    // Add title as an attribute to the <pre /> tag and pass the rest of $attr to SyntaxHighlighter.
                    $renderer->doc .= "<pre class=\"brush: ".$attr."\" title=\"".$title."\">".$renderer->_xmlEntities($content)."</pre>";
                } else {
                    // Make sure that SyntaxHighlighter brush alias and options are lowercase.
                    $attr = strtolower($attr);
                    // No title detected, pass all of $attr as parameter to SyntaxHighlighter.
                    $renderer->doc .= "<pre class=\"brush: ".$attr."\">".$renderer->_xmlEntities($content)."</pre>";
                }
            } else {
                $renderer->file($content);
            }
        }

        return true;
    }
}

// vim:ts=4:sw=4:et:
