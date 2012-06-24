<?php
/**
 * ECP netfile: 在知识库中使用ECP网柜文件。
 */
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
if (!defined('DOKU_PLUGIN_NETFILE')) define('DOKU_PLUGIN_NETFILE',DOKU_PLUGIN.'netfile/');
require_once (DOKU_PLUGIN.'syntax.php');
require_once(GAF_DIR.'/lib/debug.php');
//require_once (DOKU_PLUGIN_NETFILE.'api/barcode.inc');
class syntax_plugin_netfile extends DokuWiki_Syntax_Plugin {
	function getType() { return 'substition'; }
	function getPType() { return 'normal'; }
	function getSort() { return 310; } /* 必须小于320：标准的/\{\{[^\}]+\}\}/模式*/
	
	function connectTo($mode) { 
		$this->Lexer->addSpecialPattern('\{\{netfile://[^\}]+\}\}', $mode, 'plugin_netfile'); 
	}
	
	function handle($match, $state, $pos, &$handler) {
		global $conf;
		global $ID;
		
		return $match;
		return $out;
	}
	
	/**
	 * Create output
	 */
	function render($mode, &$renderer, $data) {
		global $conf;
		if ($mode == 'xhtml') {
			list($file,$title,$oper) = explode('|',substr($data,11,strlen($data)-13));
		
			$file=trim($file);
			if (empty($title)) $title=$file;
			else $title=trim($title);
		
			switch(strtolower(trim($oper))) {
				case 'download':
				default:
					$farr=explode('.',$file);
					if (count($farr)<=1) $ext='';
					else $ext=strtolower($farr[count($farr)-1]);
					
					//if ($ext=='' || empty($this->icons[$ext])) $icon='/gaf/img/filetype/folder.gif';
					//else $icon=$this->icons[$ext];
					//$out="<img style='vertical-align:middle;padding-right:2px' src='$icon'>";
					//$out.="<a href='/netfile/index/downfile?f=".urlencode($file)."'>$title</a>";
					
					$class = preg_replace('/[^_\-a-z0-9]+/i','_',$ext);
					$out.="<a class='media mediafile mf_$class wikilink' href='/netfile/index/downfile?f=".urlencode($file)."'>$title</a>";
					break;
			}		
			$renderer->doc .= $out;
		}
		return false;
	}
}
?>
