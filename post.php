<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>
<?php $this->widget('Widget_Metas_Category_List')->to($categorys);?>
<?php while ($categorys->next()): ?> <?php if ($this->category ==
$categorys->slug):?>
<?php $slug = $categorys->slug; ?>
<?php $slug_name = $categorys->title; ?>
<?php endif; ?>
<?php endwhile; ?>
<div class="uk-section uk-section-muted">
  <div class="uk-container">
    <div class="uk-background-default uk-border-rounded uk-box-shadow-small">
      <div class="uk-container uk-container-xsmall uk-padding-large">
          <aside id="aside"></aside>
     
        <article class="uk-article">
            <button class="uk-large-button uk-button" uk-toggle="target: #offcanvas-docs"  data-uk-toggle><span uk-icon="icon: chevron-double-left"></span>查看该分类其他文章</button>
          <h1 class="uk-article-title uk-article-title-ove"><?php $this->title() ?></h1>
          
           <div class="uk-article-meta uk-margin uk-flex uk-flex-middle">
          <img class="uk-border-circle uk-avatar-small" src="<?php echo General::getAvatar($this->author->mail); ?>" alt="">
          <div>
            由 <?php $this->author->screenName();?> 撰写<br>
            <time class="uk-margin-small-right" datetime="<?php $this->date('Y年m月d日 H:i:s'); ?>">发布于 <?php $this->date('Y年m月d日 H:i:s'); ?></time><br>
            最后修改于 <time datetime="<?php echo date('Y-m-d H:i:s' , $this->modified); ?>"><?php echo date('Y年m月d日 H:i:s' , $this->modified); ?></time>
          </div>
        </div>
        <div class="uk-article-content">
          <?php echo Parse::ParseContent($this->content); ?>
 

          </div>
          <div class="uk-margin-large-top paginate-post">
            <div class="uk-child-width-expand@s uk-grid-large" data-uk-grid>
              <div>
                <h5>上一篇</h5>
                <div><?php $this->thePrev('%s', '没有了', array('tagClass' => 'uk-remove-underline hvr-back'));?></div>
              </div>
              <div class="uk-text-right">
                <h5>下一篇</h5>
                <div><?php $this->theNext('%s', '没有了', array('tagClass' => 'uk-remove-underline hvr-back'));?></div>
              </div>
            </div>
          </div>
        </article>
      </div>
    </div>
  </div>
</div>



<div id="offcanvas-docs" data-uk-offcanvas="overlay: true">
  <div class="uk-offcanvas-bar">
    <button class="uk-offcanvas-close" type="button" data-uk-close></button>
    <h5 class="uk-margin-top"><span><?php $this->category('</span><span style="display:none">',false); ?></span></h5>
    <ul class="uk-nav uk-nav-default doc-nav" style="white-space: nowrap; overflow: hidden;">
        <?php $this->widget('Widget_Archive@index', 'pageSize=999&type=category', 'mid='.General::getCategoryId($slug))->to($cateArticle); ?>
        <?php while ($cateArticle->next()): ?>
        <?php if($cateArticle->cid !== $this->cid):?>
        <li><a href="<?php echo $cateArticle->permalink;?>"><?php echo $cateArticle->title;?></a></li>
        <?php endif; ?>
        <?php endwhile; ?>
    </ul>
   
  </div>
</div>

<?php $this->need('footer.php'); ?>
