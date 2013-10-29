<?php
/**
 * DokuWiki Default Template
 *
 * This is the template you need to change for the overall look
 * of DokuWiki.
 *
 * You should leave the doctype at the very top - It should
 * always be the very first line of a document.
 *
 * @link   http://dokuwiki.org/templates
 * @author Andreas Gohr <andi@splitbrain.org>
 */

// must be run from within DokuWiki
if (!defined('DOKU_INC')) die();
global $ID;
global $ACT;
global $TEXT;
/*if ($ACT=='edit') {
	include(ECP_DIR.'/app/modules/wiki/doku/editor.phtml');
	die();
}*/	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $conf['lang']?>"
 lang="<?php echo $conf['lang']?>" dir="<?php echo $lang['direction']?>">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>
    <?php tpl_pagetitle()?>
    [<?php echo strip_tags($conf['title'])?>]
  </title>

  <?php tpl_metaheaders()?>
  <?php echo tpl_favicon(array('favicon', 'mobile')) ?>

  <?php /*old includehook*/ @include(dirname(__FILE__).'/meta.html')?>
  
	<script type="text/javascript">
	var ID='<?php echo $ID ?>';
	var NS='<?php echo getNS($ID); ?>';
	</script> 
</head>

<body>
<?php /*old includehook*/ @include(dirname(__FILE__).'/topheader.html')?>
<?php 
	/*if ($ACT=='preview') {
		echo "<div class='dokuwiki'>";
		html_show($TEXT); 
		echo "</div></body></html>";
		die(); 
	}*/
?>
<div class="dokuwiki">
  <?php html_msgarea()?>
  <div class="stylehead">
    <div class="bar" id="bar__top">
		<div id="dokuwiki__pagetools" class="bar-left">
		<ul>
			<li><a class="action btn_back" href="javascript:void(0)" onclick="history.go(-1)" title="返回前一个条目"></a></li>
			<li><a class="action btn_forward" href="javascript:void(0)" onclick="window.history.forward()" title="下一个"></a></li>
			<li><a class="action btn_max" href="javascript:void(0)" onclick="if (parent) parent.show_item(ID)" title="新标签中打开"></a></li>
			
			<li class='spliter'/></li>
			
			<?php 
				tpl_action('edit', 1, 'li', 0, '<span>', '</span>'); 
				tpl_action('revisions', 1, 'li', 0, '<span>', '</span>');
			?>
			
			<li class='spliter'/></li>
			
			<li><a class="action newitem" href="javascript:void(0)" onclick="parent.create_item(NS)" title="新建条目"></a></li>
			<li><a class="action classmng" href="javascript:void(0)" onclick="parent.mngclass(NS)" title="分类管理"></a></li>
			<li class='spliter'/></li>
			
			<li><span class='title-text'><?php echo $ID ?></span></li>
		</ul>
	</div> 

	<div class="bar-right" id="bar__topright">
		<?php tpl_button('recent')?>
		<?php tpl_searchform()?>&nbsp;
	</div>

	<div class="clearer"></div>
  </div>

    <?php if($conf['breadcrumbs']){?>
    <div class="breadcrumbs">
      <?php tpl_breadcrumbs()?>
      <?php //tpl_youarehere() //(some people prefer this)?>
    </div>
    <?php }?>

    <?php if($conf['youarehere']){?>
    <div class="breadcrumbs">
      <?php tpl_youarehere() ?>
    </div>
    <?php }?>

  </div>
  <?php tpl_flush()?>

  <?php /*old includehook*/ @include(dirname(__FILE__).'/pageheader.html')?>

  <div class="page">
    <!-- wikipage start -->
    <?php tpl_content()?>
    <!-- wikipage stop -->
  </div>

  <div class="clearer"></div>

  <?php tpl_flush()?>

  <div class="stylefoot">

    <div class="meta">
      <div class="user">
        <?php tpl_userinfo()?>
      </div>
      <div class="doc">
        <?php tpl_pageinfo()?>
      </div>
    </div>

</div>
<div class="no"><?php /* provide DokuWiki housekeeping, required in all templates */ tpl_indexerWebBug()?></div>
</body>
</html>
