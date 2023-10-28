<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<footer class="uk-section-small uk-text-center uk-text-muted">
	<div class="uk-container">

		
		<div class="uk-margin-medium uk-text-small uk-link-primary">&copy; <?php echo date("Y");?> <a href="<?php $this->options->siteUrl();?>"><?php $this->options->title();?></a> All right Reserved.  <br><?php _e('Powered by <a href="http://www.typecho.org">Typecho</a> & <a href="https://github.com/whitebearcode/typecho-bearhoney"> BearDocs</a>  '); ?><br>
     <?php if (General::Options('PoliceBa')): ?><img  src="<?php $this->options->themeUrl('assets/images/beian.png');?>"> <a href="http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=<?php echo General::parseNumber(General::Options('PoliceBa')); ?>"><?php echo General::Options('PoliceBa'); ?></a><?php endif; ?><?php if (General::Options('IcpBa') && General::Options('PoliceBa')): ?>  | <?php endif; ?><?php if (General::Options('IcpBa')): ?><a href="https://beian.miit.gov.cn/"><?php echo General::Options('IcpBa'); ?></a><?php endif; ?>
		</div>
		<?php echo General::Options('CustomizationFooterCode'); ?>	
	</div>
</footer>
<script src="<?php $this->options->themeUrl('assets/plugins/fancybox/fancybox.umd.min.js'); ?>"></script>
<script src="//cdn.staticfile.org/tarekraafat-autocomplete.js/10.2.7/autoComplete.min.js"></script>
<script src="<?php $this->options->themeUrl('assets/plugins/menutree/menutree.min.js?v='); ?><?php echo themeVersion();?>"></script>
<script src="<?php $this->options->themeUrl('assets/js/beardocs.js?v='); ?><?php echo themeVersion();?>"></script>
<?php echo General::Options('CustomizationFooterJsCode'); ?>
<?php $this->footer(); ?>
<script src="<?php $this->options->themeUrl('assets/plugins/instant.page/instantpage.min.js'); ?>"></script>
</body>
</html>
