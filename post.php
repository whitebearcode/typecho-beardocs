<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>
<?php $this->widget('Widget_Metas_Category_List')->to($categorys);?>
<?php while ($categorys->next()): ?> <?php if ($this->category ==
$categorys->slug):?>
<?php $slug = $categorys->slug; ?>
<?php $slug_name = $categorys->title; ?>
<?php endif; ?>
<?php endwhile; ?>

<?php $this->widget('Widget_Archive@index', 'pageSize=999&type=category', 'mid='.General::getCategoryId($slug))->to($cateArticle); ?>

<div class="uk-section uk-section-muted">
  <div class="uk-container">
    <div class="uk-background-default uk-border-rounded uk-box-shadow-small">
      <div class="uk-container uk-container-xsmall uk-padding-large">
          <aside id="aside"></aside>
     
        <article class="uk-article">
    
            <button class="uk-button uk-button-primary" uk-toggle="target: #offcanvas-docs"  data-uk-toggle><span uk-icon="icon: chevron-double-left"></span> 更多文档</button>
            <button class="uk-button uk-button-primary uk-margin-small-right" type="button" uk-toggle="target: #menus" id="menuBtn" style="display:none" style="margin-top:5px"><span uk-icon="icon: menu"></span> 目录导航</button>

<div id="menus" uk-offcanvas="overlay: true">
    <div class="uk-offcanvas-bar uk-flex uk-flex-column">
<div class="menusx"></div>
       

    </div>
</div>


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
        
<?php if(General::Options('showTags') == true):?>
                      <?php echo General::getPostAllTags($this);?>
            <?php endif;?>
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
<div id="offcanvas-docs" data-uk-offcanvas="overlay: true">
  <div class="uk-offcanvas-bar">
    <button class="uk-offcanvas-close" type="button" data-uk-close></button>
    <h5 class="uk-margin-top"><span><?php $this->category('</span><span style="display:none">',false); ?></span></h5>
    <ul class="uk-nav uk-nav-default doc-nav" style="white-space: nowrap; overflow: hidden;" uk-dropnav>
        
        <?php while ($cateArticle->next()): ?>
        <?php if($cateArticle->cid !== $this->cid):?>
        <li><a href="<?php echo $cateArticle->permalink;?>"><?php echo $cateArticle->title;?></a></li>
        <?php endif; ?>
        <?php endwhile; ?>
     
    </ul>




  </div>
  

  
  
</div>

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