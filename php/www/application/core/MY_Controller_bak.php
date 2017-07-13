<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of MY_Controller
 *
 * @author 费尔
 */
class MY_Controller extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library(array('ion_auth', 'parser'));
        $this->load->helper(array('url', 'language'));
        $this->load->database();
        $this->db->query('SET SQL_MODE=ANSI_QUOTES');
        $this->init();
    }

    private function init() {
        $this->load->driver('cache', array('adapter' => 'redis', 'backup' => 'file'));
    }

    /**
     * 操作错误跳转的快捷方法
     * @access protected
     * @param string $message 错误信息
     */
    protected function error($message, $url = '') {
        $this->ajaxReturn($message, 0, '', $url);
    }

    /**
     * 操作成功跳转的快捷方法
     * @access protected
     * @param string $message 提示信息
     */
    protected function success($message, $url = '') {
        $this->ajaxReturn($message, 1, '', $url);
    }

    /**
     * Ajax方式返回数据到客户端
     * @access protected
     * @param mixed $data 要返回的数据
     * @param String $info 提示信息
     * @param boolean $status 返回状态
     */
    protected function ajaxReturn($info = '', int $status = 1, $data = '', $url = '') {
        $result = [];
        $result['status'] = (int) $status;
        if (is_string($info)) {
            $result['info'] = $info;
        }
        $result['url'] = $url;
        if (!empty($data)) {
            $result['data'] = $data;
        }
        if (is_array($info)) {
            $result['data'] = $info;
        }
        $this->showJson($result);
    }

    /**
     * 直接输出json
     * @param mixed $value
     */
    protected function showJson($value) {
        header('Content-type:application/json;charset=utf-8');
        exit(json_encode($value, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 判断是否是通过微信访问
     *
     * @access public
     * @return bool
     */
    protected function isWeixin(): bool {
        return strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ? true : false;
    }

}

class AdminBase extends MY_Controller {

    protected $limit = 15;

    function __construct() {
        parent::__construct();
        $this->init();
    }

    private function init() {



        $this->config->set_item('base_url', '/admin/');


        $this->check_login();
        $this->check_plugin();
    }

    private function check_plugin() {

//        echo $con;
//        echo PHP_EOL;
//        echo $func;
        $class = ucwords(strtolower($this->router->fetch_class()));
        $this->load->model('plugin_model');
        if (!in_array($class, $this->plugin_model->get_noverify()) && !$this->plugin_model->check_plugin($class)) {
            show_error('当前插件未安装或未启用', 500, '遇到一个错误');
        }
    }

    private function check_login() {
        if ($this->router->fetch_class() !== 'auth') {
            if (!$this->ion_auth->logged_in()) {
                redirect('auth/login', 'refresh');
            } elseif (!$this->ion_auth->is_admin()) {
                show_error('您必须是管理员才能查看此页面');
            }
            //企业ID
            defined('COMPANY_ID') or define('COMPANY_ID', $this->session->userdata('company_id'));
            //$this->user_id = $this->session->userdata('user_id');
        }
    }

}

class HomeBase extends MY_Controller {

    protected $limit = 15;

    function __construct() {
        parent::__construct();
        $this->init();
    }

    private function init() {

//         $con = $this->router->fetch_class();
//       $func = $this->router->fetch_method();

        $this->check_company();
        //$this->check_plugin();
    }

    private function check_plugin() {
        $class = ucwords(strtolower($this->router->fetch_class()));
        $this->load->model('plugin_model');
        if (!in_array($class, $this->plugin_model->get_noverify()) && !$this->plugin_model->check_plugin($class)) {
            show_error('当前插件未安装或未启用', 500, '遇到一个错误');
        }
    }

    private function check_company() {
        defined('COMPANY_ID') or define('COMPANY_ID', 1);
    }

}
