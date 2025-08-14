<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

<a href="#" id="gotop" uk-totop uk-scroll></a>

<footer class="uk-section-small uk-text-center uk-text-muted">
	<div class="uk-container">

		
		<div class="uk-margin-medium uk-text-small uk-link-primary">&copy; <?php echo date("Y");?> <a href="<?php $this->options->siteUrl();?>"><?php $this->options->title();?></a> All right Reserved.  <br><?php _e('Powered by <a href="http://www.typecho.org">Typecho</a> & <a href="https://github.com/whitebearcode/typecho-beardocs"> BearDocs</a>  '); ?><br>
     <?php if (General::Options('PoliceBa')): ?><img  src="<?php $this->options->themeUrl('assets/images/beian.png');?>"> <a href="http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=<?php echo General::parseNumber(General::Options('PoliceBa')); ?>"><?php echo General::Options('PoliceBa'); ?></a><?php endif; ?><?php if (General::Options('IcpBa') && General::Options('PoliceBa')): ?>  | <?php endif; ?><?php if (General::Options('IcpBa')): ?><a href="https://beian.miit.gov.cn/"><?php echo General::Options('IcpBa'); ?></a><?php endif; ?>
		</div>
		<?php echo General::Options('CustomizationFooterCode'); ?>	
	</div>
</footer>

<script type="text/javascript">
if (!window.prismLoaded) {
    window.prismLoaded = true;
    var script = document.createElement('script');
    script.src = '<?= $this->options->themeUrl ?>/assets/plugins/codehightlight/prism.js';
    script.onload = initPrism;
    document.head.appendChild(script);
} else if (window.Prism) {
    initPrism();
}

function initPrism() {
    const showLineNumber = <?= General::Options('showLineNumber') == 1 ? 'true' : 'false' ?>;
    const preElements = document.querySelectorAll('pre');
    
    preElements.forEach(pre => {
        let code = pre.querySelector('code');
        if (!code) return;
        const hasLanguageClass = 
            pre.className.match(/\blanguage-\w+\b/) || 
            code.className.match(/\blanguage-\w+\b/);
            
        if (!hasLanguageClass) {
            pre.classList.add('language-plaintext');
        }

        pre.className = pre.className.replace(/\b(line-numbers)\b/g, '').trim();
        if (showLineNumber) {
            pre.classList.add('line-numbers');
        }
        pre.classList.add('prism');
        code.classList.add('prism');
    });
    
    if (typeof Prism !== 'undefined') {
        Prism.highlightAll();
    }
}
</script>
<?php if(General::Options('MathJax') == true && (\Typecho\Widget::widget('Widget_Archive')->is('post') || \Typecho\Widget::widget('Widget_Archive')->is('page'))):?>
<script src="<?php $this->options->themeUrl('assets/plugins/mathjax-v3/tex-chtml.js'); ?>" defer></script>
<script>
MathJax = {
  tex: {
    inlineMath: [['$', '$'], ['\$', '\$']]
  },
  options: {
    enableFontLoading: true,
    enableMenu: false,
    skipHtmlTags: ['script', 'noscript', 'style', 'textarea', 'pre'],
    ignoreHtmlClass: 'tex2jax_ignore'
  },
  startup: {
    pageReady: () => MathJax.startup.defaultPageReady()
  }
}; 
</script>
<?php endif; ?>
<?php if(General::Options('Mermaid') == true && (\Typecho\Widget::widget('Widget_Archive')->is('post') || \Typecho\Widget::widget('Widget_Archive')->is('page'))):?>
<style id="mermaid-loading-style">
.mermaid-loading {
    position: relative;
    min-height: 100px;
    background: #f8f9fa;
    border-radius: 4px;
    margin: 1rem 0;
}
.mermaid-loading::before {
    content: "图表加载中...";
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: 6c757d;
    font-size: 0.9em;
}
@keyframes ripplePulse {
    0% {
        transform: translate(-50%, -50%) scale(0.8);
        opacity: 0.6;
    }
    50% {
        transform: translate(-50%, -50%) scale(1.2);
        opacity: 1;
    }
    100% {
        transform: translate(-50%, -50%) scale(0.8);
        opacity: 0.6;
    }
}
</style>

<script>
(function() {
    var mermaidAsset = '<?php $this->options->themeUrl('assets/plugins/mermaid/mermaid.min.js'); ?>';
    var isLoaded = false;
    var styleAdded = false;
    function addLoadingState() {
        if (!styleAdded) {
            document.getElementById('mermaid-loading-style').disabled = false;
            styleAdded = true;
        }
        document.querySelectorAll('.mermaid').forEach(el => {
            if (!el.classList.contains('processing')) {
                el.classList.add('mermaid-loading', 'processing');
            }
        });
    }

    function removeLoadingState() {
        document.querySelectorAll('.mermaid.processing').forEach(el => {
            el.classList.remove('mermaid-loading', 'processing');
            el.removeAttribute('aria-live');
            el.removeAttribute('aria-label');
        });
    }
    function initMermaid() {
        try {
            mermaid.init(undefined, document.querySelectorAll('.mermaid'));
            document.dispatchEvent(new CustomEvent('mermaidRendered'));
        } catch(e) {
            console.error('Mermaid initialization failed:', e);
            document.querySelectorAll('.mermaid.processing').forEach(el => {
                el.innerHTML = '<div class="mermaid-error">图表渲染失败，请刷新页面</div>';
            });
        }
    }

    function loadMermaid() {
        if (isLoaded) {
            initMermaid();
            return;
        }
        addLoadingState();
        
        var script = document.createElement('script');
        script.src = mermaidAsset;
        script.onload = function() {
            mermaid.initialize({ 
                startOnLoad: false,
                securityLevel: 'loose'
            });
            initMermaid();
            removeLoadingState();
            isLoaded = true;
        };
        script.onerror = function() {
            removeLoadingState();
            document.querySelectorAll('.mermaid').forEach(el => {
                el.innerHTML = '<div class="mermaid-error">图表库加载失败，请检查网络</div>';
            });
        };
        document.head.appendChild(script);
    }

    function checkMermaid() {
        if (document.querySelector('.mermaid')) {
            loadMermaid();
        } else {
            document.getElementById('mermaid-loading-style').disabled = true;
        }
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', checkMermaid);
    } else {
        setTimeout(checkMermaid, 100);
    }
})();
</script>
<?php endif; ?>
<script src="<?php $this->options->themeUrl('assets/plugins/fancybox/fancybox.umd.min.js'); ?>"></script>
<script src="<?php $this->options->themeUrl('assets/plugins/autocomplete/autoComplete.min.js'); ?>"></script>
<script src="<?php $this->options->themeUrl('assets/plugins/menutree/menutree.min.js?v='); ?><?php echo themeVersion();?>"></script>
<script src="<?php $this->options->themeUrl('assets/js/pangu.min.js'); ?>"></script>
<script src="<?php $this->options->themeUrl('assets/plugins/lazyload/funlazy.min.js'); ?>"></script>
<script src="<?php $this->options->themeUrl('assets/js/beardocs.js?v='); ?><?php echo themeVersion();?>"></script>
<?php echo General::Options('CustomizationFooterJsCode'); ?>
<?php $this->footer(); ?>
<script src="<?php $this->options->themeUrl('assets/plugins/instant.page/instantpage.min.js'); ?>"></script>
</body>
</html>
