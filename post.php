<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php if(General::Options('showThreeColumns') == '' || General::Options('showThreeColumns') == false):?>
<?php $this->need('oneColumnPost.php'); ?>
<?php else:?>
<?php $this->need('threeColumnPost.php'); ?>
<?php endif;?>