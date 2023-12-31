<?php
namespace TypechoPlugin\BearDocsCore;
error_reporting(0);
use Utils\Helper;
use Typecho\Plugin\PluginInterface;
use Typecho\Widget\Helper\Form;
use Typecho\{Plugin\Exception, Widget, Db, Widget\Request as WidgetRequest};
use \CSF as CSF;
use bdOptions;
use Widget\Options;
use Typecho\Common;
use Typecho\Router;
use Widget\Archive;
use Widget\Contents\Post\Admin;
use Widget\Contents\Post\Edit;
use Widget\Feedback;
use Widget\Service;
use ReflectionClass;
use Utils\PasswordHash;
use Typecho\Widget\Response as WidgetResponse;
use Utils\Markdown as Markdown;


/**
 * BearDocs主题核心插件
 * <br>安装后无需进行其他设置
 * @package BearDocsCore
 * @author WhiteBear
 * @version v1.0.3-release
 * @link https://www.bearnotion.ru/
 *
 */



if (!defined('__TYPECHO_ROOT_DIR__')) exit;
if (!defined('pluginName')) {
  define('pluginName', 'BearDocsCore');
}
require_once 'bdoptions-framework.php';

class Plugin implements PluginInterface
{
    
     public static function getNS(): string
    {
        return __NAMESPACE__;
    }
    
    public static function activate()
    {
        /* 
         *
         *  初始化路由和方法
         *
         */
        bdRouter::initRouter();
        \Typecho\Plugin::factory('index.php')->begin_999 = [__CLASS__, 'initevent'];
        \Typecho\Plugin::factory('admin/header.php')->header_999 = [__CLASS__, 'enqueue_style'];
        \Typecho\Plugin::factory('admin/footer.php')->end_999 = [__CLASS__, 'enqueue_script'];
        \Typecho\Plugin::factory('admin/write-post.php')->bottom_999 = [__CLASS__,'shortcode_button'];
        \Typecho\Plugin::factory('admin/write-page.php')->bottom_999 = [__CLASS__,'shortcode_button'];
        \CSF::activateEvent();
        
        
        
         return _t('BearDocsCore核心同步完成');
    }

    public static function deactivate()
    {
        bdRouter::removeRouter();
        return _t('BearDocsCore核心清除完成');
    }
    
    
   

    public static function initevent()
    {
        if (!class_exists('bdOptions')){
            require_once \Utils\Helper::options()->pluginDir('BearDocsCore').'/bdOptions.php';
        }
    }
    public static function send_request($url, $postdata,$sendtype,$header = 'Content-type: application/x-www-form-urlencoded') {
     if($postdata){
         if(is_array($postdata)){
    $data = http_build_query($postdata);
         }
         else{
           $data = $postdata;
         }
    $options    = array(
        'http' => array(
            'method'  => $sendtype,
            'header'  => $header,
            'content' => $data,
            'timeout' => 5
        )
    );
     }
     else{
     $options    = array(
        'http' => array(
            'method'  => $sendtype,
            'header'  => "Content-type: application/x-www-form-urlencoded",
            'timeout' => 5
        )
    );    
     }
    $context = stream_context_create($options);
    $result    = file_get_contents($url, false, $context);
    if($http_response_header[0] !== 'HTTP/1.1 200 OK'){
        $result = array(
            "result" => "success",
            "reason" => "request fail"
        );
        return json_encode($result);
    }else{
        return $result;
    }
}

    public static function enqueue_style($header=null, $old=null)
    {
        if ($old!=null) $header = $old;
        return CSF::get_enqueue_style($header);
    }

    public static function enqueue_script($footer=null)
    {
        return CSF::get_enqueue_script($footer);
    }

    public static function config(Form $form)
    {

    }

    public static function personalConfig(Form $form)
    {
    }
    
    

    public static function configHandle($origin_config, $is_init)
    {
        return true;
    }
    
  
    public static function shortcode_button(){
        ?>
        <style>.wmd-button-row {
    height: auto;
}
</style>
<link rel="stylesheet" href="//cdn.staticfile.org/remixicon/3.5.0/remixicon.min.css" />
        <script>
        $(document).ready(function() {
shortCode_changelog();
});



//插入按钮
function shortCode_changelog(){
    	if ($("#wmd-button-row").length > 0) {
		$('#wmd-button-row').append('<li class="wmd-button" id="wmd-log-button" style="" title="插入更新日志"><span style="background: none;margin-top:7px;font-size: 15px;text-align: center;color: #999999;font-family: serif;"><i class="ri-book-line"></i></span></li>');

		
		
		$(document).on('click', '#wmd-log-button',
		function() {
			textContent = '\r\n' + '[log version="版本号" date="日期" type="版本类型"]'+'\r\n'+'该版本更新内容' + '\r\n[/log]';
			myField = document.getElementById('text');
			insertButton(myField, textContent);
		});
		

	
    	};
}

function insertButton(myField, textContent, modelId = '') {
	if (modelId != '') {
		$(modelId).remove();
	}
	if (document.selection) {
		myField.focus();
		var sel = document.selection.createRange();
		sel.text = textContent;
		myField.focus();
	} else if (myField.selectionStart || myField.selectionStart == '0') {
		var startPos = myField.selectionStart;
		var endPos = myField.selectionEnd;
		var cursorPos = startPos;
		myField.value = myField.value.substring(0, startPos) + textContent + myField.value.substring(endPos, myField.value.length);
		cursorPos += textContent.length;
		myField.selectionStart = cursorPos;
		myField.selectionEnd = cursorPos;
		myField.focus();
	} else { //其他环境
		myField.value += textContent;
		myField.focus();
	}
}

</script>
<?php
}


    public static function getSecurity($typeName,$name,$value = null){
    if($typeName == 'get'){
        $value = \Typecho\Cookie::get($name);
        return $value;
    }
    elseif($typeName == 'set'){
        \Typecho\Cookie::set($name, $value);
    }
    else{
        \Typecho\Cookie::delete($name, $value);
    }
}


}