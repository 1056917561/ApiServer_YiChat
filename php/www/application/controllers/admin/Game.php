<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 游戏管理
 * @version 0.1
 * @nav TRUE
 * @sort 2
 * @icon fa-life-ring
 * 
 */
class Game extends AdminBase {

    /**
     * 游戏栏目
     * @nav TRUE
     * @icon fa-gamepad
     */
    public function index() {
        $this->load->model(['game_section_model']);
        $page = $this->input->post_get('page');
        $page = is_numeric($page) ? $page : 1;
        $this->data['count'] = $this->game_section_model->get_count();
        $this->data['list'] = $this->game_section_model->get_list($page, $this->limit);
        $this->data['pages'] = ceil($this->data['count'] / $this->limit);
        $this->data['page'] = (int) $page;
        if ($this->input->post_get('pid')) {
            $this->data['pid'] = $this->input->post_get('pid');
        }
        $this->parser->parse($this->data);
    }

    public function channel() {
        $this->load->model(['game_section_model']);
        $page = $this->input->post_get('page');
        $page = is_numeric($page) ? $page : 1;
        $this->data['count'] = $this->game_section_model->get_channel_count();
        $this->data['list'] = $this->game_section_model->get_channel_list($page, $this->limit);
        $this->data['pages'] = ceil($this->data['count'] / $this->limit);
        $this->data['page'] = (int) $page;
        if ($this->input->post_get('pid')) {
            $this->data['pid'] = $this->input->post_get('pid');
        }
        $this->parser->parse($this->data);
    }

    public function services() {
        $this->load->model(['game_section_model']);
        $page = $this->input->post_get('page');
        $page = is_numeric($page) ? $page : 1;
        $this->data['count'] = $this->game_section_model->get_services_count();
        $this->data['list'] = $this->game_section_model->get_services_list($page, $this->limit);
        $this->data['pages'] = ceil($this->data['count'] / $this->limit);
        $this->data['page'] = (int) $page;
        if ($this->input->post_get('pid')) {
            $this->data['pid'] = $this->input->post_get('pid');
        }
        $this->parser->parse($this->data);
    }

    public function system() {
        $this->load->model(['game_section_model']);
        $page = $this->input->post_get('page');
        $page = is_numeric($page) ? $page : 1;
        $this->data['count'] = $this->game_section_model->get_system_count();
        $this->data['list'] = $this->game_section_model->get_system_list($page, $this->limit);
        $this->data['pages'] = ceil($this->data['count'] / $this->limit);
        $this->data['page'] = (int) $page;
        if ($this->input->post_get('pid')) {
            $this->data['pid'] = $this->input->post_get('pid');
        }
        $this->parser->parse($this->data);
    }

    /**
     * 删除
     * @icon fa-apple
     */
    public function delete($id) {
        $this->load->model('game_section_model');
        $this->game_section_model->delete($id) ? $this->success('删除成功') : $this->error('删除失败');
    }

    /**
     * 角色审核
     * @nav TRUE
     * @icon fa-user-circle-o
     */
    public function role() {
        $this->load->model('users_gamerole_model');
        $page = $this->input->post_get('page');
        $page = is_numeric($page) ? $page : 1;
        $this->data['count'] = $this->users_gamerole_model->get_count();
        $this->data['list'] = $this->users_gamerole_model->get_list($page, $this->limit);
        $this->data['pages'] = ceil($this->data['count'] / $this->limit);
        $this->data['page'] = (int) $page;
        if ($this->input->post_get('status')) {
            $this->data['status'] = (int) $this->input->post_get('status');
        }
        $this->parser->parse($this->data);
    }

    public function rolecheck($id) {
        $this->load->model('users_gamerole_model');
        $this->users_gamerole_model->rolecheck($id) ? $this->success('通过成功') : $this->error('通过失败');
    }

    public function roleremove($id) {
        $this->load->model('users_gamerole_model');
        $this->users_gamerole_model->roleremove($id) ? $this->success('驳回成功') : $this->error('驳回失败');
    }

    /**
     * 软件版本
     * @nav TRUE
     * @icon fa-apple
     */
    public function version() {
        $this->load->model(['version_model']);
        $page = $this->input->post_get('page');
        $page = is_numeric($page) ? $page : 1;
        $this->data['count'] = $this->version_model->get_count();
        $this->data['list'] = $this->version_model->get_list($page, $this->limit);
        $this->data['pages'] = ceil($this->data['count'] / $this->limit);
        $this->data['page'] = (int) $page;

        if ($this->input->post_get('name')) {
            $this->data['name'] = $this->input->post_get('name');
        }
        $this->parser->parse($this->data);
    }

    /**
     * 新增版本
     * @icon fa-apple
     */
    public function versionadd() {
        $this->load->model('version_model');
        if ($this->input->method() === 'post' && $this->input->is_ajax_request()) {
            $this->version_model->add_version() ? $this->success('保存成功', site_url('game/version')) : $this->error('保存失败');
        }
        $this->parser->parse();
    }

    /**
     * 新增版本
     * @icon fa-apple
     */
    public function versiondelete($id) {
        $this->load->model('version_model');
        $this->version_model->delete($id) ? $this->success('删除成功') : $this->error('删除失败');
    }

    /**
     * 更新版本
     * @icon fa-apple
     */
    public function versionedit($id) {
        $list = $this->db->get_where('version', ['id' => (int) $id], 1)->row_array();
        empty($list) && show_404();
        if ($this->input->method() === 'post' && $this->input->is_ajax_request()) {
            $this->load->model('version_model');
            $this->version_model->edit($list['id']) ? $this->success('保存成功', site_url('game/version')) : $this->error('保存失败');
        }
        $this->data['list'] = $list;
        $this->parser->parse($this->data);
    }

    /**
     * 新增游戏
     */
    public function gameadd() {
        $this->load->model('game_section_model');
        if ($this->input->method() === 'post' && $this->input->is_ajax_request()) {
            $this->game_section_model->gameadd() ? $this->success('保存成功', site_url('game/index')) : $this->error('保存失败');
        }
        $this->parser->parse();
    }

    /**
     * 更新游戏
     */
    public function gameedit($id) {
        $list = $this->db->get_where('game_section', ['id' => (int) $id], 1)->row_array();
        empty($list) && show_404();
        if ($this->input->method() === 'post' && $this->input->is_ajax_request()) {
            $this->load->model('game_section_model');
            $this->game_section_model->gameedit($list['id']) ? $this->success('保存成功') : $this->error('保存失败');
        }
        $this->data['list'] = $list;
        $this->parser->parse($this->data);
    }

    /**
     * 新增下载渠道
     */
    public function channeladd() {
        $this->load->model('game_section_model');
        $this->data['pid'] = $this->input->post_get('pid');
        empty($this->data['pid']) && show_404();
        if ($this->input->method() === 'post' && $this->input->is_ajax_request()) {
            $this->game_section_model->channeladd() ? $this->success('保存成功', site_url('game/channel') . '?pid=' . $this->input->post_get('pid')) : $this->error('保存失败');
        }

        $this->parser->parse($this->data);
    }

    /**
     * 更新下载渠道
     */
    public function channeledit($id) {
        $list = $this->db->get_where('game_section', ['id' => (int) $id], 1)->row_array();
        empty($list) && show_404();

        $this->data['pid'] = $this->input->post_get('pid');

        empty($this->data['pid']) && show_404();
        if ($this->input->method() === 'post' && $this->input->is_ajax_request()) {
            $this->load->model('game_section_model');
            $this->game_section_model->channeledit($list['id']) ? $this->success('保存成功') : $this->error('保存失败');
        }
        $this->data['list'] = $list;
        $this->parser->parse($this->data);
    }

    /**
     * 新增区服
     */
    public function servicesadd() {
        $this->load->model('game_section_model');
        $this->data['pid'] = $this->input->post_get('pid');
        empty($this->data['pid']) && show_404();
        if ($this->input->method() === 'post' && $this->input->is_ajax_request()) {
            $this->game_section_model->channeladd() ? $this->success('保存成功', site_url('game/services') . '?pid=' . $this->input->post_get('pid')) : $this->error('保存失败');
        }

        $this->parser->parse($this->data);
    }

    /**
     * 更新区服
     */
    public function servicesedit($id) {
        $list = $this->db->get_where('game_section', ['id' => (int) $id], 1)->row_array();
        empty($list) && show_404();

        $this->data['pid'] = $this->input->post_get('pid');

        empty($this->data['pid']) && show_404();
        if ($this->input->method() === 'post' && $this->input->is_ajax_request()) {
            $this->load->model('game_section_model');
            $this->game_section_model->channeledit($list['id']) ? $this->success('保存成功') : $this->error('保存失败');
        }
        $this->data['list'] = $list;
        $this->parser->parse($this->data);
    }

    /**
     * 新增平台
     */
    public function systemadd() {
        $this->load->model('game_section_model');
        $this->data['pid'] = $this->input->post_get('pid');
        empty($this->data['pid']) && show_404();
        if ($this->input->method() === 'post' && $this->input->is_ajax_request()) {
            $this->game_section_model->channeladd() ? $this->success('保存成功', site_url('game/system') . '?pid=' . $this->input->post_get('pid')) : $this->error('保存失败');
        }

        $this->parser->parse($this->data);
    }

    /**
     * 更新平台
     */
    public function systemedit($id) {
        $list = $this->db->get_where('game_section', ['id' => (int) $id], 1)->row_array();
        empty($list) && show_404();

        $this->data['pid'] = $this->input->post_get('pid');

        empty($this->data['pid']) && show_404();
        if ($this->input->method() === 'post' && $this->input->is_ajax_request()) {
            $this->load->model('game_section_model');
            $this->game_section_model->channeledit($list['id']) ? $this->success('保存成功') : $this->error('保存失败');
        }
        $this->data['list'] = $list;
        $this->parser->parse($this->data);
    }

}
