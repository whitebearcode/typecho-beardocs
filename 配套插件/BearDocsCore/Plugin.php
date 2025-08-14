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
 * @author BearNotion
 * @version v1.1.3-release
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
        \Typecho\Plugin::factory('admin/write-post.php')->richEditor_1000 = [__CLASS__, 'Editor'];
        \Typecho\Plugin::factory('admin/write-page.php')->richEditor_1000 = [__CLASS__, 'Editor'];
        \Typecho\Plugin::factory('Widget_Abstract_Contents')->markdown_27 = [__CLASS__, 'CommonParse'];
        \Typecho\Plugin::factory('Widget_Feedback')->comment_28 = [__CLASS__, 'filter'];
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
    
    public static function CommonParse($text){
        $text = preg_replace_callback(
            '/```mermaid\s+(.*?)\s+```/s',
            function ($matches) {
                return '<div class="mermaid">' . htmlspecialchars_decode(trim($matches[1])) . '</div>';
            },
            $text
        );

return Markdown::convert($text);
    }
     public static function getApiFunc($func){
         switch($func){
             case 'getAttachFile':
    $api = Helper::options()->siteUrl.'index.php/write';
    break;
         }
    echo $api;
}  
     public static function Editor()
    {
        $options = Helper::options();
    
         $dir = $options->pluginUrl.'/BearDocsCore/assets/vendors/';
        $cssUrl = $dir.'easymde/easymde.min.css';
        $jsUrl = $dir.'easymde/easymde.min.js';
        
        
	if (strpos( $_SERVER['REQUEST_URI'],'write-post.php') !== false)
{
    $type = 'post';
\Typecho\Widget::widget('Widget_Contents_Post_Edit')->to($post);
}
if (strpos( $_SERVER['REQUEST_URI'],'write-page.php') !== false)
{
    $type = 'page';
\Typecho\Widget::widget('Widget_Contents_Page_Edit')->to($page);
}

if (isset($post) || isset($page)) {
    $cid = isset($post) ? $post->cid : $page->cid;
    
    if ($cid) {
        \Typecho\Widget::widget('Widget_Contents_Attachment_Related', 'parentId=' . $cid)->to($attachment);
    } else {
        \Typecho\Widget::widget('Widget_Contents_Attachment_Unattached')->to($attachment);
    }
}

        ?>
<?php $fontawesomeUrl = Helper::options()->pluginUrl.'/BearDocsCore/assets/vendors/fontawesome/font-awesome.min.css';?>
<link rel="stylesheet" href="<?php echo $fontawesomeUrl;?>" />
        <link rel="stylesheet" href="<?php echo $cssUrl; ?>?v=1" />
        <script type="text/javascript" src="<?php echo $jsUrl; ?>?v=1"></script>
<link href="<?php echo $options->pluginUrl;?>/BearDocsCore/assets/vendors/toastr.js/toastr.min.css" rel="stylesheet">
	<script src="<?php echo $options->pluginUrl;?>/BearDocsCore/assets/vendors/toastr.js/toastr.min.js"></script>
<style>
    .editor-statusbar .lines:before{content:'行数: '}
    .editor-statusbar .words:before{content:'字数: '}
    .editor-statusbar .lines:after{content:' 行'}
    .editor-statusbar .words:after{content:' 个字'}
    .editor-toolbar{
        background:#2d333b;
    }
   .fullscreen{
       background:#2d333b;
   }
    .editor-toolbar i,
    .editor-toolbar button::after{
        color:#adbac7;
    }
    .editor-toolbar button:hover{
        background:#444c56;
    }
    .editor-toolbar button.active{
                background:#444c56;
                
    }
    .cm-s-easymde{
       background:#22272e;
        color:#adbac7;
    }

.CodeMirror {
  --selection-bg: #316dca;
  --selection-active-bg: #3d8ef7;
  --selection-text: white;
}

.CodeMirror-selected {
  background: var(--selection-bg) !important;
}

.CodeMirror-selectedtext {
  color: var(--selection-text) !important;
}

.CodeMirror-focused .CodeMirror-selected {
  background: var(--selection-active-bg) !important;
}

.CodeMirror-selection-secondary {
  background: #ffd33d !important;
}

.cm-s-easymde .CodeMirror-selected {
  background: #80cbc4 !important;
}

.CodeMirror-cursor {
  border-left: 2px solid #fff !important; 
}

.CodeMirror-focused .CodeMirror-cursor {
  border-left-color: #fff !important;
}


</style>

        <script>
        

            $(document).ready(function() {

                new EasyMDE({
        placeholder:'您现在可以开始撰写文章啦~~~',
        autoDownloadFontAwesome: false,
        spellChecker:false,
        nativeSpellcheck:false,
        sideBySideFullscreen:false,
        maxHeight:"500px",
        showIcons: ['strikethrough', 'code', 'table', 'redo', 'heading', 'undo', 'heading-bigger', 'heading-smaller', 'heading-1', 'heading-2', 'heading-3', 'clean-block', 'horizontal-rule','side-by-side'],
        <?php if(bdOptions::getInstance()::get_option( 'beardocs' )['markdownEditorAutosave'][0] == '1'):?>
        autosave: {
            enabled: true,
            delay: 1000,
            uniqueId: 'text',
            timeFormat:{locale:'zh-CN'},
            text:'自动保存时间：'
        },
        <?php endif; ?>
        toolbar: [{ name: "bold", action:EasyMDE.toggleBold, className: "fa fa-bold",title: "加粗"}, { name: "italic", action:EasyMDE.toggleItalic, className: "fa fa-italic",title: "字体倾斜"}, { name: "strikethrough", action:EasyMDE.toggleStrikethrough, className: "fa fa-strikethrough",title: "删除线"},{ name: "heading-smaller", action:EasyMDE.toggleHeadingSmaller, className: "fa fa-header",title: "字体缩小"}, { name: "heading-bigger", action:EasyMDE.toggleHeadingBigger, className: "fa fa-header",title: "字体放大"},{ name: "heading-1", action:EasyMDE.toggleHeading1, className: "fa fa-header header-1",title: "H1字号"},{ name: "heading-2", action:EasyMDE.toggleHeading2, className: "fa fa-header header-2",title: "H2字号"},{ name: "heading-3", action:EasyMDE.toggleHeading3, className: "fa fa-header header-3",title: "H3字号"}, { name: "code", action:EasyMDE.toggleCodeBlock, className: "fa fa-code",title: "代码"}, { name: "quote", action:EasyMDE.toggleBlockquote, className: "fa fa-quote-left",title: "引用"}, { name: "unordered-list", action:EasyMDE.toggleUnorderedList, className: "fa fa-list-ul",title: "无序列表"}, { name: "ordered-list", action:EasyMDE.toggleOrderedList, className: "fa fa-list-ol",title: "有序列表"},{ name: "clean-block", action:EasyMDE.cleanBlock, className: "fa fa-eraser",title: "擦除代码块"}, { name: "link", action:EasyMDE.drawLink, className: "fa fa-link",title: "插入链接"}, { name: "image", action:EasyMDE.drawImage, className: "fa fa-image",title: "插入图片"},{ name: "table", action:EasyMDE.drawTable, className: "fa fa-table",title: "插入表格"},{ name: "mermaid", className: "fa fa-share-alt", action:mermaid,title: "流程图"},{ name: "mindmap", className: "fa fa-sitemap", action:mindmap,title: "思维导图"},{ name: "mindmap", className: "fa fa-percent", action:mathjax,title: "数学公式"},{ name: "autosaves", className: "fa fa-floppy-o", action:autosave,title: "自动保存"},{ name: "inserts", className: "fa fa-paperclip", action:attachInsertEvent,title: "插入所有附件"},{ name: "insertper", className: "fa fa-file-o", action:insertper,title: "插入单个附件"},{ name: "copyupload", className: "fa fa-clone", action:copyupload,title: "复制粘贴上传"}],
        promptURLs:true,
        promptTexts:{
            image:"请填写图片直链",
            link:"请填写网址链接",
        },
        element: document.getElementById('text'),
    });
    
    function mathjax(editor){
    editor.codemirror.doc.replaceSelection('这是行内公式：$E=mc^2$ 会直接嵌入文本中。\n这是独立公式：\n$$\n\sum_{i=1}^n i = rac{n(n+1)}{2}\n$$'); 
            }
     function mermaid(editor){
    editor.codemirror.doc.replaceSelection('```mermaid\nMermaid内容\n```'); 
            }
      function mindmap(editor){
    editor.codemirror.doc.replaceSelection('```mermaid\nmindmap\n思维导图内容\n```'); 
            }      
    function autosave(editor){
          <?php if(bdOptions::getInstance()::get_option( 'beardocs' )['EditorsAutosave'][0] == '11'||bdOptions::getInstance()::get_option( 'beardocs' )['EditorsAutosave'][1] == '11'):?>
            //$("textarea:eq(1)").bind("input propertychange", autosaves); //废弃方法
        setInterval(function(){
         var submitted = false, form = $('form[name=write_post],form[name=write_page]').submit(function () {
        submitted = true;
    }), formAction = form.attr('action'),
        idInput = $('input[name=cid]'),
        cid = idInput.val(),
        draft = $('input[name=draft]'),
        draftId = draft.length > 0 ? draft.val() : 0,
        btnSave = $('#btn-save').removeAttr('name').removeAttr('value'),
        btnSubmit = $('#btn-submit').removeAttr('name').removeAttr('value'),
        btnPreview = $('#btn-preview'),
        //doAction = $('<input type="hidden" name="do" value="publish" />').appendTo(form),
        locked = false,
        changed = false,
        autoSave = $('<span id="auto-save-message" class="left"></span>').prependTo('.submit'),
        lastSaveTime = null;
        var data = new FormData(form.get(0));
        data.set("text",editor.value());
        var localcid = "<?php echo $cid;?>";
if(localcid == '' && localStorage.getItem('autosavecid') && localStorage.getItem('autosavecid') !== ''){
data.set("cid",localStorage.getItem('autosavecid'));
}
else{
    data.set("cid",localcid);
}
     
        function callback(o) {
toastr.success('已自动保存<br>保存时间:'+o.time);   
localStorage.setItem('autosavecid',o.cid);
$('input[name=cid]').val(o.cid);
        }
                data.append('do', 'save');

            
  $.ajax({
                url: formAction,
                processData: false,
                contentType: false,
                type: 'POST',
                data: data,
                success: callback
            });    
   },15000); 
   <?php endif; ?>
}
            
                setTimeout(function() {
                var buttons = $(".autosaves");
                buttons.click();
            }, 2000);
            

            setTimeout(function() {
                var button = $(".insertper");
                button.click();
            }, 2000);
        function insertper (editor) {
        
  $('#file-list').on('mousedown', '.insert', function(){
      var s=$(this).parents("li").data('url');
   if(s.match(/\.(jpg|jepg|png|ico|bmp|gif|tiff|webp)/i)){
        var fileurl="!["+$(this).text()+"]("+$(this).parents("li").data('url')+")\n";
   }
   else{
       var fileurl="["+$(this).text()+"]("+$(this).parents("li").data('url')+")\n";
   }
                 editor.codemirror.doc.replaceSelection(fileurl); 
});
    }

             function attachInsertEvent (editor) {
                 function getData() {
                    $.ajax({
                        type: "GET",
                        url: "<?php self::getApiFunc("getAttachFile"); ?>",
                        data: {
                            "cid": "<?php echo $cid; ?>",
                             "url": "<?php echo $type; ?>",
                        },
                        dateType: "json",
                        success: function(json) {
                            json = JSON.parse(json);
                            content(json.list);
                        },
                        complete: function() {
                        },
                        error: function() {
                            alert("数据获取错误");
                        }
                    });
                }
                getData();
                function content(list) {
                    var filename = " ";
                    var fileurl = " ";
                    for(var i in list) {
                        if(list[i]['type'] == 'img'){
                        fileurl += '![' + list[i]['title'] + ']('+ list[i]['url'] +')\n'
}
                        if(list[i]['type'] == 'other'){
                        fileurl += '[' + list[i]['title'] + ']('+ list[i]['url'] +')\n'
}
}
editor.codemirror.doc.replaceSelection(fileurl);
}
    }
    
    function copyupload(editor){
 $(document).on('paste',function(event){
                    let defaultValue = editor.codemirror.doc.getValue();
                        event = event.originalEvent;
                        var cbd = event.clipboardData;
                        var ua = window.navigator.userAgent;
                        var uploadURL = '<?php Helper::security()->index('/action/upload?cid=CID'); ?>';
                        
                        if (!(event.clipboardData && event.clipboardData.items)) {
                            return;
                        }

                        if (cbd.items && cbd.items.length === 2 && cbd.items[0].kind === "string" && cbd.items[1].kind === "file" &&
                            cbd.types && cbd.types.length === 2 && cbd.types[0] === "text/plain" && cbd.types[1] === "Files" &&
                            ua.match(/Macintosh/i) && Number(ua.match(/Chrome\/(\d{2})/i)[1]) < 49){
                            return;
                        }

                        var itemLength = cbd.items.length;
       
                        if (itemLength == 0) {
                            return;
                        }

                        if (itemLength == 1 && cbd.items[0].kind == 'string') {
                            return;
                        }

                        if ((itemLength == 1 && cbd.items[0].kind == 'file')
                                || itemLength > 1
                            ) {
                            for (var i = 0; i < cbd.items.length; i++) {
                                var item = cbd.items[i];

                                if(item.kind == "file") {
                                    var blob = item.getAsFile();
                                    if (blob.size === 0) {
                                        return;
                                    }
                                    var ext = blob.name.substring(blob.name.lastIndexOf(".")+1);
                                    var formData = new FormData();
                                    formData.append('blob', blob, Math.floor(new Date().getTime() / 1000) + '.' + ext);
                                    var uploadFailText = '文件上传失败(' + blob.name + ')'
                                    toastr.success('检测到正在复制粘贴图片，熊宝正在努力上传中~~');
                                    $.ajax({
                                        method: 'post',
                                        url: uploadURL.replace('CID', $('input[name="cid"]').val()),
                                        data: formData,
                                        contentType: false,
                                        processData: false,
                                        success: function(data) {
                                
                                            if (data[0]) {
                                       
                                                var filehz = data[0].substring(data[0].lastIndexOf(".")+1);
                                                switch(filehz){
                                                 case 'gif':
                                                 editor.codemirror.doc.replaceSelection('![](' + data[0] + ')\n');
                                                 break;
                                                 case 'jpg':
                                                 editor.codemirror.doc.replaceSelection('![](' + data[0] + ')\n');
                                                 break;
                                                 case 'jpeg':
                                                 editor.codemirror.doc.replaceSelection('![](' + data[0] + ')\n');
                                                 break;
                                                 case 'gif':
                                                 editor.codemirror.doc.replaceSelection('![](' + data[0] + ')\n');
                                                 break;
                                                 case 'png':
                                                 editor.codemirror.doc.replaceSelection('![](' + data[0] + ')\n');
                                                 break;
                                                 case 'tiff':
                                                 editor.codemirror.doc.replaceSelection('![](' + data[0] + ')\n');
                                                 break;
                                                 case 'bmp':
                                                 editor.codemirror.doc.replaceSelection('![](' + data[0] + ')\n');
                                                 break;
                                                 case 'svg':
                                                 editor.codemirror.doc.replaceSelection('![](' + data[0] + ')\n');
                                                 break;
                                                 case 'ico':
                                                 editor.codemirror.doc.replaceSelection('![](' + data[0] + ')\n');
                                                 break;
                                                 default:
                                                 editor.codemirror.doc.replaceSelection('['+data[1]['cid']+']['+data[1]['cid']+']\n['+data[1]['cid']+']: ' + data[0]+'\n');
                                                }
                                            
                                            } else {
                                               editor.codemirror.doc.replaceSelection(uploadFailText);
                                            }
                                         
                                        },
                                        error: function() {
                                            editor.codemirror.doc.replaceSelection(uploadFailText);
                                        }
                                    });
                                }
                            }

                        }

			});
       }
       
              setTimeout(function() {
                var button = $(".copyupload");
                button.click();
            }, 2000);
            
            
    
            });
            
            
            $(document).ready(function() {
           $(".copyupload").attr("style","display:none;");
               $(".insertper").attr("style","display:none;");
               $(".autosaves").attr("style","display:none;");
               localStorage.setItem('autosavecid','');
               $("#wmd-button-bar").attr("style","display:none;");
        
       });
     </script>
     <?php
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
    
    /**
     * 智能过滤
     * 
     */
     
    public static function getLastCommentTimeByIp($ipAddress) {
    	$db = \Typecho\Db::get();
    $ipFind = $db->fetchRow($db->select()->from('table.comments')->where('table.comments.ip = ?', $ipAddress)->order('table.comments.created', \Typecho\Db::SORT_DESC));;
    if($ipFind){
        return $ipFind['created'];
    }
    return 0;
}

    public static function containsHiddenCharacters($str) {
    $hiddenChars = [
        "\x01", // SOH (Start of Heading)
        "\x02", // STX (Start of Text)
        "\x03", // ETX (End of Text)
        "\x04", // EOT (End of Transmission)
        "\x05", // ENQ (Enquiry)
        "\x06", // ACK (Acknowledge)
        "\x07", // BEL (Bell)
        "\x08", // BS (Backspace)
        "\x09", // HT (Horizontal Tab)
        "\x0A", // LF (Line Feed)
        "\x0B", // VT (Vertical Tab)
        "\x0C", // FF (Form Feed)
        "\x0D", // CR (Carriage Return)
        "\x0E", // SO (Shift Out)
        "\x0F", // SI (Shift In)
        "\x10", // DLE (Data Link Escape)
        "\x11", // DC1 (Device Control 1)
        "\x12", // DC2 (Device Control 2)
        "\x13", // DC3 (Device Control 3)
        "\x14", // DC4 (Device Control 4)
        "\x15", // NAK (Negative Acknowledge)
        "\x16", // SYN (Synchronous Idle)
        "\x17", // ETB (End of Transmission Block)
        "\x18", // CAN (Cancel)
        "\x19", // EM (End of Medium)
        "\x1A", // Substitute character
        "\x1B", // ESC (Escape)
        "\x1C", // File Separator
        "\x1D", // Group Separator
        "\x1E", // Record Separator
        "\x1F"  // Unit Separator
    ];

    foreach ($hiddenChars as $char) {
        if (strpos($str, $char) !== false) {
            return true;
        }
    }

    return false;
}
    public static function isUrl($text) {
    //$urlPattern = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
    //return preg_match($urlPattern, $text);
    $urlPattern = '/\b(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?\b/';
    return preg_match($urlPattern, $text);
}

	public static function isBotComment($comment, $timeSinceLastComment = 60){
	//一些常见的机器人用户代理字符串
    $botUserAgents = [
        'bot',
        'crawl',
        'spider',
        'robot',
        'crawling',
        'fetch',
        'indexing',
        'mediapartners'
    ];

    // 检查用户代理是否包含机器人关键词
    foreach ($botUserAgents as $botKeyword) {
        if (stripos($comment['agent'], $botKeyword) !== false) {
            return true;
        }
    }

    // 检查评论内容是否过于简单或重复
    if (strlen($comment['text']) < 10 || preg_match('/^\s*$/', $comment['text'])) {
        return true;
    }

    // 检查IP地址是否在短时间内发送了多个评论
    $lastCommentTime = self::getLastCommentTimeByIp($comment['ip']);
    if ($lastCommentTime && (time() - $lastCommentTime) < $timeSinceLastComment) {
        return true;
    }
    // 检查评论内容是否包含隐藏字符
    if (self::containsHiddenCharacters($comment['text'])) {
        return true;
    }
    // 检查评论昵称是否包含网址
    if (self::isUrl($comment['author'])) {
        return true;
    }
    // 如果以上条件都不满足，则认为不是机器人评论
    return false;
	}
	
	public static function xsscheck($text)
{
    $xsscheck = false;
    $list = array(
        '/onabort/is',
        '/onblur/is',
        '/onchange/is',
        '/onclick/is',
        '/ondblclick/is',
        '/onerror/is',
        '/onfocus/is',
        '/onkeydown/is',
        '/onkeypress/is',
        '/onkeyup/is',
        '/onload/is',
        '/onmousedown/is',
        '/onmousemove/is',
        '/onmouseout/is',
        '/onmouseover/is',
        '/onmouseup/is',
        '/onreset/is',
        '/onresize/is',
        '/onselect/is',
        '/onsubmit/is',
        '/onunload/is',
        '/eval/is',
        '/ascript:/is',
        '/style=/is',
        '/width=/is',
        '/width:/is',
        '/height=/is',
        '/height:/is',
        '/src=/is',
    );
    if (strip_tags($text)) {
        for ($i = 0; $i < count($list); $i++) {
            if (preg_match($list[$i], $text) > 0) {
                $xsscheck = true;
                break;
            }
        }
    } else {
        $xsscheck = true;
    };
    return $xsscheck;
}

	 public static function filter($comment,$post){
	   $options = bdOptions::getInstance()::get_option( 'beardocs' );  
	   $removeChar = ["https://", "http://"]; 
if (strpos($_SERVER['HTTP_REFERER'], str_replace($removeChar, "", Helper::options()->siteUrl)) == false ) { 
    throw new \Typecho\Widget\Exception("抱歉，检测到来源错误，请在正确的页面进行评论。",200);
}
if(Plugin::xsscheck($comment['text'])) {
			\Typecho\Cookie::set('__typecho_remember_text', $comment['text']);
			throw new \Typecho\Widget\Exception("抱歉，系统检测到您的评论包含危险内容，请返回修改后再试。",200);
        }
$comment['url'] =htmlspecialchars($comment['url'],ENT_QUOTES,'UTF-8');
        if ($comment['mail'] !== null && preg_match("/^[A-Za-z0-9\-]+([_\.][A-Za-z0-9\-]+)*@([A-Za-z0-9\-]+\.)+[A-Za-z]{2,}$/", $comment['mail']) !== 1) {
    throw new \Typecho\Widget\Exception("抱歉，系统检测到您的评论包含危险内容，请返回修改后再试。", 200);                      
}
if (strlen(trim(preg_replace('/\xc2\xa0/',' ',$comment['text']))) == 0) {
			\Typecho\Cookie::set('__typecho_remember_text', $comment['text']);
			throw new \Typecho\Widget\Exception("抱歉，系统检测到您的评论内容只有空格，请返回修改后再试。",200);
            }
            if($options['BearSpam_Auto'] == true){
        if (self::isBotComment($comment)) {
              throw new \Typecho\Widget\Exception("抱歉，本条评论被判定为机器人评论，已自动拦截。",200);  
            }
            }   
            if($options['BearSpam_Pro'] == true){
        if (!empty($options['BearSpam_IP'])) {
			if (Plugin::check_ip($options['BearSpam_IP'], $comment['ip'])) {
			throw new \Typecho\Widget\Exception("抱歉，系统检测到您的IP处于屏蔽范围内，已拦截本条评论。",200);
			  \Typecho\Cookie::set('__typecho_remember_text', $comment['text']);
			}

            
        }
		if (!empty($options['BearSpam_EMAIL'])) {
			if (Plugin::check_in($options['BearSpam_EMAIL'], $comment['mail'])) {
				throw new \Typecho\Widget\Exception("抱歉，系统检测到您的邮箱处于屏蔽范围内，已拦截本条评论。",200);
				  \Typecho\Cookie::set('__typecho_remember_text', $comment['text']);
			}
		}
		
			if (!empty($options['BearSpam_NAME'])) {
			if (Plugin::check_in($options['BearSpam_NAME'], $comment['author'])) {
			    
				throw new \Typecho\Widget\Exception("抱歉，系统检测到您的昵称存在敏感禁止词汇，已拦截本条评论。",200);
				  \Typecho\Cookie::set('__typecho_remember_text', $comment['text']);
			}
		}
		
		if (!empty($options['BearSpam_URL'])) {
			if (Plugin::check_in($options['BearSpam_URL'], $comment['url'])) {
			    			throw new \Typecho\Widget\Exception("抱歉，系统检测到您的网址处于屏蔽范围内，已拦截本条评论。",200);
			\Typecho\Cookie::set('__typecho_remember_text', $comment['text']);
			}
			}
			
			if (!empty($options['BearSpam_ArticleTitle'])&& $options['BearSpam_ArticleTitle'] == "1") {
			$db = \Typecho\Db::get();
            // 获取评论所在文章
            $pot = $db->fetchRow($db->select('title')->from('table.contents')->where('cid = ?', $comment['cid']));        
            if(strstr($comment['text'], $pot['title'])){
                		throw new \Typecho\Widget\Exception("抱歉，系统检测到您的评论内容疑似存在灌水内容，已自动拦截。",200);
\Typecho\Cookie::set('__typecho_remember_text', $comment['text']);
			}
			}
			
			if (!empty($options['BearSpam_NAMEMIN'])) {    
            if(Plugin::strLength($comment['author']) < $options['BearSpam_NAMEMIN']){

			throw new \Typecho\Widget\Exception("抱歉，系统检测到您的评论昵称过短，已自动拦截。",200);
			\Typecho\Cookie::set('__typecho_remember_text', $comment['text']);
			}
			}
			
			if (!empty($options['BearSpam_NAMEMAX'])) {    
            if (Plugin::strLength($comment['author']) > $options['BearSpam_NAMEMAX']) {
                throw new \Typecho\Widget\Exception("抱歉，系统检测到您的评论昵称过长，已自动拦截。",200);
			\Typecho\Cookie::set('__typecho_remember_text', $comment['text']);
			}}
			
			if (!empty($options['BearSpam_NAMEURL'])&& $options['BearSpam_NAMEURL'] == "1") {    
            if (preg_match(" /^((https?|ftp|news):\/\/)?([a-z]([a-z0-9\-]*[\.。])+([a-z]{2}|aero|arpa|biz|com|coop|edu|gov|info|int|jobs|mil|museum|name|nato|net|org|pro|travel)|(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5]))(\/[a-z0-9_\-\.~]+)*(\/([a-z0-9_\-\.]*)(\?[a-z0-9+_\-\.%=&]*)?)?(#[a-z][a-z0-9_]*)?$/ ", $comment['author']) > 0) {
			                throw new \Typecho\Widget\Exception("抱歉，系统检测到您的评论昵称异常，已自动拦截。",200);
			\Typecho\Cookie::set('__typecho_remember_text', $comment['text']);
			}}
			
			if (!empty($options['BearSpam_Chinese'])&& $options['BearSpam_Chinese'] == "1") {    
            if (preg_match("/[\x{4e00}-\x{9fa5}]/u", $comment['text']) == 0) {
			throw new \Typecho\Widget\Exception("抱歉，系统检测到您的评论内容不包含中文，已自动拦截。",200);
			\Typecho\Cookie::set('__typecho_remember_text', $comment['text']);
			}}
			
			if (!empty($options['BearSpam_MIN'])) {    
            if(Plugin::strLength($comment['text']) < $options['BearSpam_MIN']){         
				throw new \Typecho\Widget\Exception("抱歉，系统检测到您的评论内容字数过少，已自动拦截。",200);
			\Typecho\Cookie::set('__typecho_remember_text', $comment['text']);
			}}
			
			if (!empty($options['BearSpam_MAX'])) {    
            if(Plugin::strLength($comment['text']) > $options['BearSpam_MAX']){         
				throw new \Typecho\Widget\Exception("抱歉，系统检测到您的评论内容字数过多，已自动拦截。",200);
			\Typecho\Cookie::set('__typecho_remember_text', $comment['text']);
			}}
			
			if (!empty($options['BearSpam_Words'])) {    
            if (Plugin::check_in($options['BearSpam_Words'], $comment['text'])) { 
	throw new \Typecho\Widget\Exception("抱歉，系统检测到您的评论内容包含敏感禁止词汇，已自动拦截。",200);
			\Typecho\Cookie::set('__typecho_remember_text', $comment['text']);
			}
					    
			}
            }
            \Typecho\Cookie::delete('__typecho_remember_text');
             return $comment;
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