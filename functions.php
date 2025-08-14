<?php
error_reporting(0);
use Typecho\Common;
use Typecho\Exception;
use Typecho\Router;
use Utils\Helper;
use Widget\Options;
if(!class_exists('CSF')){
    require_once Helper::options()->pluginDir('BearDocsCore').'/bdoptions-framework.php';
}

if (!class_exists('bdOptions')){
    require_once \Utils\Helper::options()->pluginDir('BearDocsCore').'/bdOptions.php';
}
require_once('core/Core.php');
if(Helper::options()->version >= '1.3.0'){
require_once('modules/Comments/Comments_n.php');
}
else{
require_once('modules/Comments/Comments.php');
}

function themeVersion()
        {
            return '1.1.3.20250814';
        }


function themeVersionOnly()
        {
            return '1.1.3';
        }

$options = bdOptions::getInstance()::get_option( 'beardocs' );

if( class_exists( 'CSF' ) ) {
    $Tyoptions = Helper::options();
    $db = \Typecho\Db::get();
  $prefix = 'beardocs'; 
  CSF::createOptions( $prefix, array(
    'menu_title' => 'Beardocs',
    'menu_slug'  => 'my-beardocs',
  ) );
  CSF::createSection( $prefix, array(
    'title'       => '使用说明',
    'icon'        => 'fas fa-question-circle',
    'description' => '欢迎使用BearDocs主题，本主题为<strong>文档类主题</strong>，以下是本主题的使用说明。',
    'fields'      => array(
       array(
            'type'    => 'heading',
            'content' => '使用说明',
        ),

        array(
            'type'    => 'content',
            'content' => '1、主题用户交流QQ群:561848356<br><font color=red>2、若主题配置保存失败请检查是否开启了防火墙，且防火墙是否拦截了请求</font><br>3、不懂的问题或本主题存在的问题可加群或在BearTalk社区中进行反馈<br>
    4、
        BearTalk社区是为使用者提供的一个讨论交流社区，传送门：<a href="https://www.beartalk.ru" target="_blank">戳这里</a>
     <center>  <br>
 <div class="csf-submessage csf-submessage-info">当前版本:v'.themeVersion().' / 最新版本:v<font id="version"></font></div>
<div id="versiontips" style="margin-top:10px"></div></center>


<script src="'.Helper::options()->themeUrl.'/assets/plugins/jquery/jquery.min.js"></script>
  <script src="'.Helper::options()->themeUrl.'/assets/plugins/layer/layer.min.js?v=1" type="application/javascript"></script>
<script>

$(function() {


$.post("https://upgrade.typecho.co.uk/Beardocs/version.php",function(data,status){
switch(status)
{
case "success":
json = JSON.parse(data);
nowversion = "'.themeVersion().'";
$("#version").html(json.version);
if(json.version > nowversion){
if (/(iPhone|iPad|iPod|iOS|Android)/i.test(navigator.userAgent)) {
    $("#versiontips").html(\'<div class="csf-submessage csf-submessage-warning">检测到有新版本可以更新，请及时完成更新!<br><a href="#check" class="ui warning label">前往更新<a></div>\');
} else {
    $("#versiontips").html(\'<div class="csf-submessage csf-submessage-warning">检测到有新版本可以更新，请及时完成更新!<br><a href="#tab=在线升级" class="ui warning label">前往更新<a></div>\'); 
};

}
break;
case "error":
$("#version").html("最新版本获取失败");
break;
case "timeout":
$("#version").html("最新版本获取超时");
break;
default: $("#version").html("'.themeVersion().'");
}
    });
});
</script>',
        ),

        array(
            'type'    => 'submessage',
            'style'   => 'info',
            'content' => '在反馈本主题相关的问题时，请务必将以下内容放入您要反馈的内容中',
        ),
array(
                'type'    => 'notice',
            'style'   => 'info',
                'content' => '<ul style="margin:0 auto;"><li>BearDocs主题版本：V'.themeVersion().'[<a href="https://docs.whitebear.dev/index.php/archives/10/" target="_blank">更新日志</a>]</li><li>PHP版本：'.PHP_VERSION.'</li><li>网站服务器：'.$_SERVER['SERVER_SOFTWARE'].'</li><li>数据库：'.$db->getAdapterName().'[Version：'.$db->getVersion().']</li><li>Typecho版本：'.$Tyoptions->version.'</li><li>User Agent信息：'.$_SERVER['HTTP_USER_AGENT'].'</li></ul>',
        ),

    )
) );
  CSF::createSection( $prefix, array(
    'title'  => '基础设置',
    'icon'   => 'fas fa-cog',
    'fields' => array(
      
      array(
        'id'    => 'logoText',
        'type'  => 'text',
        'title' => '站点文字LOGO',
        'default' => $Tyoptions->title,
        'after' => '请填入站点文字LOGO',
      ),
      array(
        'id'    => 'logoPic',
        'type'  => 'upload',
        'title' => '站点图片LOGO',
        'after' => '当本项为空时则使用文字LOGO',
      ),
      array(
            'id'      => 'favicon',
            'type'    => 'upload',
            'title'   => '站点Favicon图标',
        ),
        array(
            'id'      => 'headerBackground',
            'type'    => 'upload',
            'title'   => '站点顶部背景',
            'after' => '请上传站点顶部背景图片或填写图片直链，当无背景图片时则显示“纯色背景”',
        ),
      array(
            'id'      => 'headerColorChoose',
            'type'    => 'switcher',
            'title'       => '是否开启渐变背景',
            'after' => '<br><br>若开启渐变背景，则以上顶部背景项将失效。',
            'default' => false,
        ),
    array(
            'id'      => 'headerColor1',
            'type'    => 'color',
            'title'       => '渐变背景颜色选择[左]',
            'subtitle' => '请选择渐变背景左边颜色。',
            'default' => false,
            'dependency' => array( 'headerColorChoose', '==', 'true' ),
        ),
        
    array(
            'id'      => 'headerColor2',
            'type'    => 'color',
            'title'       => '渐变背景颜色选择[右]',
            'subtitle' => '请选择渐变背景右边边颜色。',
            'default' => false,
            'dependency' => array( 'headerColorChoose', '==', 'true' ),
        ),
      array(
        'id'    => 'headerText',
        'type'  => 'text',
        'title' => '站点顶部标语',
        'after' => '请填入站点顶部标语，若为空则显示“有什么可以帮助到您的?”',
      ),
      array(
        'id'    => 'announcementText',
        'type'  => 'textarea',
        'title' => '站点公告',
        'after' => '请填入站点公告，为空则不显示',
      ),
    array(
            'id'      => 'searchWay',
            'type'    => 'radio',
            'title'   => '实时搜索类型',
            'inline'  => true,
            'options' => array(
                '1'    => '简略搜索',
                '2'   => '精确搜索[Beta]',
            ),
            'default' => '1',
            'after' => '简略搜索仅模糊查询关键词，而精确搜索则将关键词分词后再进行查询',
        ),  
    array(
            'id'      => 'childCategorySameIcon',
            'type'    => 'switcher',
            'title'       => '父子分类图标一致',
            'after' => '<br><br>开启后子分类将同父分类图标保持一致',
            'default' => false,
        ),
    
    array(
            'id'      => 'categoryListStyle',
            'type'    => 'radio',
            'title'   => '首页文档分类样式',
            'inline'  => true,
            'options' => array(
                'simple'    => '简洁',
                'full'    => '全面',
            ),
            'default' => 'full',
            'after' => '选择首页文档分类的样式，简洁样式即只有简单的包含图标、分类名和描述的卡片，全面的样式则包含图标、分类名、描述、文章数和该分类下最新5篇文章',
        ),
    array(
            'id'          => 'categoryShowColumnMiddle',
            'type'        => 'select',
            'title'       => '首页分类一行显示几个[中等屏幕]',
            'after' => '选择首页分类在中等屏幕下一行显示几个',
            'options'     => array('1' => '一个',  '2' => '两个',  '3' => '三个',  '4' => '四个',  '5' => '五个',  'auto' => '自动[自适应调整]'),
            'default' => '2',
            'dependency' => array( 'categoryListStyle', '==', 'simple')
        ),
    array(
            'id'          => 'categoryShowColumnLarge',
            'type'        => 'select',
            'title'       => '首页分类一行显示几个[大屏幕]',
            'after' => '选择首页分类在大屏幕下一行显示几个',
            'options'     => array('1' => '一个',  '2' => '两个',  '3' => '三个',  '4' => '四个',  '5' => '五个',  'auto' => '自动[自适应调整]'),
            'default' => '2',
            'dependency' => array( 'categoryListStyle', '==', 'simple')
        ),
       array(
            'id'      => 'commonProblem_module',
            'type'    => 'switcher',
            'title'       => '是否开启常见问题解答区块',
            'after' => '<br><br><font color=red>[仅首页可见]</font> 若开启常见问题解答区块，则首页将显示常见问题解答，您可以添加一些常见问题并给予答案，便于查看文档的用户更快的定位问题。',
            'default' => false,
        ),
        array(
            'id'     => 'commonProblem',
            'type'   => 'group',
            'title'  => '常见问题解答',
            'subtitle' => '您可以通过本项增加常见问题解答',
            'dependency' => array( 'commonProblem_module', '==', 'true'),
            'fields' => array(
                array(
        'id'    => 'commonProblem_note',
        'type'  => 'text',
        'title' => '常见问题备注',
        'after' => '您可以给该常见问题加个备注，该项仅后台可见',
      ),
            array(
            'id'          => 'commonProblem_title',
            'type'        => 'text',
            'title'       => '常见问题题目',
            'after' => '请输入常见问题题目',
        ),
               array(
            'id'          => 'commonProblem_answer',
            'type'        => 'code_editor',
            'title'       => '常见问题答案',
            'after' => '请输入常见问题答案,支持HTML代码',
        ),
            ),
        ),
        
       array(
            'id'      => 'avatarChoose',
            'type'    => 'radio',
            'title'   => '头像服务选择',
            'inline'  => true,
            'options' => array(
                'cravatar'    => 'Cravatar服务(cravatar.cn)',
                'cravatar2'    => 'Cravatar服务(cravatar.com)',
                'weavatar'   => 'Weavatar服务',
                'gravatar'   => 'Gravatar服务',
                'diyavatar'   => '自定义头像',
            ),
            'default' => 'cravatar',
            'after' => 'Cravatar服务：Cravatar适合在国内使用，优先级:Cravatar头像->Gravatar头像->QQ头像<br>Weavatar服务：Weavatar也适合在国内使用，优先级:Weavatar头像->Gravatar头像->QQ头像<br>Gravatar服务：在国内官方源可能访问不了头像，支持了多个镜像源并支持您填写自定义镜像源<br>自定义头像：您可以通过自定义头像在前台显示随机头像，在自定义头像栏为空时默认为Cravatar<br><font color=red>目前QQ头像调用的是Weavatar，若注册过Weavatar，则不会显示QQ头像</font>',
        ),
        array(
            'id'      => 'Cravatar_default',
            'type'    => 'upload',
            'title'   => 'Cravatar默认头像',
            'after' => '考虑到Cravatar默认头像略丑的问题，这里支持自定义Cravatar默认头像。',
            'dependency' => array( 'avatarChoose', '==', 'cravatar' ),
        ),
        array(
            'id'      => 'Cravatar2_default',
            'type'    => 'upload',
            'title'   => 'Cravatar默认头像',
            'after' => '考虑到Cravatar默认头像略丑的问题，这里支持自定义Cravatar默认头像。',
            'dependency' => array( 'avatarChoose', '==', 'cravatar2' ),
        ),
        array(
            'id'      => 'Weavatar_default',
            'type'    => 'upload',
            'title'   => 'Weavatar默认头像',
            'after' => '考虑到Weavatar默认头像略丑的问题，这里支持自定义Weavatar默认头像。',
            'dependency' => array( 'avatarChoose', '==', 'weavatar' ),
        ),
        array(
        'id'    => 'DiyAvatar',
        'type'  => 'textarea',
        'title' => '自定义头像',
        'after' => '您可以自定义前台随机头像，格式为a.png,b.png，保证每个头像图片都为直链可直接访问，多个头像图片使用英文逗号分隔，当本栏为空时默认使用Cravatar服务。',
        'dependency' => array( 'avatarChoose', '==', 'diyavatar' ),
      ),
      array(
            'id'          => 'Gravatar',
            'type'        => 'select',
            'title'       => 'Gravatar源选择',
            'after' => '因Gravatar官方在中国大陆地区被Q，导致在中国大陆访问使用Gravatar的站点时头像不显示,这里支持您自主选择合适的源,若为自定义，举例:cdn.v2ex.com/gravatar/<br>本功能适配QQ,当填写的邮箱为QQ邮箱时则显示QQ头像',
            'options'     => array('1' => 'Gravatar官方源', '3' => 'V2EX*Gravatar镜像源','4' => 'LOLI.NET*Gravatar镜像源','7' => '自定义Gravatar镜像源'),
            'default' => '5',
            'dependency' => array( 'avatarChoose', '==', 'gravatar' ),
        ),
      array(
        'id'    => 'GravatarUrl',
        'type'  => 'text',
        'title' => '自定义Gravatar源地址',
        'after' => '请填入自定义Gravatar镜像源地址,格式:cdn.v2ex.com/gravatar/<br>Tips:当您所填写的自定义地址访问时能够显示图片时则您所填写的地址是正常的',
        'dependency' => array( 'Gravatar|avatarChoose', '==|==', '7|gravatar' ),
      ), 
      
    )
  ) );
CSF::createSection( $prefix, array(
    'title'  => '顶部设置',
    'icon'   => 'fas fa-chevron-up',
    'fields' => array(
     
        array(
            'id'       => 'CustomizationCode',
            'type'     => 'code_editor',
            'title'    => '顶部自定义代码',
            'subtitle' => '如百度Meta验证代码，均可以放在这里',
        ),
        
        
    )
  ) );
  
  CSF::createSection( $prefix, array(
    'title'  => '文档设置',
    'icon'   => 'fas fa-file',
    'fields' => array(
    array(
            'id'      => 'hiddenMeta',
            'type'    => 'switcher',
            'title'       => '隐藏文档元信息',
            'after' => '<br><br>开启后文档标题下方显示的元信息(撰写人、修改时间)将隐藏',
            'default' => false,
        ),
    array(
            'id'      => 'EditorsAutosave',
            'type'    => 'checkbox',
            'title'   => '编辑器自动保存方式选择',
            'after' => '自动保存支持两种方式，两种方式可同时开启不受影响，全都不选代表不开启自动保存<br>第一种即为浏览器保存，文章在还没点击提交的情况下均保存在浏览器中，点击其他文章，先前文章的内容仍会直接覆盖到当前文章。第二种是保存为草稿，编辑器在每隔十五秒会将文章保存为草稿。',
            'inline'  => true,
            'options' => array(
                '1' => '浏览器自动保存',
                '11' => '自动保存为草稿',
            ),
        ),
      
       array(
            'id'      => 'showTags',
            'type'    => 'switcher',
            'title'       => '文档页面是否显示文档标签',
            'after' => '<br><br>开启后文档页面底部显示该文档的标签',
            'default' => false,
        ),
    array(
            'id'      => 'showThreeColumns',
            'type'    => 'switcher',
            'title'       => '文档页面三栏模式',
            'after' => '<br><br>开启后在电脑端场景中文档页面更多文档和目录导航将显示在文档主体内容的左边和右边。',
            'default' => false,
        ),
        array(
            'id'      => 'codeHighLight',
            'type'    => 'radio',
            'title'   => '代码高亮样式',
            'inline'  => true,
            'options' => array(
                'WhiteMac.css'    => '白色Mac',
                'BlackMac.css'    => '黑色Mac',
                'GrayMac.css'    => '灰色Mac'
            ),
            'default' => 'BlackMac.css',
            'after' => '已内置并默认开启代码高亮组件，可在这选择代码高亮样式',
        ),
        array(
            'id'          => 'showLineNumber',
            'type'        => 'select',
            'title'       => '代码高亮显示行号',
            'after' => '是否在代码高亮左侧显示行号',
            'options'     => array('1' => '是',  '2' => '否'),
            'default' => '1',
        ), 
        array(
            'id'      => 'MathJax',
            'type'    => 'switcher',
            'title'       => 'Mathjax 数学公式组件',
            'after' => '<br><br>开启后文档内容中将自动解析渲染数学公式',
            'default' => false,
        ),
        array(
            'id'      => 'Mermaid',
            'type'    => 'switcher',
            'title'       => 'Mermaid 美人鱼组件',
            'after' => '<br><br>开启后文档内容中将自动解析渲染流程图、思维导图',
            'default' => false,
        ),
    )
  ) );
  CSF::createSection( $prefix, array(
    'title'  => '评论设置',
    'icon'   => 'fas fa-comment',
    'fields' => array(
    array(
            'id'      => 'hiddenComment',
            'type'    => 'switcher',
            'title'       => '全局隐藏评论区',
            'after' => '<br><br>开启后全局隐藏评论区',
            'default' => false,
        ),
         array(
        'id'    => 'CommentText',
        'type'  => 'text',
        'title' => '站点评论提示',
        'after' => '请填入站点评论提示，默认为：嘿~ 大神，别默默的看了，快来点评一下吧',
         'dependency' => array( 'hiddenComment', '==', 'false')
      ),
      array(
            'type'    => 'heading',
            'content' => '评论过滤设置',
        ),
        array(
            'type'    => 'subheading',
            'content' => '默认强制性过滤全空格评论、包含XSS危险内容评论，其余需过滤内容您可以通过开启智能过滤或开启评论过滤高级设置进行设置。',
        ),
        array(
            'id'      => 'BearSpam_Auto',
            'type'    => 'switcher',
            'title'       => '智能过滤[Beta]',
            'default' => false,
            'subtitle'=>'您可以通过开启智能过滤来对机器人评论进行拦截，不过请注意:<font color=red>该功能还处于Beta测试阶段，可能出现误拦截的情况</font>',
        ),
        array(
            'id'      => 'BearSpam_Pro',
            'type'    => 'switcher',
            'title'       => '评论过滤高级设置',
            'default' => false,
            'subtitle'=>'您可以通过开启高级设置对评论区的评论提交做更深层次的过滤。'
        ),
        array(
            'id'       => 'BearSpam_IP',
            'type'     => 'textarea',
            'title'    => '过滤IP',
            'after' => '多条IP请用换行符隔开<br />支持用*号匹配IP段，如：192.168.*.*',
            'dependency' => array( 'BearSpam_Pro', '==', 'true' ),
        ),
        array(
            'id'       => 'BearSpam_EMAIL',
            'type'     => 'textarea',
            'title'    => '过滤邮箱',
            'after' => '多个邮箱请用换行符隔开<br />可以是邮箱的全部，或者邮箱部分关键词',
            'dependency' => array( 'BearSpam_Pro', '==', 'true' ),
        ),
        array(
            'id'       => 'BearSpam_URL',
            'type'     => 'textarea',
            'title'    => '过滤网址',
            'after' => '多个网址请用换行符隔开<br />可以是网址的全部，或者网址部分关键词。如果网址为空，该项不会起作用',
            'dependency' => array( 'BearSpam_Pro', '==', 'true' ),
        ),
        array(
            'id'       => 'BearSpam_ArticleTitle',
            'type'     => 'select',
            'title'    => '过滤含有文章标题的评论',
            'options'  => array('1' => '是',  '2' => '否'),
            'after' => '根据研究表明机器人发表的内容可能含有评论文章的标题',
            'dependency' => array( 'BearSpam_Pro', '==', 'true' ),
        ),
        array(
            'id'       => 'BearSpam_NAME',
            'type'     => 'textarea',
            'title'    => '过滤昵称',
            'after' => '如果评论发布者的昵称含有该关键词，将执行该操作，多个请直接换行',
            'dependency' => array( 'BearSpam_Pro', '==', 'true' ),
        ),
        array(
            'id'       => 'BearSpam_NAMEMIN',
            'type'     => 'number',
            'title'    => '昵称允许的最短长度',
            'unit'     => '个字',
            'subtitle' => '如果评论发布者的昵称小于该最短长度将拦截',
            'dependency' => array( 'BearSpam_Pro', '==', 'true' ),
        ),
        array(
            'id'       => 'BearSpam_NAMEMAX',
            'type'     => 'number',
            'title'    => '昵称允许的最长长度',
            'unit'     => '个字',
            'subtitle' => '如果评论发布者的昵称大于该最长长度将拦截',
            'dependency' => array( 'BearSpam_Pro', '==', 'true' ),
        ),
        array(
            'id'       => 'BearSpam_NAMEURL',
            'type'     => 'select',
            'title'    => '过滤昵称为网址的评论',
            'options'  => array('1' => '是',  '2' => '否'),
            'after' => '根据研究表明机器人发表的评论，昵称很有可能为网址',
            'dependency' => array( 'BearSpam_Pro', '==', 'true' ),
        ),
        array(
            'id'       => 'BearSpam_Chinese',
            'type'     => 'select',
            'title'    => '过滤不包含中文的评论',
            'options'  => array('1' => '是',  '2' => '否'),
            'after' => '当评论内容中没有中文时进行拦截',
            'dependency' => array( 'BearSpam_Pro', '==', 'true' ),
        ),
        array(
            'id'       => 'BearSpam_MIN',
            'type'     => 'number',
            'title'    => '评论内容允许的最短长度',
            'unit'     => '个字',
            'subtitle' => '如果评论发布者的评论内容小于该最短长度将拦截',
            'dependency' => array( 'BearSpam_Pro', '==', 'true' ),
        ),
        array(
            'id'       => 'BearSpam_MAX',
            'type'     => 'number',
            'title'    => '评论内容允许的最长长度',
            'unit'     => '个字',
            'subtitle' => '如果评论发布者的评论内容大于该最长长度将拦截',
            'dependency' => array( 'BearSpam_Pro', '==', 'true' ),
        ),
        array(
            'id'       => 'BearSpam_Words',
            'type'     => 'textarea',
            'title'    => '过滤敏感词',
            'after' => '多个词汇请用换行符隔开',
            'dependency' => array( 'BearSpam_Pro', '==', 'true' ),
        ),
    )
  ) );
  
  CSF::createSection( $prefix, array(
    'title'  => '底部设置',
    'icon'   => 'fas fa-chevron-down',
    'fields' => array(
    array(
        'id'    => 'IcpBa',
        'type'  => 'text',
        'title' => 'ICP备案号',
        'after' => '请填写您网站的ICP备案号,若无ICP备案请为空',
      ),
      array(
        'id'    => 'PoliceBa',
        'type'  => 'text',
        'title' => '公安备案号',
        'after' => '请填写您网站的公安备案号,若无公安备案请为空',
      ),
      array(
            'id'       => 'CustomizationFooterCode',
            'type'     => 'code_editor',
            'title'    => '底部自定义代码',
            'after' => '可放置网站统计代码等<br><font color=red>谨慎填写，仅需填写代码即可！</font>需注意语法，若语法错误可能会造成前台报错甚至组件动作失效！',
        ),
    array(
            'id'       => 'CustomizationFooterJsCode',
            'type'     => 'code_editor',
            'title'    => '底部自定义JS代码',
            'after' => '可放置自定义JS代码等<br><font color=red>谨慎填写，仅需填写代码即可！</font>需注意JS语法，若语法错误可能会造成前台报错甚至组件动作失效！',
        ),
    )
  ) );

  CSF::createSection( $prefix, array(
    'title'  => '友链设置',
    'icon'   => 'fas fa-link',
    'fields' => array(
         array(
            'id'      => 'friendLinks_module',
            'type'    => 'switcher',
            'title'       => '是否开启友情链接区块',
            'after' => '<br><br><font color=red>[仅首页可见]</font> 若开启友情链接区块，则首页将显示友情链接，您可以通过以下选项进行自定义添加',
            'default' => false,
        ),
        array(
            'id'     => 'friendLinks',
            'type'   => 'group',
            'title'  => '友情链接',
            'subtitle' => '您可以通过本项增加友情链接，它将在首页底部显示',
            'dependency' => array( 'friendLinks_module', '==', 'true'),
            'fields' => array(
                array(
        'id'    => 'friendLink_note',
        'type'  => 'text',
        'title' => '友情链接备注',
        'after' => '您可以给该友情链接加个备注，该项仅后台可见',
      ),
      array(
            'id'          => 'friendLink_logo',
            'type'        => 'upload',
            'title'       => '友情链接图标',
            'after' => '请上传友情链接图标或填入友情链接图片直链，尺寸建议60x60'
        ),
            array(
            'id'          => 'friendLink_title',
            'type'        => 'text',
            'title'       => '友情链接名称',
            'after' => '请输入友情链接名称',
        ),
               array(
            'id'          => 'friendLink_desc',
            'type'        => 'text',
            'title'       => '友情链接介绍',
            'after' => '请输入友情链接介绍',
        ),
        array(
            'id'          => 'friendLink_url',
            'type'        => 'text',
            'title'       => '友情链接网址',
            'after' => '请输入友情链接网址，带http(s)://',
        ),
            ),
        ),
        
        
        
        )));
  
  
  
  
CSF::createSection( $prefix, array(
    'title'       => '数据备份',
    'icon'        => 'fas fa-cloud-download-alt',
    'description' => '本主题支持您通过以下功能对您所填写的配置信息进行备份导出，也可以对备份的数据进行导入。',
    'fields'      => array(

        array(
            'type' => 'backup',
        ),

    )
) );

?>

<?php

                $htmls = '
        <div class="ui three steps">
  <div class="step" id="check">
    <i class="tree icon"></i>
    <div class="content">
      <div class="title">检测</div>
    </div>
  </div>
  <div class="disabled step" id="upgrade">
    <i class="angle double right icon"></i>
    <div class="content">
      <div class="title">升级</div>
    </div>
  </div>
  <div class="disabled step" id="finished">
    <i class="info icon"></i>
    <div class="content">
      <div class="title">完成</div>
    </div>
  </div>
</div>
<div id="checkcon">
<div class="ui placeholder segment">
  <div class="ui icon header">
    <i class="cloud icon"></i>
    您可以通过点击以下按钮进行检测是否符合在线升级的条件
  </div>
  <div class="inline">
    <div class="ui button" id="checkbtn">检测版本</div>
  </div>

</div>
  <div id="versiontipss"></div>
</div>
<div id="upgradecon" style="display:none">
<div class="ui placeholder segment">
  <div class="ui icon header">
    <i class="cloud icon"></i>
    检测到最新版本为 V<font id="newversion"></font>，您可以通过点击以下按钮进行在线升级
  </div>
<div class="ui piled segment" style="margin-top:10px;">
  <h4 class="ui header">更新内容</h4>
  <p id="upgradelog"></p>
</div>
  <div class="inline">
    <div class="ui button" id="upgradebtn" style="margin-top:-10px;">立即更新</div>
    
  </div>
 <center><div id="pre-message" style="margin-top:20px;"></div></center>
 <center><div id="progress-message" style="margin-top:20px;"></div></center>
<progress id="progress" value="0" max="100" style="display:none;margin-top:10px;width:100%;max-width:100%;height:20px"></progress> 

</div>
</div>

<div id="finishcon" style="display:none">
<div class="ui placeholder segment">
  <div class="ui icon header">
    <i class="green check icon"></i>
    您已成功升级到最新版本，系统将在三秒后自动刷新~~~
  </div>

</div>
</div>

<script>
//检测
$("#checkbtn").on("click",function(){
$("#checkbtn").addClass("loading").attr("disabled","disabled");
    $.post("https://upgrade.typecho.co.uk/Beardocs/version.php",function(data,status){
switch(status)
{
case "success":
json = JSON.parse(data);
nowversion = "'.themeVersion().'";
if(json.version > nowversion){
$("#versiontipss").html(\'<div class="csf-submessage csf-submessage-warning">检测到有新版本可以更新，3秒钟后自动跳转下一步!</div>\');
$("#newversion").html(json.version);
$.post("https://upgrade.typecho.co.uk/Beardocs/upgrade_log.php",function(data,status){
$("#upgradelog").html(data);
});
setTimeout(function(){
$("#check").addClass("completed");
$("#upgrade").removeClass("disabled");
$("#checkcon").hide();
$("#upgradecon").fadeIn();
},3000);
}
if(json.version == nowversion || json.version < nowversion){
$("#versiontipss").html(\'<div class="csf-submessage csf-submessage-success">当前版本为最新版本，无需更新~<a href="https://docs.whitebear.dev/index.php/archives/10/" target="_blank">查看版本更新日志</a></div>\');
$("#checkbtn").removeClass("loading").removeAttr("disabled","disabled");
}
break;
case "error":
toastr.warning("最新版本获取失败，请稍后重试");
$("#checkbtn").removeClass("loading").removeAttr("disabled","disabled");
break;
case "timeout":
toastr.warning("最新版本获取超时，请稍后重试");
$("#checkbtn").removeClass("loading").removeAttr("disabled","disabled");
break;
}
    });
});

//升级
$("#upgradebtn").on("click",function(){
$("#upgradebtn").addClass("loading").attr("disabled","disabled");

$.ajax({
                        type: "GET",
                        url: "/index.php/bd-upgrade",
                        data: {
                            "action": "prepare-download",
                        },
                        dateType: "json",
                        success: function(json) {
                            json = JSON.parse(json);
                            if(json.code == 0){
                             layer.msg(json.message, {icon: 2});  
                             $("#upgradebtn").removeClass("loading").removeAttr("disabled","disabled");
$("#upgradebtn").css("pointer-events","auto");
                            }
                            else{
                           $("#pre-message").html("升级包大小："+json.filesize+"，预计需要三十秒，请耐心等待~");
                           $("#progress-message").html("升级进度：0%");
                           $("#progress").fadeIn();
                        let x = document.getElementById("progress");   
                        x.setAttribute("value", "1");
                        intervaldown();
                        //设置定时器定时每5秒获取一次升级进度
                        let progressx = setInterval(function(){ 
                        intervalprogress();
                        }, 5000);
                        $("#progress").one("click",function(){
                            clearInterval(progressx);
                            finishUpgrade();
                        })
                            }
                        },
                        error: function() {
alert("升级准备检测失败，请稍后重试");
$("#upgradebtn").removeClass("loading").removeAttr("disabled","disabled");
                        }
                    });
                    
});
function intervaldown(){
$.ajax({
                        type: "GET",
                        url: "/index.php/bd-upgrade",
                        data: {
                            "action": "download",
                        },
                        dateType: "json",
                    });
}
function intervalprogress(){
$.ajax({
                        type: "GET",
                        url: "/index.php/bd-upgrade",
                        data: {
                            "action": "getsize",
                        },
                        dateType: "json",
                        success: function(json) {
                            json = JSON.parse(json);
                           $("#progress-message").html("升级进度："+json.filesize+"%");
let x = document.getElementById("progress");   
                        x.setAttribute("value", json.filesize);
                if(json.filesize == "100"){
                
                $("#progress-message").html("正在进行数据效验，请稍后...");
                setTimeout(function(){
                   $("#progress").click();
},3000);
                }
                        },
                        error: function() {
alert("获取升级进度失败");
                        }
                    });
}
function finishUpgrade(){
$.ajax({
                        type: "GET",
                        url: "/index.php/bd-upgrade",
                        data: {
                            "action": "finish",
                        },
                        dateType: "json",
                        success: function(json) {
$("#upgrade").addClass("completed");
$("#finished").removeClass("disabled");
$("#upgradecon").hide();
$("#finishcon").fadeIn();
setTimeout(function(){
window.parent.location.reload();
},3000);
                        },
                        error: function() {
alert("升级失败");
                        }
                    });
}
</script>
        ';
        
        CSF::createSection( $prefix, array(
    'title'       => '在线升级',
    'icon'        => 'fa fa-cloud-upload-alt',
    
    'fields'      => array(
        array(
            'type'    => 'notice',
            'style'   => 'info',
            'content' => '<strong>注意事项</strong><p> <ul><li>1、若您有开启缓存，那么在升级完成后需要清除一次缓存。</li><li>2、若出现在线升级卡顿无法升级，可能是您的服务器网络到升级节点之间存在异常，则需要手动覆盖升级或者稍等一会再试试。</li><li>3、若升级完毕后出现报错，可尝试通过手动覆盖新版本来进行修复，下载地址:<a href="https://files.bear.dance/Beardocs/Beardocs_v'.themeVersionOnly().'.release.zip">戳这里</a></ul></p>',
        ),
array(
                    'type' =>'content',
                    'content' => $htmls,
                ),
        

    )
) );
}
function themeConfig($form)
{

   ?>
       <?php $all = Typecho_Plugin::export();
       \Widget\Security::alloc()->to($security);?>
<?php if (!array_key_exists('BearDocsCore', $all['activated'])) : ?>
   <div class="update-check message error"><p>检测到未开启BearDocsCore，主题尚处于封印状态，您需要安装启用BearDocsCore核心插件后方能解除封印！<br>当下方出现解除封印按钮时点击按钮后即可解除封印~~~
   <?php if(is_dir(Helper::options()->pluginDir('BearDocsCore'))):?><br><br><button onclick="window.location.href='<?php $security->index('/action/plugins-edit?activate=BearDocsCore'); ?>'"  class="btn">
解除封印</button></p>
</div>
<?php endif;?>
   <?php else:?>
<style>
.body.container{
    max-width:100%!important;
}
</style>
    <link href="<?php echo Helper::options()->themeUrl;?>/assets/plugins/toastr/toastr.min.css" rel="stylesheet">
	<script src="<?php echo Helper::options()->themeUrl;?>/assets/plugins/toastr/toastr.min.js"></script>
        
<?php

    $params = [
        'args'=> [
            'framework_title' => 'BearDocs v'.themeVersionOnly(),
            'footer_text' => '自豪的采用BearDocs主题!',
        ]
    ];
    CSF::setup('beardocs', $params);
    
    ?>
       <?php endif; ?>
       <?php
       CSF::setTypechoOptionForm($form);
       ?>
              <?php if (array_key_exists('BearDocsCore', $all['activated'])) : ?>
          <style>

        .popup{
            all:unset;
            font-size:0; overflow:hidden;
        }
        .message{
            all:unset;
            font-size:0; overflow:hidden;
        }
        .message a{
            all:unset;
            font-size:0; overflow:hidden;
        }
        .success{
            all:unset;
            font-size:0; overflow:hidden;
        }
        .success a{
            all:unset;
            font-size:0; overflow:hidden;
        }
        .message.popup.success{
            all:unset;
            font-size:0; overflow:hidden;
        }
        </style>
           <script>
           window.deactivateURL = '<?php $security->index('/action/plugins-edit?deactivate=BearDocsCore'); ?>';
           window.activateURL = '<?php $security->index('/action/plugins-edit?activate=BearDocsCore'); ?>';
           window.siteUrl = '<?php echo Helper::options()->siteUrl; ?>';
           window.siteName = "<?php echo Helper::options()->title; ?>";
           window.siteDesc = "<?php echo Helper::options()->description; ?>";
           window.siteUrl = "<?php echo Helper::options()->siteUrl; ?>";
           window.useTheme = 'beardocs';
           window.siteToken = '<?php echo General::md5Encode(Helper::options()->siteUrl); ?>7bae2123bear';
        </script>
<?php endif; ?>

       <?php if (!array_key_exists('BearDocsCore', $all['activated'])) : ?>
       
    <script src="'.Helper::options()->themeUrl.'/assets/plugins/jquery/jquery.min.js"></script>
    

   <script>
       $('#wpwrap').hide();
   </script>
   <?php endif; ?>
    <?php
} ?>