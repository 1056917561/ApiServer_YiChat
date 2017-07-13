<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 活动管理
 * 
 * @version 0.1
 * @nav TRUE
 * @sort 2
 * @icon fa-flag-checkered
 * 
 */
class Activity extends AdminBase {

    /**
     * 活动列表
     * 
     * @icon fa-flag
     * @nav TRUE
     */
    public function index() {
        $this->load->model(['activity_model']);
        $page = $this->input->post_get('page');
        $page = is_numeric($page) ? $page : 1;
        $this->data['count'] = $this->activity_model->get_count();
        $this->data['list'] = $this->activity_model->get_list($page, $this->limit);
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

        $this->parser->parse($this->data);
    }

    /**
     * 活动评论列表
     * 
     * @icon fa-comments-o
     * @nav 
     */
    public function comments() {
        $this->load->model(['activity_comments_model']);
        $page = $this->input->post_get('page');
        $page = is_numeric($page) ? $page : 1;
        $this->data['count'] = $this->activity_comments_model->get_count();
        $this->data['list'] = $this->activity_comments_model->get_list($page, $this->limit);
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

        $this->parser->parse($this->data);
    }

    /**
     * 已打卡|已报名
     * 
     */
    public function punchCard() {
        if ($this->input->post_get('keyword')) {
            $this->data['keyword'] = $this->input->post_get('keyword');
        }
        if ($this->input->post_get('usernick')) {
            $this->data['usernick'] = $this->input->post_get('usernick');
        }
        if ($this->input->post_get('date')) {
            $this->data['date'] = $this->input->post_get('date');
        }
        $this->load->model(['activity_model']);
        $page = $this->input->post_get('page');
        $page = is_numeric($page) ? $page : 1;
        if ((string) $this->input->post_get('act') === 'clock') {
            $this->data['count'] = $this->activity_model->getClock_count();
            $this->data['list'] = $this->activity_model->getActivityClockList($page, $this->limit);
        } else {
            $this->data['count'] = $this->activity_model->getJoin_count();
            $this->data['list'] = $this->activity_model->getActivityJoinList($page, $this->limit);
        }

        $this->data['pages'] = ceil($this->data['count'] / $this->limit);
        $this->data['page'] = (int) $page;
        $this->data['act'] = $this->input->post_get('act');
        $this->data['aid'] = $this->input->post_get('id');
        $this->parser->parse($this->data);
    }
    /**
     * 删除活动
     */
    public function delete($id) {
        $this->load->model('activity_model');
        $this->data['noOperation'] && $this->error('无权限操作');
        $this->activity_model->remove($id) ? $this->success('删除成功') : $this->error('删除失败');
    }

}
