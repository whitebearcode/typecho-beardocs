<?php 

/**
 * 
 *   BearDocs 基础工具类
 *   Update at 2023/10/28
 * 
*/
class General
{
    
    //文本截断
    public static function cutexpert($string, $length='20', $dot = '…'){
    $_lenth = mb_strlen($string, "utf-8");
    $text_str = preg_replace(array("/<pre><code.*?>/si","/<img.*?>/si"),"",$string);
    $text_lenth = mb_strlen($text_str, "utf-8") - 1;
    if($text_lenth <= $length) {
        return strip_tags(stripcslashes($text_str));
    }
    else{
        $res = mb_substr($text_str, 0, $length, 'UTF-8');
        return strip_tags(stripcslashes($res)).$dot;
    }
    }
    
    //获取主题控制项值
    public static function Options($key, $default = false){
    $options = bdOptions::getInstance()::get_option('beardocs');
    return $options[$key];
    }
    
    //获取指定文章标签
    public static function tags($widget, $split = '', $default = NULL)
{

    if ($widget->tags) {
        $result = array();
        $result[] = '<li class="list-inline-item mt-2">•</li>
                 <li class="list-inline-item mt-2">
                <ul class="card-meta-tag list-inline">';
        $i=0;
        foreach ($widget->tags as $tag) {
        if($i>=3) break;
        $result[] .= '<li class="list-inline-item small"><a href="'.$tag['permalink'].'">#'.$tag['name'].'</a></li>';
        $i++;
        }
 $result[] .= '</ul></li>';
        echo implode($split,$result);
    } else {
        echo $default;
    }
}
    
    //获取文章所有标签
    public static function getPostAllTags($widget, $split = '', $default = NULL)
{

    if ($widget->tags) {
        $result = array();
        $result[] = '<ul class="post-meta-tag list-unstyled list-inline mt-5">
          <li class="list-inline-item">标签: </li>';
        foreach ($widget->tags as $tag) {
        $result[] .= '<li class="list-inline-item"><a class="bg-white" href="'.$tag['permalink'].'">#'.$tag['name'].'</a></li>';
        }
 $result[] .= '</ul>';
        echo implode($split,$result);
    } else {
        echo $default;
    }
}


     //获取指定文章阅读时长
     public static function readTime($cid){
    $db=Typecho_Db::get ();
    $rs=$db->fetchRow ($db->select ('table.contents.text')->from ('table.contents')->where ('table.contents.cid=?',$cid)->order ('table.contents.cid',Typecho_Db::SORT_ASC)->limit (1));
    $text = preg_replace("/[^\x{4e00}-\x{9fa5}]/u", "", $rs['text']);
    $text_word = mb_strlen($text,'utf-8');
    echo ceil($text_word / 400);
}

    //获取文章阅读时间
    public static function publishTime($time){
        $rtime = date("Y年m月d日 H:i", $time);
        $htime = date("H:i", $time);
        $time = time() - $time;
        if ($time < 60) {
            $str = '刚刚';
        } elseif ($time < 60 * 60) {
            $min = floor($time / 60);
            $str = $min . '分钟前';
        } elseif ($time < 60 * 60 * 24) {
            $h = floor($time / (60 * 60));
            $str = $h . '小时前 ' . $htime;
        } elseif ($time < 60 * 60 * 24 * 3) {
            $d = floor($time / (60 * 60 * 24));
            if ($d == 1){
                $ztime = time() - $time;
       $zztime = date("H:i", $ztime);
                $str = '昨天 ' . $zztime;
            }else{
                $qtime = time() - $time;
       $qqtime = date("H:i", $qtime);
                $str = '前天 ' . $qqtime;
        }} else {
            $str = $rtime;
        }
         return $str;
    }
   
   //获取随机图
    public static function randPic($cid){
        return 'https://api.1314.cool/bingimg?'.$cid;
    }

   //获取文章头图
    public static function firstThumb($obj) {
    //获取附件首张图片
	$attach = $obj->attachments(1)->attachment;
	//获取文章首张图片
	preg_match_all("/\<img.*?src\=\"(.*?)\"[^>]*>/i", $obj->content, $thumbUrl);
	$img_src = $thumbUrl[1][0];
	// 获取自定义随机图片
	$thumbs = explode("|",self::Options('diy_thumb'));
	// 获取文章封面
	$cover = $obj->fields->cover;

	if($cover){
	    $thumb = $cover;
	}elseif(isset($attach->isImage) && $attach->isImage == 1){
		$thumb = $attach->url;
	}else if($img_src){
		$thumb = $img_src;
	}else if(!empty(self::Options('diy_thumb')) && count($thumbs)>0){
		$thumb = $thumbs[rand(0,count($thumbs)-1)].$rand;
	}
	else{
	    $thumb = 'https://api.1314.cool/bingimg?'.$obj->cid;
	}
	
	
	return $thumb;
}


   //获取指定邮箱的头像
    public static function getAvatar($email){
        $email = md5($email);
        return "//cravatar.cn/avatar/" . $email;
    }
    
    //获取自定义摘要
    public static function getExcerpt($content, $limit)
    {
        if($limit == 0) {
            return "";
        } else {
            if (trim($content) == "") {
                return "暂时没有可提供的摘要";
            } else {
                return \Typecho\Common::subStr(strip_tags($content), 0, $limit, "...");
            }
        }
    }
    
   //获取自定义字段
   public static function getCustomFields($cid, $key){
    $db = Typecho_Db::get();
    $rows = $db->fetchAll($db->select('table.fields.str_value')->from('table.fields')
        ->where('table.fields.cid = ?', $cid)
        ->where('table.fields.name = ?', $key)
    );
    foreach ($rows as $row) {
        $value = $row['str_value'];
        if (!empty($value)) {
            $values[] = $value;
        }
    }
    return $values;
}

   //获取字段中的所有数字
   public static function parseNumber($str){
    return preg_replace("/[^0-9]/", "", $str);
}

   //获取一言
   public static function getHitokoto($c = 'default'){
 $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'https://v1.hitokoto.cn/');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    curl_setopt($curl, CURLOPT_POST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    $data = curl_exec($curl);
    curl_close($curl);
    $datas = json_decode($data,true);
    if($c = 'default'){
    return '“ '.$datas['hitokoto'] . ' ”';
    }
    else{
    return $datas['hitokoto'];    
    }
}
   //获取随机文章
    public static function getRandomPosts(){
$db = \Typecho\Db::get();
$result = $db->fetchAll($db->select()->from('table.contents')
->where('status = ?','publish')
->where('type = ?', 'post')
->where('created < ?', Helper::options()->time)
->offset(2)
->limit(2)
);
if($result){
    $html = array();
        $html[] = '<div class="single-post-similer">
      <div class="row justify-content-center">
        <div class="col-lg-12">
          <div class="text-center">
            <h2 class="section-title">
              <span>推荐一看</span>
            </h2>
          </div>
          <div class="row gy-5 gx-4 g-xl-5">';
foreach($result as $val){
    
$val = \Typecho\Widget::widget('Widget_Abstract_Contents')->push($val);
if(!$val['hidden']){
$post_title = htmlspecialchars($val['title']);
$permalink = $val['permalink'];
$date = self::publishTime($var['created']);
$md = new Markdown();
$targetSummary = self::getExcerpt($md::convert($val['text']), 30);
$expert = self::getCustomFields($val['cid'], 'excerpt');
                if($expert){
                    $targetSummary = $expert[0];
                }
$targetSummary = trim(strip_tags($targetSummary));
			$targetSummary = preg_replace('/\\s+/',' ',$targetSummary);
			if(!$targetSummary){
			    $targetSummary = '本篇文章暂无摘要~';
			}
     
$html[] = '
                    <div class="col-lg-6">
              <article class="card post-card h-100 border-0 bg-transparent">
                <div class="card-body">
                  <a class="d-block" href="'.$permalink.'" title="'.$post_title.'">
                    <div class="post-image position-relative">
                      <img class="w-100 h-auto rounded" src="'.self::randPic($val['cid']).'" alt="'.$post_title.'" width="970" height="500">
                    </div>
                  </a>
                 
                  <a class="d-block" href="'.$permalink.'"
                    title="'.$post_title.'">
                    <h3 class="mb-3 post-title">
                      '.$post_title.'
                    </h3>
                  </a>
                   <ul class="card-meta list-inline mb-3">
                    <li class="list-inline-item mt-2">
                      <i class="ti ti-calendar-event"></i>
                      <span>'.$date.'</span>
                    </li>
                  
                  </ul>
                  <p>'.$targetSummary.'</p>
                </div>
                
              </article>
            </div>
                    ';
}
}
    $html[] .= '</div></div></div></div>';
        echo implode('',$html);
}
}
    //获取分类设置
    public static function getCategoryDescriptionData($text)
{
    $data = [];
    $data = json_decode($text,true);
    if(!$data['icon']){
    
    $data['icon'] = 'cog';
    $data['desc'] = $text;
    
    }
    return $data;
}
   
   //获取分类ID
   public static function getCategoryId($slug){
   $db = Typecho_Db::get();
   $postnum=$db->fetchRow($db->select()->from ('table.metas')->where ('slug=?',$slug)->where('type=?', 'category'));
   return $postnum['mid']; 
}

    public static function md5Encode($data){
    return md5("bearsimplev2!@#$%^&*()-=+@#$%$".$data."bearsimplev2!@#$%^&*()-=+@#$%$");
}
    
    public static function apiRet($type){
    switch($type){
       case 'search':
          return Helper::options()->siteUrl.'index.php/bd-search';
         break; 
    }
        
}

}