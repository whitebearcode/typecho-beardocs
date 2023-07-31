<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

<footer class="uk-section uk-text-center uk-text-muted">
	<div class="uk-container uk-container-small">

		
		<div class="uk-margin-medium uk-text-small uk-link-muted"><?php _e('Powered by <a href="http://www.typecho.org">Typecho</a> & <a href="https://github.com/whitebearcode/typecho-bearhoney"> BearDocs</a>  '); ?><br>
     <?php if (General::Options('PoliceBa')): ?><img  src="<?php $this->options->themeUrl('assets/images/beian.png');?>"> <a href="http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=<?php echo General::parseNumber(General::Options('PoliceBa')); ?>"><?php echo General::Options('PoliceBa'); ?></a><?php endif; ?><?php if (General::Options('IcpBa') && General::Options('PoliceBa')): ?>  | <?php endif; ?><?php if (General::Options('IcpBa')): ?><a href="https://beian.miit.gov.cn/"><?php echo General::Options('IcpBa'); ?></a><?php endif; ?>
		</div>
		<?php echo General::Options('CustomizationFooterCode'); ?>	
	</div>
</footer>
<script src="<?php $this->options->themeUrl('assets/plugins/fancybox/fancybox.umd.min.js'); ?>"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
          Fancybox.bind('[data-fancybox="image"]', {
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
    });
</script>
<?php echo General::Options('CustomizationFooterJsCode'); ?>
<?php $this->footer(); ?>
<script src="<?php $this->options->themeUrl('assets/plugins/instant.page/instantpage.min.js'); ?>"></script>
</body>
</html>
