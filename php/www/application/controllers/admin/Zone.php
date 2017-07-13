<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 职工圈
 * 
 * @version 0.1
 * @nav TRUE
 * @sort 2
 * @icon fa-life-ring
 * 
 */
class Zone extends AdminBase {

    /**
     * 动态列表
     * 
     * @icon fa-life-ring
     * @nav TRUE
     */
    public function index() {
        $this->load->model(['zone_model']);
        $page = $this->input->post_get('page');
        $page = is_numeric($page) ? $page : 1;
        $this->data['count'] = $this->zone_model->get_count();
        $this->data['list'] = $this->zone_model->get_list($page, $this->limit);
        $this->data['pages'] = ceil($this->data['count'] / $this->limit);
        $this->data['page'] = (int) $page;
        if ($this->input->post_get('keyword')) {
            $this->data['keyword'] = $this->input->post_get('keyword');
        }
        if ($this->input->post_get('usernick')) {
            $this->data['usernick'] = $this->input->post_get('usernick');
        }
        if ($this->input->post_get('date')) {
            $this->data['date'] = $this->input->post_get('date');
        }
        if ($this->input->post_get('userId')) {
            $this->data['userId'] = $this->input->post_get('userId');
        }
        if ($this->input->post_get('fxid')) {
            $this->data['fxid'] = $this->input->post_get('fxid');
        }

        $this->parser->parse($this->data);
    }

    /**
     * 职工圈评论
     * @icon fa-comments-o
     * @nav TRUE
     */
    public function comments() {
        $this->load->model(['zone_comments_model']);
        $page = $this->input->post_get('page');
        $page = is_numeric($page) ? $page : 1;
        $this->data['count'] = $this->zone_comments_model->get_count();
        $this->data['list'] = $this->zone_comments_model->get_list($page, $this->limit);
        $this->data['pages'] = ceil($this->data['count'] / $this->limit);
        $this->data['page'] = (int) $page;
        if ($this->input->post_get('keyword')) {
            $this->data['keyword'] = $this->input->post_get('keyword');
        }
        if ($this->input->post_get('usernick')) {
            $this->data['usernick'] = $this->input->post_get('usernick');
        }
        if ($this->input->post_get('date')) {
            $this->data['date'] = $this->input->post_get('date');
        }
        if ($this->input->post_get('replykeyword')) {
            $this->data['replykeyword'] = $this->input->post_get('replykeyword');
        }
        if ($this->input->post_get('replyusernick')) {
            $this->data['replyusernick'] = $this->input->post_get('replyusernick');
        }
        if ($this->input->post_get('replydate')) {
            $this->data['replyreplydate'] = $this->input->post_get('replydate');
        }
        if ($this->input->post_get('userId')) {
            $this->data['userId'] = $this->input->post_get('userId');
        }
        if ($this->input->post_get('fxid')) {
            $this->data['fxid'] = $this->input->post_get('fxid');
        }

        $this->parser->parse($this->data);
    }

    /**
     * 职工圈点赞
     * @icon fa-thumbs-o-up
     * @nav TRUE
     */
    public function praises() {
        $this->load->model(['zone_praises_model']);
        $page = $this->input->post_get('page');
        $page = is_numeric($page) ? $page : 1;
        $this->data['count'] = $this->zone_praises_model->get_count();
        $this->data['list'] = $this->zone_praises_model->get_list($page, $this->limit);
        $this->data['pages'] = ceil($this->data['count'] / $this->limit);
        $this->data['page'] = (int) $page;
        if ($this->input->post_get('keyword')) {
            $this->data['keyword'] = $this->input->post_get('keyword');
        }
        if ($this->input->post_get('usernick')) {
            $this->data['usernick'] = $this->input->post_get('usernick');
        }
        if ($this->input->post_get('date')) {
            $this->data['date'] = $this->input->post_get('date');
        }
        if ($this->input->post_get('userId')) {
            $this->data['userId'] = $this->input->post_get('userId');
        }
        if ($this->input->post_get('fxid')) {
            $this->data['fxid'] = $this->input->post_get('fxid');
        }

        $this->parser->parse($this->data);
    }

    /**
     * 删除朋友圈
     */
    public function deletezones() {
        $this->load->model('zone_model');
        $this->data['noOperation'] && $this->error('无权限操作');
        $this->zone_model->deletes() ? $this->success('删除成功') : $this->error('删除失败');
    }

    /**
     * 删除朋友圈
     */
    public function deletezone($id) {
        $this->load->model('zone_model');
        $this->data['noOperation'] && $this->error('无权限操作');
        $this->zone_model->delete($id) ? $this->success('删除成功') : $this->error('删除失败');
    }

    /**
     * 删除评论
     */
    public function deletecomments($id) {
        $this->load->model('zone_comments_model');
        $this->data['noOperation'] && $this->error('无权限操作');
        $this->zone_comments_model->deletes($id) ? $this->success('删除成功') : $this->error('删除失败');
    }
     /**
     * 删除评论
     */
    public function deletescomments() {
        $this->load->model('zone_comments_model');
        $this->data['noOperation'] && $this->error('无权限操作');
        $this->zone_comments_model->deletes() ? $this->success('删除成功') : $this->error('删除失败');
    }

    /**
     * 删除评论
     */
    public function deletepraises($id) {
        $this->load->model('zone_praises_model');
        $this->data['noOperation'] && $this->error('无权限操作');
        $this->zone_praises_model->delete($id) ? $this->success('删除成功') : $this->error('删除失败');
    }
     /**
     * 删除评论
     */
    public function deletespraises() {
        $this->load->model('zone_praises_model');
        $this->data['noOperation'] && $this->error('无权限操作');
        $this->zone_praises_model->deletes() ? $this->success('删除成功') : $this->error('删除失败');
    }

}
