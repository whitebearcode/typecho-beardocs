<?php 

/**
 * 
 *   BearDocs 解析工具类
 *   Update at 2023/07/26
 * 
*/

class Parse{
    
    public static function get_shortcode_atts_regex()
    {
        return '/([\w-]+)\s*=\s*"([^"]*)"(?:\s|$)|([\w-]+)\s*=\s*\'([^\']*)\'(?:\s|$)|([\w-]+)\s*=\s*([^\s\'"]+)(?:\s|$)|"([^"]*)"(?:\s|$)|\'([^\']*)\'(?:\s|$)|(\S+)(?:\s|$)/';
    }
    
    public static function shortcode_parse_atts($text)
    {
        $atts = array();
        $pattern = self::get_shortcode_atts_regex();
        $text = preg_replace("/[\x{00a0}\x{200b}]+/u", ' ', $text);
        if (preg_match_all($pattern, $text, $match, PREG_SET_ORDER)) {
            foreach ($match as $m) {
                if (!empty($m[1])) {
                    $atts[strtolower($m[1])] = stripcslashes($m[2]);
                } elseif (!empty($m[3])) {
                    $atts[strtolower($m[3])] = stripcslashes($m[4]);
                } elseif (!empty($m[5])) {
                    $atts[strtolower($m[5])] = stripcslashes($m[6]);
                } elseif (isset($m[7]) && strlen($m[7])) {
                    $atts[] = stripcslashes($m[7]);
                } elseif (isset($m[8]) && strlen($m[8])) {
                    $atts[] = stripcslashes($m[8]);
                } elseif (isset($m[9])) {
                    $atts[] = stripcslashes($m[9]);
                }
            }
            foreach ($atts as &$value) {
                if (false !== strpos($value, '<')) {
                    if (1 !== preg_match('/^[^<]*+(?:<[^>]*+>[^<]*+)*+$/', $value)) {
                        $value = '';
                    }
                }
            }
        } else {
            $atts = ltrim($text);
        }
        return $atts;
    }
    


    public static function get_shortcode_regex($tagnames = null)
    {
        global $shortcode_tags;
        if (empty($tagnames)) {
            $tagnames = array_keys($shortcode_tags);
        }
        $tagregexp = join('|', array_map('preg_quote', $tagnames));
        return
            '\\['                           
            . '(\\[?)'                        
            . "($tagregexp)"       
            . '(?![\\w-])'                    
            . '('                         
            . '[^\\]\\/]*'               
            . '(?:'
            . '\\/(?!\\])'     
            . '[^\\]\\/]*'          
            . ')*?'
            . ')'
            . '(?:'
            . '(\\/)'                    
            . '\\]'           
            . '|'
            . '\\]'              
            . '(?:'
            . '('       
            . '[^\\[]*+'  
            . '(?:'
            . '\\[(?!\\/\\2\\])'
            . '[^\\[]*+'
            . ')*+'
            . ')'
            . '\\[\\/\\2\\]'    
            . ')?'
            . ')'
            . '(\\]?)'; 
    }
    
    //版本回调
    public static function parseChangeLogCallback($matches)
{
    $attr = htmlspecialchars_decode($matches[3]);
    $attrs = self::shortcode_parse_atts($attr);
    $date = $attrs['date'];
    $version = $attrs['version'];
    $type = $attrs['type'];
    $matches[5] = preg_replace("/<a href=.*?>(.*?)<\/a>/",'$1',$matches[5]);
    $matches[5] = preg_replace("/<ul>/",'<ul class="uk-list">',$matches[5]);
     $matches[5] = preg_replace("/<br>/",'',$matches[5],1);
    return <<<EOF
              <div class="tm-timeline-entry">
                <div class="tm-timeline-time">
                  <h5>{$date}</h5>
                </div>
                <div class="tm-timeline-body">
                  <h3 class="uk-flex uk-flex-middle">{$version}<span class="uk-label uk-margin-small-left">{$type}</span>
                  </h3>
                  $matches[5]
                </div>
              </div>
         
EOF;

}
    public static function wrapTablesWithContainer($html) {
    // 正则表达式匹配所有<table>标签及其内容
    $pattern = '/<table\b[^>]*>(.*?)<\/table>/si';
    
    // 替换为带容器的表格
    $replacement = '<div class="table-scroll-container">$0</div>';
    
    return preg_replace($pattern, $replacement, $html);
}

    public static function ParseContent($content){
       
        //增加灯箱
        $pattern = '/<\s*img[\s\S]+?(?:src=[\'"]([\S\s]*?)[\'"]\s*|alt=[\'"]([\S\s]*?)[\'"]\s*|[a-z]+=[\'"][\S\s]*?[\'"]\s*)+[\s\S]*?>/i';
   
 $replacement = '
  <img class="lazyload lazyload-style-2" data-fancybox="image" data-caption="$2"  src="data:image/svg+xml;base64,PCEtLUFyZ29uTG9hZGluZy0tPgo8c3ZnIHdpZHRoPSIxIiBoZWlnaHQ9IjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgc3Ryb2tlPSIjZmZmZmZmMDAiPjxnPjwvZz4KPC9zdmc+" data-src="$1" alt="$2" style="border-radius:8px;cursor: zoom-in;width:100%;height:auto;margin:10px 0 10px 0;">'; 
    $content = preg_replace($pattern, $replacement, $content);
    if (strpos($content, '[log') !== false) {
            $pattern = self::get_shortcode_regex(array('log'));
            $content = '<div class="tm-timeline uk-margin-large-top">'.preg_replace_callback("/$pattern/", 'self::parseChangeLogCallback', $content).'</div>';
    }
     $content = self::wrapTablesWithContainer($content);
     
     $content = preg_replace_callback("/<a href=\"(.*?)\">(.*?)<\/a>/is", function ($matches){
           $options = Helper::options();
            if (strpos($matches[1],$options->siteUrl) !== false || strpos(substr($matches[1],0,6),"http") === false){
                return '<a class="link-post"  href="'.$matches[1].'"><spans uk-icon="icon:link"></spans>'.$matches[2].'</a>';
            }else{
               
                return '<a class="link-post"  href="'.$matches[1].'" target="_blank"><spans uk-icon="icon:link"></spans>'.$matches[2]."</a>";
               
            }
        }, $content);
    
        
        return $content;
    }
   public static function getAttachFile(){
    $getAttachFile = Helper::options()->siteUrl.'index.php/write';
    echo $getAttachFile;
}
    
}