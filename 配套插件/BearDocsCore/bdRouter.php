<?php
/**
 * Rules
 * https://www.bearnotion.ru/
 */
namespace TypechoPlugin\BearDocsCore;

require_once 'functions/defines.php';
require_once 'bdoptions-framework.php';
use CSF;
use Utils\Helper;

global $cfs_options;
$cfs_options = [];

class bdRouter extends \Typecho\Widget
{

    public static function initRouter()
    {
        Helper::addRoute('saveBDoptions', '/bdoptions/save', __CLASS__, 'saveBDoptions');
        Helper::addRoute('saveBDoptions_ajax', '/bdoptions/ajax', __CLASS__, 'saveBDoptionsByAjax');
       
    }

    public static function removeRouter()
    {
        Helper::removeRoute('saveBDoptions');
        Helper::removeRoute('saveBDoptions_ajax');
    }

    public function saveBDoptions()
    {
        $user = \Typecho\Widget::widget('Widget_User');
        if (!$user->hasLogin()) {
            echo '用户未登录';
            die();
        }

        // Set variables.
        $plugin = $this->request->get('plugin');

        $obj = get_bd_key_params($plugin);
        $obj->set_options(true);
        $this->response->goBack();
    }

    public function saveBDoptionsByAjax()
    {
        $user = \Typecho\Widget::widget('Widget_User');
        if (!$user->hasLogin()) {
            $data = [
                'data' => [
                    'notice' => '未登录',
                    'errors' => []
                ],
                'success' => false
            ];
            $this->response->throwJson($data);
        }

        $action = $this->request->get('action', null);
        if (!$action) {
            $data = [
                'data' => [
                    'notice' => '参数错误',
                    'errors' => []
                ],
                'success' => false
            ];
            $this->response->throwJson($data);
        }
        if (preg_match('/csf_(.*)_ajax_save/i', $action)) {
            $data = json_decode($_POST['data'], true);
            $plugin = $data['plugin'];


            $obj = get_bd_key_params($plugin);
            $ret = $obj->set_options(true);

            if ($ret and empty($obj->errors)) {
                $data = [
                    'data' => [
                        'notice' => $obj->notice,
                        'errors' => $obj->errors
                    ],
                    'success' => true
                ];
                $this->response->throwJson($data);
            } else {
                $data = [
                    'data' => [
                        'notice' => $obj->notice,
                        'errors' => $obj->errors
                    ],
                    'success' => true
                ];
                $this->response->throwJson($data);
            }

        } else {
            $action = str_replace('-', '_', $action);
            CSF::include_plugin_file('functions/actions.php');
            $action($this->response);
        }

    }
}

