<?php
/**
 * 一款Typecho文档类主题
 *
 * @package BearDocs
 * @author BearNotion
 * @version v1.1.3-release
 * @link https://www.bearnotion.ru/
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
    $this->need('header.php');
?>
<?php $this->widget('Widget_Metas_Category_List')->to($categorys); ?>

<?php if (General::Options('categoryListStyle') == 'simple'): ?>
<div class="uk-section uk-section-muted">
	<div class="uk-container">
	     <?php if(!empty(trim(General::Options("announcementText")))):?>
         <div class="bdnewui_announcement" style="margin-bottom:40px">
            <div class="bdnewui_announcement-header">
                <div class="bdnewui_announcement-title">
                    <div class="icon">
                        <span uk-icon="icon: bell; ratio: 1.1"></span>
                    </div>
                    <span>公告</span>
                </div>
            </div>
            
            <div class="bdnewui_announcement-content">
                <p><?php echo General::Options("announcementText");?></p>
            </div>
            
            
        </div>
        <?php endif;?>
    		<div class="uk-grid-medium uk-flex-middle uk-child-width-<?php echo General::getColumnNumber(General::Options('categoryShowColumnMiddle'));?>@m uk-child-width-<?php echo General::getColumnNumber(General::Options('categoryShowColumnLarge'));?>@l uk-grid-match" data-uk-grid>
		    
		    <?php while($categorys->next()): ?>
		    <?php if ($categorys->levels === 0): ?>
			<div>
				<div class="uk-card uk-card-default uk-card-hover uk-card-small uk-card-body uk-inline uk-border-rounded">
					<a class="uk-position-cover" href="<?php $categorys->permalink(); ?>"></a>
					<div class="uk-grid-medium" data-uk-grid>
						<div class="uk-width-auto uk-text-secondary uk-flex uk-flex-middle">
						    <span data-uk-icon="icon: <?php echo General::getCategoryDescriptionData($categorys->description)['icon']; ?>; ratio: 2.6"></span>
						</div>
						<div class="uk-width-expand">
							<h3 class="uk-card-title uk-margin-remove uk-text-secondary uk-category-name"><?php $categorys->name(); ?></h3>
							<p class="uk-text-muted uk-margin-remove uk-category-desc"><?php echo General::getCategoryDescriptionData($categorys->description)['desc']; ?></p>
						

						</div>
					</div>
				</div>
			</div>
			<?php endif; ?>
			<?php endwhile; ?>
			</div>
	</div>
</div>
<?php else:?>
<div class="uk-section uk-section-muted">
    <div class="uk-container">
        <?php if(!empty(trim(General::Options("announcementText")))):?>
         <div class="bdnewui_announcement">
            <div class="bdnewui_announcement-header">
                <div class="bdnewui_announcement-title">
                    <div class="icon">
                        <span uk-icon="icon: bell; ratio: 1.1"></span>
                    </div>
                    <span>公告</span>
                </div>
            </div>
            
            <div class="bdnewui_announcement-content">
                <p><?php echo General::Options("announcementText");?></p>
            </div>
            
            
        </div>
        <?php endif;?>
        
        
   
        <h2 class="bdnewui_index_section-title">帮助分类</h2>
        <div class="bdnewui_index_category-grid">
            <?php 
            while($categorys->next()): ?>
                <?php if ($categorys->levels === 0): ?>
                    <?php 
                    $currentMid = $categorys->mid;
                    ?>
                    <div class="bdnewui_index_category-item">
                        <div class="bdnewui_index_category-content">
                            <div class="bdnewui_index_item-header">
                                <div class="bdnewui_index_item-header-icon">
                                    <span uk-icon="icon: <?php echo General::getCategoryDescriptionData($categorys->description)['icon']; ?>; ratio: 1.8"></span>
                                </div>
                                <div class="bdnewui_index_item-header-content">
                                    <h3 class="bdnewui_index_category-name"><a href="<?php $categorys->permalink(); ?>"><?php $categorys->name(); ?></a></h3>
                                    <?php if(General::getCategoryDescriptionData($categorys->description)['desc'] !== ''):?>
                                    <span class="bdnewui_index_category-desc"><?php echo General::getCategoryDescriptionData($categorys->description)['desc']; ?></span>
                                    <?php endif;?>
                                    <span class="bdnewui_index_article-count"><?php $categorys->count();?>篇文章</span>
                                </div>
                            </div>

                            <div class="bdnewui_index_articles-panel">
                               
                                <?php echo General::getCategoryPosts($currentMid);?>
                                <a href="<?php $categorys->permalink(); ?>" class="bdnewui_index_view-all-btn">查看全部</a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endwhile; ?>
        </div>
    </div>
</div>
<?php endif;?>
    
    
<?php if (General::Options('commonProblem_module') == true): ?>
<div class="uk-section uk-section-muted">
	<div class="uk-container uk-container-small">
		<h2 class="uk-text-center">常见问题解答</h2>
		<ul class="uk-margin-medium-top" data-uk-accordion="multiple: true">
		    <?php foreach(General::Options('commonProblem') as $commonProblem):?>
			<li>
				<a class="uk-accordion-title uk-box-shadow-hover-small"><?php echo $commonProblem['commonProblem_title']; ?></a>
				<div class="uk-article-content uk-accordion-content link-secondary">
					<p><?php echo $commonProblem['commonProblem_answer']; ?></p>
				</div>
			</li>
	<?php endforeach;?>
		</ul>
	</div>
</div>

<?php endif; ?>

<?php if (General::Options('friendLinks_module') == true): ?>
<div class="uk-section uk-section-muted">
	<div class="uk-container uk-container-large">
		<h2 class="uk-text-center">友情链接</h2>
<div class="uk-grid-small uk-animation-fade uk-flex-middle uk-child-width-1-9 uk-child-width-1-2@m uk-child-width-1-3@l uk-grid-match uk-padding-small" uk-grid >
    <?php foreach(General::Options('friendLinks') as $friendLinks):?>
  <a href="<?php echo $friendLinks['friendLink_url']; ?>" target="_blank">
      
    <div class="uk-card uk-card-default uk-card-hover">
      <div class="uk-card-header">
        <div class="uk-grid-small uk-flex-middle" uk-grid>
          <div class="uk-width-auto">
            <img width="60" height="60" src="<?php echo $friendLinks['friendLink_logo']; ?>" loading="lazy">
          </div>
          <div class="uk-width-expand">
            <h3 class="uk-card-title uk-margin-remove-bottom"><?php echo $friendLinks['friendLink_title']; ?></h3>
            <p class="uk-text uk-margin-remove"><?php echo $friendLinks['friendLink_desc']; ?></p>
          </div>
        </div>
        
      </div>
    </div>
    
  </a>
  <?php endforeach; ?>
  </div>
    
   </div></div> 
      

<?php endif; ?>
<?php $this->need('footer.php'); ?>