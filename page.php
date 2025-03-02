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
            
              <button class="uk-button uk-button-primary uk-margin-small-right" type="button" uk-toggle="target: #menus" id="menuBtn" style="display:none"><span uk-icon="icon: menu"></span> 目录导航</button>

<div id="menus" uk-offcanvas="overlay: true">
    <div class="uk-offcanvas-bar uk-flex uk-flex-column">
<div class="menusx"></div>
       

    </div>
</div>


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
<?php if(General::Options('hiddenComment') == '' || General::Options('hiddenComment') == false):?>
<div class="uk-section uk-section-muted">
  <div class="uk-container">
    <div class="uk-background-default uk-border-rounded uk-box-shadow-small">
<div class="uk-container uk-container-xsmall uk-padding-large">
            <?php $this->need('comments.php'); ?>
          
</div>
</div>
</div>
</div>
<?php endif;?>

<script>
$(function(){
    if($('.uk-article-content').has('h1,h2,h3,h4,h5,h6').length){
        $("#menuBtn").fadeIn();
    }
    //目录树
    const defaults = Outline.DEFAULTS
    let outline
    defaults.title =  '文档目录', 
    defaults.selector = 'h1,h2,h3,h4,h5,h6',
    defaults.position = 'sticky',
    defaults.showCode = false,
    defaults.parentElement = '.menusx',
    defaults.articleElement = '.uk-article-content',
    defaults.showNavModalFirst= false,
    defaults.reader = {
        title:document.getElementsByClassName("uk-article-title")[0],
        target:'.uk-article-content',
        allowSpeak:true
        },
    outline = new Outline(Outline.DEFAULTS)
const handler = function(attrs) {
  this.attr()
  $('img.lazyload')
  .visibility({
    type       : 'image',
    transition : 'fade in',
    duration   : 1000,
  });
 Fancybox.bind('[data-fancybox]', {
      groupAttr:false,
      Toolbar: {
    display: {
      left: ["infobar"],
      middle: [
        "zoomIn",
        "zoomOut",
        "toggle1to1",
        "rotateCCW",
        "rotateCW",
        "flipX",
        "flipY",
      ],
      right: ["slideshow", "thumbs", "close"],
    },
  },
  
  
});


}

outline.$on("enterReading", handler)
});
</script>

<?php $this->need('footer.php'); ?>
