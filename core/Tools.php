<?php
//回复可见处理
Typecho_Plugin::factory('Widget_Abstract_Contents')->excerptEx = array('BearToolOne','one');
Typecho_Plugin::factory('Widget_Abstract_Contents')->contentEx = array('BearToolOne','one');
class BearToolOne {
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

public static function get_shortcode_regex2($tagnames = null)
    {
        global $shortcode_tags;
        if (empty($tagnames)) {
            $tagnames = array_keys($shortcode_tags);
        }
        $tagregexp = join('|', array_map('preg_quote', $tagnames));
        return
            '\\{'                           
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
            . '\\}'           
            . '|'
            . '\\}'              
            . '(?:'
            . '('       
            . '[^\\[]*+'  
            . '(?:'
            . '\\[(?!\\/\\2\\])'
            . '[^\\[]*+'
            . ')*+'
            . ')'
            . '\\[\\/\\2\\}'    
            . ')?'
            . ')'
            . '(\\]?)'; 
    }
public static function excerpt_text($content)
    {
        if (strpos($content, '[log') !== false) {
            $pattern = self::get_shortcode_regex(array('log'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        
        return $content;
    }
    public static function one($con,$obj,$text)
    {
      $text = empty($text)?$con:$text;
      
      if(!$obj->is('single')){
       $text = self::excerpt_text($text);
      }

               return $text;
}
}
