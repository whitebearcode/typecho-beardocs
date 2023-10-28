<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<!DOCTYPE HTML>
<html>
<head>
     <meta charset="<?php $this->options->charset(); ?>">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="apple-touch-fullscreen" content="yes"/>
    <meta name="format-detection" content="email=no" />
    <meta name="wap-font-scale"  content="no" />
    <meta name="viewport" content="user-scalable=no, width=device-width" />
    <meta content="telephone=no" name="format-detection" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <?php if(!empty(General::Options('favicon'))): ?>
 <link rel="shortcut icon" href="<?php echo General::Options('favicon') ?>" />
 <?php endif; ?>
    <title><?php $this->archiveTitle([
            'category'  =>  _t('分类「%s」下的文章'),
            'search'    =>  _t('包含关键字「%s」的文章'),
            'tag'       =>  _t('标签「%s」下的文章'),
            'author'    =>  _t('作者「%s」的个人资料')
        ], '', ' - '); ?><?php $this->options->title(); ?></title>
    <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/beardocs.css?v='); ?><?php echo themeVersion();?>">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/plugins/fancybox/fancybox.min.css'); ?>">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/plugins/menutree/menutree.min.css'); ?>">
    <script src="<?php $this->options->themeUrl('assets/js/uikit.js'); ?>"></script>
    <?php $this->header('commentReply=1&description=&pingback=0&xmlrpc=0&wlw=0&generator=&template=&atom='); ?>
    <script>
        window.searchApi = "<?php echo General::apiRet('search');?>";
    </script>
    <?php echo General::Options('CustomizationCode'); ?>
</head>
<body>
<header class="uk-background-secondary uk-background-norepeat uk-background-cover uk-background-center-center uk-light" <?php if (General::Options('headerBackground')): ?>
	style="background-image: url(<?php echo General::Options('headerBackground'); ?>);"<?php endif; ?>>
	<nav class="uk-navbar-container">
	  <div class="uk-container">
	    <div data-uk-navbar>
	      <div class="uk-navbar-center">
	        <a class="uk-navbar-item uk-logo" href="<?php $this->options->siteUrl(); ?>"><?php if (General::Options('logoText')): ?><?php echo General::Options('logoText'); ?><?php else:?><?php echo $this->options->title;?><?php endif; ?></a>
	      </div>
	    </div>
	  </div>
	</nav>

<div class="uk-section uk-section-small uk-section-hero uk-position-relative" data-uk-scrollspy="cls: uk-animation-slide-bottom-medium; repeat: true">
		<div class="uk-container">
		    	<h1 class="uk-text-center uk-margin-remove-top"><?php if (General::Options('headerText')): ?><?php echo General::Options('headerText'); ?><?php else:?>有什么可以帮助到您的?<?php endif; ?></h1>
			<div class="hero-search uk-margin-bottom">
				<div class="uk-position-relative">
					<form class="uk-search uk-search-default uk-width-1-1" name="searchCompleteForm" onsubmit="return false;">
						<span data-uk-search-icon="ratio: 1.2"></span>
						<input id="searchComplete" spellcheck=false autocorrect="off" autocomplete="off"
				autocapitalize="off" maxlength="2048" tabindex="1" class="uk-search-input uk-form-large uk-border-rounded" type="search"
							placeholder="输入关键词进行搜索" autocomplete="off" data-minchars="1" data-maxitems="30">
					</form>
				</div>
			</div>
		</div>
	</div>
</header>