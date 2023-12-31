<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

<div class="uk-section uk-section-muted">
  <div class="uk-container">
    <ul class="uk-breadcrumb uk-margin-medium-top-">
      <li><a href="<?php $this->options->siteUrl(); ?>">首页</a></li>
      <li><span><?php $this->title() ?></span></li>
    </ul>      
    <div class="uk-background-default uk-border-rounded uk-box-shadow-small">
      <div class="uk-container uk-container-xsmall uk-padding-large">
        <article class="uk-article">
          <h1 class="uk-article-title"><?php $this->title() ?></h1>
          
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
          
        </article>
      </div>
    </div>
  </div>
</div>

<?php $this->need('footer.php'); ?>
