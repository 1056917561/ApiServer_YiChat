<?php

/**
 * 好友
 * @author 费尔
 */
class Friend_model extends CI_Model {

    public function __construct() {
        //连接数据库
        $this->load->database();
    }

    public function addmefriend($uid) {
        if (!$this->db->get_where('friend', ['uid' => $uid, 'friend' => $uid], 1)->row_array()) {
            $this->db->insert('friend', ['uid' => $uid, 'friend' => $uid]);
        }
    }

    /**
     * 新增好友
     * @param int $uid
     */
    public function addfriend($uid, $friend = null) {
        $friend = $friend ?: $this->input->post_get('userId');
        if (is_numeric($friend) && (int) $friend !== (int) $uid) {
            if ($this->db->get_where('friend', ['uid' => $uid, 'friend' => $friend], 1)->row_array()) {
                return 1;
            }
            if (!$this->db->get_where('black', ['uid' => $uid, 'friend' => $friend], 1)->row_array() && $this->db->select('userId')->get_where('users', ['userId' => $friend], 1)->row_array()) {

                !$this->db->get_where('black', ['uid' => $friend, 'friend' => $uid], 1)->row_array() && $this->db->insert('friend', ['uid' => $friend, 'friend' => $uid]);

                $this->db->insert('friend', ['uid' => $uid, 'friend' => $friend]);
                return 1;
            }
        }
        return -1;
    }

    /**
     * 删除好友
     * @param int $uid
     */
    public function removeFriend($uid, $friend = null) {
        $friend = $friend ?: $this->input->post_get('userId');
        if (is_numeric($friend)) {
            $where = [];
            $where['uid'] = $uid;
            $where['friend'] = $friend;
            if ($this->db->limit(1)->where($where)->delete('friend')) {
                $where = [];
                $where['uid'] = $friend;
                $where['friend'] = $uid;
                $this->db->limit(1)->where($where)->delete('friend');
                return 1;
            }
        }
        return -1;
    }

    /**
     * 获取好友列表
     */
    public function fetchFriends($uid, $group_id = 0) {
        //$friend = $this->input->post_get('userId');
        $where = [];
        $where['uid'] = $uid;
        $where['friend !='] = $uid;
//        if (is_numeric($friend)) {
//            $where['friend'] = $friend;
//        }
        $list = $this->db->where($where)->get('friend')->result_array();
        $users = [];
        $i = 0;
        if (!empty($list)) {
//            $users = [];
//            $i = 0;
            foreach ($this->db->where_in('userId', array_column($list, 'friend'))->get('users')->result_array() as $value) {
                $users[$i]['userId'] = $value['userId'];
                $users[$i]['avatar'] = $value['avatar'];
                $users[$i]['nick'] = $value['usernick'];
                $users[$i]['time'] = date('Y-m-d H:i:s', $value['time']);
                $users[$i]['province'] = $value['province'];
                $users[$i]['city'] = $value['city'];
                $users[$i]['fxid'] = $value['fxid'];
                $users[$i]['tel'] = $value['tel'];
                $users[$i]['sex'] = $value['sex'];
                $users[$i]['sign'] = $value['sign'];
                // $users[$i]['password'] = $value['hxpassword'];
                $users[$i]['type'] = $value['type'];
                $users[$i]['role'] = $value['role'];
                $users[$i]['teamId'] = $value['group_id'];
                $users[$i]['fatherId'] = $value['fatherId'];
                $users[$i]['regionId'] = $value['area_id'];
                $users[$i]['meetingAuth'] = $value['meetingAuth'];
                $users[$i]['activityAuth'] = $value['activityAuth'];
                $users[$i]['cardId'] = $value['cardId'];
                $users[$i]['en_show_tel'] = $value['en_show_tel'];
                $users[$i]['en_s_tel'] = $value['en_s_tel'];
                $users[$i]['en_s_fxid'] = $value['en_s_fxid'];
                $i++;
            }
            // return $users;
        }
        //获取分组成员
        if ($group_id > 0) {
            $list = $this->db->where(['group_id' => $group_id])->get('users')->result_array();
            foreach ($list as $value) {
                if ($value['userId'] != $uid) {
                    $users[$i]['userId'] = $value['userId'];
                    $users[$i]['avatar'] = $value['avatar'];
                    $users[$i]['nick'] = $value['usernick'];
                    $users[$i]['time'] = date('Y-m-d H:i:s', $value['time']);
                    $users[$i]['province'] = $value['province'];
                    $users[$i]['city'] = $value['city'];
                    $users[$i]['fxid'] = $value['fxid'];
                    $users[$i]['tel'] = $value['tel'];
                    $users[$i]['sex'] = $value['sex'];
                    $users[$i]['sign'] = $value['sign'];
                    $users[$i]['type'] = $value['type'];
                    $users[$i]['role'] = $value['role'];
                    $users[$i]['teamId'] = $value['group_id'];
                    $users[$i]['fatherId'] = $value['fatherId'];
                    $users[$i]['regionId'] = $value['area_id'];
                    $users[$i]['meetingAuth'] = $value['meetingAuth'];
                    $users[$i]['activityAuth'] = $value['activityAuth'];
                    $users[$i]['cardId'] = $value['cardId'];
                    $users[$i]['en_show_tel'] = $value['en_show_tel'];
                    $users[$i]['en_s_tel'] = $value['en_s_tel'];
                    $users[$i]['en_s_fxid'] = $value['en_s_fxid'];
                    $i++;
                }
            }
        }
        return !empty($users) ? $users : -1;
    }

    /**
     * 获取分组成员
     */
    public function fetchGroupMembers($groupid) {
        $where = [];
        $where['group_id'] = $groupid;
        $list = $this->db->where($where)->get('users')->result_array();
        if (!empty($list)) {
            $users = [];
            $i = 0;
            foreach ($list as $value) {
                $users[$i]['userId'] = $value['userId'];
                $users[$i]['avatar'] = $value['avatar'];
                $users[$i]['nick'] = $value['usernick'];
                $users[$i]['time'] = date('Y-m-d H:i:s', $value['time']);
                $users[$i]['province'] = $value['province'];
                $users[$i]['city'] = $value['city'];
                $users[$i]['fxid'] = $value['fxid'];
                $users[$i]['tel'] = $value['tel'];
                $users[$i]['sex'] = $value['sex'];
                $users[$i]['sign'] = $value['sign'];
                $users[$i]['type'] = $value['type'];
                $users[$i]['role'] = $value['role'];
                $users[$i]['teamId'] = $value['group_id'];
                $users[$i]['fatherId'] = $value['fatherId'];
                $users[$i]['regionId'] = $value['area_id'];
                $users[$i]['meetingAuth'] = $value['meetingAuth'];
                $users[$i]['activityAuth'] = $value['activityAuth'];
                $users[$i]['cardId'] = $value['cardId'];
                $users[$i]['en_show_tel'] = $value['en_show_tel'];
                $users[$i]['en_s_tel'] = $value['en_s_tel'];
                $users[$i]['en_s_fxid'] = $value['en_s_fxid'];
                $i++;
            }
            return $users;
        }
        return -1;
    }

    /**
     * 获取分组成员
     */
    public function fetchEggs($fatherId) {
        $where = [];
        $where['fatherId'] = $fatherId;
        $list = $this->db->where($where)->get('users')->result_array();
        if (!empty($list)) {
            $users = [];
            $i = 0;
            foreach ($list as $value) {
                $users[$i]['userId'] = $value['userId'];
                $users[$i]['avatar'] = $value['avatar'];
                $users[$i]['nick'] = $value['usernick'];
                $users[$i]['time'] = date('Y-m-d H:i:s', $value['time']);
                $users[$i]['province'] = $value['province'];
                $users[$i]['city'] = $value['city'];
                $users[$i]['fxid'] = $value['fxid'];
                $users[$i]['tel'] = $value['tel'];
                $users[$i]['sex'] = $value['sex'];
                $users[$i]['sign'] = $value['sign'];
                $users[$i]['type'] = $value['type'];
                $users[$i]['role'] = $value['role'];
                $users[$i]['teamId'] = $value['group_id'];
                $users[$i]['fatherId'] = $value['fatherId'];
                $users[$i]['regionId'] = $value['area_id'];
                $users[$i]['meetingAuth'] = $value['meetingAuth'];
                $users[$i]['activityAuth'] = $value['activityAuth'];
                $users[$i]['cardId'] = $value['cardId'];
                $users[$i]['en_show_tel'] = $value['en_show_tel'];
                $users[$i]['en_s_tel'] = $value['en_s_tel'];
                $users[$i]['en_s_fxid'] = $value['en_s_fxid'];
                $i++;
            }
            return $users;
        }
        return -1;
    }

    /**
     * 新增黑名单
     * @param int $uid
     */
    public function addBlackList($uid) {
        $friend = $this->input->post_get('userId');
        if (is_numeric($friend)) {
            if (!$this->db->get_where('black', ['uid' => $uid, 'friend' => $friend], 1)->row_array() && $this->db->select('userId')->get_where('users', array('userId' => $friend), 1)->row_array()) {
                if ($this->db->insert('black', ['uid' => $uid, 'friend' => $friend])) {
                    $this->removeFriend($uid, $friend);
                    return 1;
                }
            }
        }
        return -1;
    }

    /**
     * 删除黑名单
     * @param int $uid
     */
    public function removeBlackList($uid) {
        $friend = $this->input->post_get('userId');
        if (is_numeric($friend)) {
            $where = [];
            $where['uid'] = $uid;
            $where['friend'] = $friend;
            if ($this->db->limit(1)->where($where)->delete('black')) {
                $this->addfriend($uid, $friend);
                return 1;
            }
        }
        return -1;
    }

    /**
     * 查询用户是否在黑名单
     * @param int $uid
     */
    public function searchToBlackList($uid) {
        $friend = $this->input->post_get('userId');
        if (is_numeric($friend)) {
            $where = [];
            $where['uid'] = $uid;
            $where['friend'] = $friend;
            return $this->db->limit(1)->where($where)->get('black')->row_array() ? 1 : -1;
        }
        return -1;
    }

    /**
     * 获取黑名单列表
     */
    public function fetchBlackList($uid) {
        $friend = $this->input->post_get('userId');
        $where = [];
        $where['uid'] = $uid;
        if (is_numeric($friend)) {
            $where['friend'] = $friend;
        }
        $list = $this->db->where($where)->get('black')->result_array();
        if (!empty($list)) {
            $users = [];
            $i = 0;
            foreach ($this->db->where_in('userId', array_column($list, 'friend'))->get('users')->result_array() as $value) {
                $users[$i]['userId'] = $value['userId'];
                $users[$i]['avatar'] = $value['avatar'];
                $users[$i]['nick'] = $value['usernick'];
                $users[$i]['time'] = date('Y-m-d H:i:s', $value['time']);
                $users[$i]['province'] = $value['province'];
                $users[$i]['city'] = $value['city'];
                $users[$i]['fxid'] = $value['fxid'];
                $users[$i]['tel'] = $value['tel'];
                $users[$i]['sex'] = $value['sex'];
                $users[$i]['sign'] = $value['sign'];
                $users[$i]['password'] = $value['hxpassword'];
                $users[$i]['type'] = $value['type'];
                $users[$i]['role'] = $value['role'];
                $users[$i]['teamId'] = $value['group_id'];
                $users[$i]['fatherId'] = $value['fatherId'];
                $users[$i]['regionId'] = $value['area_id'];
                $users[$i]['meetingAuth'] = $value['meetingAuth'];
                $users[$i]['activityAuth'] = $value['activityAuth'];
                $users[$i]['cardId'] = $value['cardId'];
                $users[$i]['en_show_tel'] = $value['en_show_tel'];
                $users[$i]['en_s_tel'] = $value['en_s_tel'];
                $users[$i]['en_s_fxid'] = $value['en_s_fxid'];
                $i++;
            }
            return $users;
        }
        return -1;
    }

}
