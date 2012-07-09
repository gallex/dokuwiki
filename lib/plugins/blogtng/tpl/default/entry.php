<?php
/**
 * default entry template
 *
 * This template is used to display a single entry when the 'default'
 * blog was chosen from the dropdown on editing a page.
 *
 * It displays the entry and adds comments and navigational elements.
 */
?>
<div class="blogtng_entry">
    <div class="blogtng_postnavigation level1">
    <?php if ($link = $entry->tpl_previouslink('« @TITLE@', $entry->entry['page'], true)) { ?>
        <div class="blogtng_prevlink">
            <?php echo $link?>
        </div>
    <?php } ?>
    <?php if ($link = $entry->tpl_nextlink('@TITLE@ »', $entry->entry['page'], true)) { ?>
        <div class="blogtng_nextlink">
            <?php echo $link?>
        </div>
    <?php } ?>
    </div>
    <?php $entry->tpl_entry(false, false, false) ?>
    <div class="blogtng_footer level1">
        日志创建时间: <?php $entry->tpl_created('%Y-%m-%d %H:%M')?>
        <?php if ($entry->entry['created'] != $entry->entry['lastmod']) {?>
            最后修改时间: <?php $entry->tpl_lastmodified('%Y-%m-%d %H:%M')?>
        <?php }?>
        编辑: 
        <?php $entry->tpl_author()?>.
        <?php if ($entry->has_tags()):?>
            标签: <?php $entry->tpl_tags('')?>.
        <?php endif ?>
    </div>
    <?php if ($entry->entry['commentstatus'] != 'disabled') {?>
        <h2 id="the__comments">Comments</h2>
        <div class="level2">
            <?php $entry->tpl_comments('default') ?>
            <?php $entry->tpl_commentform() ?>
        </div>
    <?php } ?>
</div>
