<?php
namespace TypechoPlugin\BearDocsCore;
use BearDocsCore;
use bdOptions;
use \Utils\Helper;
use Typecho\{Exception, Widget, Db};
use Typecho\Cookie;
use Widget\Options;


if(!class_exists('CSF')){
    require_once Helper::options()->pluginDir('BearDocsCore').'/bdoptions-framework.php';
}

if (!class_exists('bdOptions')){
    require_once \Utils\Helper::options()->pluginDir('BearDocsCore').'/bdOptions.php';
}

class Action extends Widget implements \Widget\ActionInterface
{

 

    /**
     * 初始化
     * @return $this
     */
    
}