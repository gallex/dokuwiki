<?php
/**
 * Plugin page index: index table for pages in a name space
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Kite <Kite@puzzlers.org>
 * @based_on   "externallink" plugin by Otto Vainio <plugins@valjakko.net>
 */
 
if(!defined('DOKU_INC')) {
	define('DOKU_INC',realpath(dirname(__FILE__).'/../../').'/');
}
if(!defined('DOKU_PLUGIN')) {
	define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
}

require_once(DOKU_PLUGIN.'syntax.php');
require_once(DOKU_INC.'inc/search.php');

function search_list_index(&$data,$base,$file,$type,$lvl,$opts){
	global $ID;
	//we do nothing with directories
	if($type == 'd') {
		$data[] = array( 
			'id'    => $opts['ns'].urldecode(str_replace(DIRECTORY_SEPARATOR,':',$file)).':start',
			'type'  => 'f',
			'level' => $lvl 
		);
		return false; /*return true 实现递归调用*/
	}	
	if(preg_match('#\.txt$#',$file)){
		//check ACL
		$id = pathID($file);
		//if(auth_quickaclcheck($id) < AUTH_READ){
		//	return false;
		//}
		if($opts['ns'].":$id" <> $ID) {
			$data[] = array( 
				'id'    => $opts['ns'].":$id",
				'type'  => $type,
				'level' => $lvl 
			);
		}
	}
	return false;
}

/**
 * All DokuWiki plugins to extend the parser/rendering mechanism
 * need to inherit from this class
 */
class syntax_plugin_pageindex extends DokuWiki_Syntax_Plugin {
 
	/**
	 * return some info
	 */
	function getInfo(){
	  return array(
		   'author' => 'Kite',
		   'email'  => 'kite@puzzlers.org',
		   'date'   => '2009-02-01',
		   'name'   => 'Page Index',
		   'desc'   => 'Presents an index list of files in the current namespace',
		   'url'    => 'http://www.dokuwiki.org/plugin:pageindex',
	  );
	}

	/**
	 * What kind of syntax are we?
	 */
	function getType(){
	  return 'substition';
	}

	// Just before build in links
	function getSort(){ return 299; }

	/**
	 * What about paragraphs?
	 */
	function getPType(){
	  return 'block';
	}

	function connectTo($mode) {
		$this->Lexer->addSpecialPattern('~~PAGEINDEX[^~]*~~',$mode,'plugin_pageindex');
	}

	/**
	 * Handle the match
	 */
	function handle($match, $state, $pos, &$handler){
		$match = preg_replace("%~~PAGEINDEX(=(.*))?~~%", "\\2", $match);
		return $match;
	}

	/**
	* Create output
	*/
	function render($mode, &$renderer, $data) {
	  if($mode == 'xhtml'){
		   $text=$this->_pageindex($renderer, $data);
		   $renderer->doc .= $text;
		   return true;
	  }
	  return false;
	}

	function _pageindex(&$renderer, $data) {
		global $conf;
		global $ID;
		$parameters = split(';', $data);
		$ns  = cleanID(getNS("$parameters[0]:dummy"));

		if(empty($ns)){
			$ns  = cleanID(getNS($ID));
			if($ns == '.') $ns ='';
		}

		$search_data = array();   // Oct 3, 2006 renamed $data to $search_data for clarity
		$dir = $conf['datadir']. DIRECTORY_SEPARATOR .utf8_encodeFN(str_replace(':',DIRECTORY_SEPARATOR,$ns));

		search(
			$search_data,          // results   == renamed $data to $search_data
			$dir,                  // folder root
			'search_list_index',   // handler
			array('ns' => $ns));   // options
				
		// Remove the items not wanted in the list
		if(is_array($parameters)) {
			$skipitems = array_slice($parameters, 1);
			foreach($search_data as $item) {
				$found = false;
				// Add ns if user didn't
				foreach($skipitems as $skip) {
					$skip = strpos($skip,":") ? $skip : "$ns:$skip"; 
					if($item['id'] == $skip) {
						 $found = true;
						 break;
					}
				}
				if(!$found) {
					// Pass this one through
					$checked[] = $item;
				} else {
					//$renderer->doc .= "<!-- rejected entry ".$item['id']." -->\n";
				}
			}
		}
		
		if(count($checked)) {  // use the filtered data rather than $search_data
			/* Option to use an HTML List */
			$renderer->doc .= html_buildlist($checked,
				'idx',
				'html_list_index',
				'html_li_index');
			
			/* Option to use the PageList plugin */
			/*$pages = $checked;
			$pagelist =& plugin_load('helper', 'pagelist');
			if (!$pagelist) return false; // failed to load plugin
			$pagelist->startList();
			foreach ($pages as $page){
				 $pagelist->addPage($page);
			}
			$renderer->doc .= $pagelist->finishList();
			*/
		} else {
			$renderer->doc .= "\n\t<p>本类别下暂时没有条目</p>\n";
		}
	} // _pageindex()
} // syntax_plugin_pageindex
