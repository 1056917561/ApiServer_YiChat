<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 用户中心
 * 
 * @version 0.1
 * @nav TRUE
 * @sort 2
 * @icon fa-users
 * 
 */
class Users extends AdminBase {

    /**
     * 职员列表
     * 
     * @icon fa-users
     * @nav TRUE
     */
    public function index() {
        $this->load->model(['users_model']);
        $page = $this->input->post_get('page');
        $page = is_numeric($page) ? $page : 1;
        $this->data['count'] = $this->users_model->get_count();
        $this->data['list'] = $this->users_model->get_list($page, $this->limit);
        $this->data['pages'] = ceil($this->data['count'] / $this->limit);
        $this->data['page'] = (int) $page;
        if ($this->input->post_get('tel')) {
            $this->data['tel'] = $this->input->post_get('tel');
        }
        if ($this->input->post_get('userId')) {
            $this->data['userId'] = $this->input->post_get('userId');
        }
        if ($this->input->post_get('fxid')) {
            $this->data['fxid'] = $this->input->post_get('fxid');
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
     * 删除会员
     * 
     * @icon fa-user-secret
     */
    public function deleteusers($id) {
        $this->load->model('users_model');
        $this->data['noOperation'] && $this->error('无权限操作');
        $this->users_model->delete($id) ? $this->success('删除成功') : $this->error('删除失败');
    }

    public function meeting($id) {
        $this->load->model('users_model');
        $this->data['noOperation'] && $this->error('无权限操作');
        $this->db->limit(1)->where('userId', $id)->set(['meetingAuth' => 1])->update('users') ? $this->success('操作成功') : $this->error('操作失败');
    }

    public function activity($id) {//
        $this->load->model('users_model');
        $this->data['noOperation'] && $this->error('无权限操作');
        $this->db->limit(1)->where('userId', $id)->set(['activityAuth' => 1])->update('users') ? $this->success('操作成功') : $this->error('操作失败');
    }

    public function edit($id) {//
        $this->load->model(['users_model']);
        if ($_POST) {
            $this->data['noOperation'] && $this->error('无权限操作');
            switch ($this->users_model->edit($id)) {
                case '-1': $this->error('修改失败');
                case '-2': $this->error('修改失败,该手机号号已存在');
                case '-3': $this->error('修改失败，该慈济号已存在');
                default : $this->success('修改成功');
            }
        }
        $this->data['list'] = $this->db->get_where('users', ['userId' => $id], 1)->row_array();
        $this->data['area'] = $this->db->order_by('id', 'ASC')->get('area')->result_array();
        $this->data['roles'] = $this->db->order_by('id', 'ASC')->get('users_attribute')->result_array();
        $this->data['groups'] = $this->db->order_by('id', 'ASC')->get('users_group')->result_array();
        $this->parser->parse($this->data);
    }

    /**
     * 部门管理
     * 
     * @icon fa-area-chart
     * @nav TRUE
     * @private admin
     */
    public function area() {
        $this->load->model(['users_model']);
        $name = $this->input->post_get('name');
        $id = $this->input->post_get('id');
        if (is_numeric($id)) {
            $this->data['edit'] = $this->users_model->getInfo('area');
        }
        if (!empty($name)) {
            $this->data['noOperation'] && $this->error('无权限操作');
            $this->users_model->addArea() ? $this->success('操作成功') : $this->error('操作失败');
        }
        $page = $this->input->post_get('page');
        $page = is_numeric($page) ? $page : 1;
        $this->data['count'] = $this->users_model->getCount('area');
        $this->data['list'] = $this->users_model->getArealist($page, $this->limit);
        $this->data['pages'] = ceil($this->data['count'] / $this->limit);
        $this->data['page'] = (int) $page;
        $this->parser->parse($this->data);
    }

    /**
     * 删除区域
     * 
     * @icon fa-user-secret
     */
    public function deletearea($id) {
        $this->load->model('users_model');
        $this->data['noOperation'] && $this->error('无权限操作');
        $this->users_model->remove($id, 'area') ? $this->success('删除成功') : $this->error('删除失败');
    }

    /**
     * 部门管理员设置
     * 
     * @icon fa-gear
     * @nav TRUE
     */
    public function setarea() {
        $this->load->model(['users_model']);
        $this->data['user'] = $this->ion_auth->user()->row_array();
        $this->data['area'] = $this->db->order_by('id', 'ASC')->get('area')->result_array();

        $this->data['region'] = $this->data['user']['region'] && $this->data['user']['userId'] ? $this->data['user']['region'] : $this->input->post_get('region');
        $where = [];
        $where['region !='] = '';
        if ($this->data['region']) {
            $where['region'] = $this->data['region'];
        }
        $region = $this->db->get_where('area', ['id' => $this->data['region']], 1)->row_array();
        $this->data['regionName'] = $region['name'];

        if ($this->data['region']) {
            $page = $this->input->post_get('page');
            $page = is_numeric($page) ? $page : 1;
            $this->data['count'] = $this->users_model->get_count(false,true);
            $this->data['list'] = $this->users_model->get_list($page, $this->limit,true);
            $this->data['pages'] = ceil($this->data['count'] / $this->limit);
            $this->data['page'] = (int) $page;
            //echo  $this->data['pages'];
           // print_r($this->data['list']);exit;
        }
        $select = 'auth_users.*,users_attribute.name as roleName';
        $this->db->join('users', 'users.userId = auth_users.userId', 'left');
        $this->db->join('users_attribute', 'users.role = users_attribute.id', 'left');
        $this->data['data'] = $this->db->order_by('auth_users.id', 'ASC')->where($where)->select($select)->get('auth_users')->result_array();

        $this->data['tel'] = $this->input->post_get('tel');
        $this->parser->parse($this->data);
    }

    /*
     * 取消权限
     */

    public function removeadmin() {
        $this->load->model('users_model');
        $this->data['noOperation'] && $this->error('无权限操作');
        if ($this->users_model->remove((int) $this->input->post_get('id'), 'auth_users')) {
            $this->db->limit(1)->where('userId', (int) $this->input->post_get('uid'))->set(['is_admin' => 0])->update('users') ? $this->success('删除成功') : $this->error('删除失败');
        }
    }

    /*
     * 添加区域管理员权限
     */

    public function addadmin($id) {
        $this->load->model(['users_model']);
        $this->data['noOperation'] && $this->error('无权限操作');
        $userdata = $this->db->get_where('users', ['userId' => $id], 1)->row_array();
        if ($userdata) {
            if ($this->db->get_where('auth_users', ['username' => $userdata['tel']], 1)->row_array()) {
                $this->error('该手机号已存在');
            }
            $data = array(
                'username' => $userdata['tel'],
                'password' => $userdata['password'],
                'email' => '',
                'ip_address' => $this->input->ip_address(),
                'created_on' => time(),
                'region' => $userdata['area_id'],
                'userId' => $userdata['userId'],
                'active' => 1,
                'first_name' => $userdata['usernick'],
                'phone' => $userdata['tel']
            );
            if ($this->db->insert('auth_users', $data)) {
                $insert_id = $this->db->insert_id();
                $this->db->insert('auth_users_groups', ['user_id' => $insert_id, 'group_id' => 1]);
                foreach (['Users', 'Zone', 'Activity'] as $values) {
                    $this->db->insert('plugin', ['uid' => $insert_id, 'name' => $values]);
                }
                $this->db->limit(1)->where(['userId' => $id])->set(['is_admin' => 1])->update('users') ? $this->success('操作成功') : $this->error('操作失败');
            }
        }
        $this->error('操作失败');
    }

    /**
     * 职位属性类型
     * 
     * @icon fa-user-circle-o
     * @nav TRUE
     * @private admin
     */
    public function attribute() {
        $this->load->model(['users_model']);
        $name = $this->input->post_get('name');
        $id = $this->input->post_get('id');
        if (is_numeric($id)) {
            $this->data['edit'] = $this->users_model->getInfo('users_attribute');
        }
        if (!empty($name)) {
            $this->data['noOperation'] && $this->error('无权限操作');
            $this->users_model->addAttribute() ? $this->success('操作成功') : $this->error('操作失败');
        }
        $page = $this->input->post_get('page');
        $page = is_numeric($page) ? $page : 1;
        $this->data['count'] = $this->users_model->getCount('users_attribute');
        $this->data['list'] = $this->users_model->getAttributelist($page, $this->limit);
        $this->data['pages'] = ceil($this->data['count'] / $this->limit);
        $this->data['page'] = (int) $page;

        $this->parser->parse($this->data);
    }

    /**
     * 删除属性
     * 
     * @icon fa-user-secret
     */
    public function deleteattribute($id) {
        $this->load->model('users_model');
        $this->data['noOperation'] && $this->error('无权限操作');
        $this->users_model->remove($id) ? $this->success('删除成功') : $this->error('删除失败');
    }

    /**
     * 活动类型
     * 
     * @icon fa-th-large
     * @nav TRUE
     * @private admin
     */
    public function activitytype() {
        $this->load->model(['users_model']);
        $name = $this->input->post_get('name');
        $id = $this->input->post_get('id');
        if (is_numeric($id)) {
            $this->data['edit'] = $this->users_model->getInfo('activity_type');
        }
        if (!empty($name)) {
            $this->data['noOperation'] && $this->error('无权限操作');
            $this->users_model->addActivityType() ? $this->success('操作成功') : $this->error('操作失败');
        }
        $page = $this->input->post_get('page');
        $page = is_numeric($page) ? $page : 1;
        $this->data['count'] = $this->users_model->getCount('activity_type');
        $this->data['list'] = $this->users_model->getActivityTypelist($page, $this->limit);
        $this->data['pages'] = ceil($this->data['count'] / $this->limit);
        $this->data['page'] = (int) $page;

        $this->parser->parse($this->data);
    }

    /**
     * 删除活动类型
     * 
     * @icon fa-user-secret
     */
    public function deleteactivity_type($id) {
        $this->load->model('users_model');
        $this->data['noOperation'] && $this->error('无权限操作');
        $this->users_model->remove($id, 'activity_type') ? $this->success('删除成功') : $this->error('删除失败');
    }

    /**
     * 小组分类
     * 
     * @icon fa-sitemap
     * @nav TRUE
     * @private admin
     */
    public function group() {
        $this->load->model(['users_model']);
        $name = $this->input->post_get('name');
        $id = $this->input->post_get('id');
        if (is_numeric($id)) {
            $this->data['edit'] = $this->users_model->getInfo('users_group');
        }
        if (!empty($name)) {
            $this->data['noOperation'] && $this->error('无权限操作');
            $this->users_model->addGroup() ? $this->success('操作成功') : $this->error('操作失败');
        }
        $page = $this->input->post_get('page');
        $page = is_numeric($page) ? $page : 1;
        $this->data['count'] = $this->users_model->getCount('users_group');
        $this->data['list'] = $this->users_model->getGrouplist($page, $this->limit);
        $this->data['pages'] = ceil($this->data['count'] / $this->limit);
        $this->data['page'] = (int) $page;
        $this->parser->parse($this->data);
    }

    /**
     * 删除分组
     * 
     * @icon fa-user-secret
     */
    public function deletegroup($id) {
        $this->load->model('users_model');
        $this->data['noOperation'] && $this->error('无权限操作');
        $this->users_model->remove($id, 'users_group') ? $this->success('删除成功') : $this->error('删除失败');
    }

    /**
     * 职员审核
     * 
     * @icon fa-user-circle-o
     * @nav TRUE
     */
    public function authvip() {
        $this->load->model(['users_model']);
        if ($this->input->post_get('name')) {
            $this->data['name'] = $this->input->post_get('name');
        }
        if (is_numeric($this->input->post_get('status'))) {
            $this->data['status'] = $this->input->post_get('status');
        }
        $page = $this->input->post_get('page');
        $page = is_numeric($page) ? $page : 1;
        $this->data['count'] = $this->users_model->getAuthvip_count();
        $this->data['list'] = $this->users_model->getAuthvip($page, $this->limit);
        $this->data['pages'] = ceil($this->data['count'] / $this->limit);
        $this->data['page'] = (int) $page;
        $this->parser->parse($this->data);
    }

    /**
     * 身份审核
     */
    public function getAuthvipInfo() {
        $this->load->model(['users_model']);
        $this->data['list'] = $this->users_model->getAuthvipInfo();
        if ((string) $this->input->post_get('action') === 'audit' && $this->input->post_get('id')) {
            $this->data['noOperation'] && $this->error('无权限操作');
            //$this->users_model->AuthvipAudit($this->data['list']) ? $this->success('审核成功') : $this->error('审核失败');
            switch ($this->users_model->AuthvipAudit($this->data['list'])) {
                case 1: $this->success('审核成功');
                case -1: $this->error('母鸡用户不存在');
                case -2: $this->error('身份审核状态修改失败');
                case -3: $this->error('用户信息更新失败');
                case -4: $this->error('审核失败,申请手机号与会员注册手机号不一致');
                case -5: $this->error('审核失败,母鸡不可为自己');
                case -6: $this->error('审核失败,会员不存在');
                default :$this->error('审核失败');
            }
        }
        $this->parser->parse($this->data);
    }

    /**
     * 上下级关系管理
     * 
     * @icon fa-users
     * @nav TRUE
     */
    public function fatherInfo() {
        $this->load->model(['users_model']);
        $this->data = [];
        if ($this->input->post_get('name')) {
            $page = $this->input->post_get('page');
            $page = is_numeric($page) ? $page : 1;
            $this->data['count'] = $this->users_model->get_count();
            $this->data['list'] = $this->users_model->get_list($page, $this->limit);
             $this->data['pages'] = ceil($this->data['count'] / $this->limit);
            $this->data['page'] = (int) $page;
            $this->data['name'] = $this->input->post_get('name');
        }
        $this->parser->parse($this->data);
    }

    /**
     * 母鸡和小鸡
     * 
     */
    public function father() {
        $this->load->model(['users_model']);
        $this->data = [];
        $page = $this->input->post_get('page');
        $page = is_numeric($page) ? $page : 1;
        $this->data['count'] = $this->users_model->getFather_count();
        $this->data['list'] = $this->users_model->getFatherList($page, $this->limit);
        $this->data['page'] = (int) $page;
        if ($this->input->post_get('faid') > 0) {
            $this->data['fatherdata'] = $this->db->get_where('users', ['userId' => $this->input->post_get('faid')], 1)->row_array();
            $role = $this->db->get_where('users_attribute', ['id' => $this->data['fatherdata']['role']], 1)->row_array();
            $this->data['fatherdata']['roleName'] = $role['name'];
        }
        $this->data['userdata'] = $this->db->get_where('users', ['userId' => $this->input->post_get('id')], 1)->row_array();
        $role = $this->db->get_where('users_attribute', ['id' => $this->data['userdata']['role']], 1)->row_array();
        $this->data['userdata']['roleName'] = $role['name'];
        //print_r($this->data['list']);exit;
        $this->parser->parse($this->data);
    }

}
