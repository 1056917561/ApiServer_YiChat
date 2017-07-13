<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Plugin extends AdminBase {


    public function index() {
        
        $this->data['plugin'] = $this->plugin_model->init_plugin(__DIR__);
        $this->parser->parse($this->data);
    }

    /**
     * 安装
     */
    public function install($name) {
        $this->plugin_model->install($name) ? $this->success('安装成功', site_url('plugin/index')) : $this->error('安装失败');
    }

    /**
     * 卸载
     */
    public function delete($name) {
        $this->plugin_model->delete($name) ? $this->success('卸载成功', site_url('plugin/index')) : $this->error('卸载失败');
    }

}
