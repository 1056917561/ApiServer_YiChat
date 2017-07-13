<?php

/**
 * 用户
 * @author 费尔
 */
class Users_model extends CI_Model {

    public function __construct() {
//连接数据库
        $this->load->database();
    }

    /**
     * 注册
     */
    public function register() {
        $data = [];
        $data['tel'] = $this->input->post_get('usertel');
        $data['password'] = sha1($this->input->post_get('password'));
        $data['usernick'] = $this->input->post_get('usernick');
        $data['avatar'] = $this->input->post_get('avatar');
        $data['time'] = time();
        if (!empty($data['tel']) && !empty($data['password']) && preg_match('/^13[0-9]{1}\d{8}|14[57]{1}\d{8}|15[012356789]{1}\d{8}|17[0678]{1}\d{8}|18[0-9]{1}\d{8}$/', $data['tel'])) {
            $query = $this->db->select('userId')->get_where('users', array('tel' => $data['tel']), 1);
            $list = $query->row_array();
            if (!empty($list['userId'])) {
                return -1;
            }
            if ($this->db->insert('users', $data)) {
                $users = [];
                $users['userId'] = $this->db->insert_id();
                $users['avatar'] = $data['avatar'];
                $users['nick'] = $data['usernick'];
                $users['time'] = date('Y-m-d H:i:s', $data['time']);
                $users['tel'] = $data['tel'];
                $users['sex'] = '';
                $users['sign'] = '';
                $users['province'] = '';
                $users['city'] = '';
                $users['fxid'] = '';
                $users['role'] = 1;
                $users['myTeam'] = 0;
                $users['fatherId'] = 0;
                $users['myBigRegion'] = 0;
                $users['meetingAuth'] = 0;
                $users['activityAuth'] = 0;
                $users['cardId'] = '';

                $users['password'] = $this->makePassword();
                $users['session'] = $this->getSession($users['userId']);

                $users['en_show_tel'] = 1;
                $users['en_s_tel'] = 1;
                $users['en_s_fxid'] = 1;

//$easemob = $this->easemob()->createUser($users['userId'], $users['password']);
//if (isset($easemob['entities'])) {
                $this->db->limit(1)->where('userId', $users['userId'])->set(['hxpassword' => $users['password']])->update('users');
//}
                $this->load->model('friend_model');
                $this->friend_model->addmefriend($users['userId']);

                return $users;
            }
        }
        return -2;
    }

    /**
     * 登录
     */
    public function login() {
        $where = [];
        $where['tel'] = $this->input->post_get('usertel');

        if (!empty($where['tel']) && preg_match('/^13[0-9]{1}\d{8}|14[57]{1}\d{8}|15[012356789]{1}\d{8}|17[0678]{1}\d{8}|18[0-9]{1}\d{8}$/', $where['tel'])) {
            $query = $this->db->get_where('users', $where, 1);
            $list = $query->row_array();

            if (!empty($list['userId'])) {

                if ($list['password'] !== sha1($this->input->post_get('password'))) {
                    return -2;
                }

                $users = [];
                $users['userId'] = $list['userId'];
                $users['avatar'] = $list['avatar'];
                $users['nick'] = $list['usernick'];
                $users['time'] = date('Y-m-d H:i:s', $list['time']);
                $users['province'] = $list['province'];
                $users['city'] = $list['city'];
                $users['fxid'] = $list['fxid'];
                $users['tel'] = $list['tel'];
                $users['sex'] = $list['sex'];
                $users['sign'] = $list['sign'];
                $users['role'] = $list['role'];
                $users['activityAuth'] = $list['activityAuth'];
                $users['meetingAuth'] = $list['meetingAuth'];
                $users['fatherId'] = $list['fatherId'];
                $users['myTeam'] = $list['group_id'];
                $users['myBigRegion'] = $list['area_id'];
                $users['cardId'] = $list['cardId'];
                $users['en_show_tel'] = $list['en_show_tel'];
                $users['en_s_tel'] = $list['en_s_tel'];
                $users['en_s_fxid'] = $list['en_s_fxid'];
                if (empty($list['hxpassword'])) {
                    $users['password'] = $this->makePassword();
                    $easemob = $this->easemob()->createUser($users['userId'], $users['password']);
                    if (isset($easemob['entities'])) {
                        $this->db->limit(1)->where('userId', $users['userId'])->set(['hxpassword' => $users['password']])->update('users');
                    }
                } else {
                    $users['password'] = $list['hxpassword'];
                }
                $users['session'] = $this->getSession($list['userId']);
                $this->load->model('friend_model');
                $this->friend_model->addmefriend($users['userId']);
                return $users;
            }
        }
        return -1;
    }

    /**
     * 第三方登录
     */
    public function thirdlogin() {
        $data = [];
        $type = $this->input->post_get('type');
        $openID = $this->input->post_get('openID');
        $avatar = $this->input->post_get('avatar');
        $nickname = $this->input->post_get('nickname');
        $where = [];
        if (empty($type) || empty($openID)) {
            return -1;
        }
        $where['type'] = $type;
        $where['openID'] = $openID;
        $query = $this->db->get_where('users', $where, 1);
        $list = $query->row_array();

        if (empty($list['userId'])) {
            $data['type'] = $type;
            $data['openID'] = $openID;
            $data['usernick'] = $nickname;
            $data['avatar'] = $avatar;
            $data['time'] = time();

            if ($this->db->insert('users', $data)) {
                $users = [];
                $users['userId'] = $this->db->insert_id();
                $users['avatar'] = $data['avatar'];
                $users['nick'] = $data['usernick'];
                $users['time'] = date('Y-m-d H:i:s', $data['time']);
                $users['password'] = $this->makePassword();
                $users['session'] = $this->getSession($users['userId']);
                $users['tel'] = '';
                $users['sex'] = '';
                $users['sign'] = '';
                $users['province'] = '';
                $users['city'] = '';
                $users['fxid'] = '';
                $users['role'] = 1;
                $users['myTeam'] = 0;
                $users['fatherId'] = 0;
                $users['myBigRegion'] = 0;
                $users['meetingAuth'] = 0;
                $users['activityAuth'] = 0;
                $users['cardId'] = '';
                $users['en_show_tel'] = 1;
                $users['en_s_tel'] = 1;
                $users['en_s_fxid'] = 1;
                $easemob = $this->easemob()->createUser($users['userId'], $users['password']);
                if (isset($easemob['entities'])) {
                    $this->db->limit(1)->where('userId', $users['userId'])->set(['hxpassword' => $users['password']])->update('users');
                }
                $this->load->model('friend_model');
                $this->friend_model->addmefriend($users['userId']);
                return $users;
            }
        } else {
            $users = [];
            $users['userId'] = $list['userId'];
            $users['avatar'] = $list['avatar'];
            $users['nick'] = $list['usernick'];
            $users['time'] = date('Y-m-d H:i:s', $list['time']);
            $users['province'] = $list['province'];
            $users['city'] = $list['city'];
            $users['fxid'] = $list['fxid'];
            $users['tel'] = $list['tel'];
            $users['sex'] = $list['sex'];
            $users['sign'] = $list['sign'];
            $users['role'] = $list['role'];
            $users['myTeam'] = $list['group_id'];
            $users['fatherId'] = $list['fatherId'];
            $users['myBigRegion'] = $list['area_id'];
            $users['meetingAuth'] = $list['meetingAuth'];
            $users['activityAuth'] = $list['activityAuth'];
            $users['cardId'] = $list['cardId'];
            $users['en_show_tel'] = 1;
            $users['en_s_tel'] = 1;
            $users['en_s_fxid'] = 1;
            if (empty($list['hxpassword'])) {
                $users['password'] = $this->makePassword();
                $easemob = $this->easemob()->createUser($users['userId'], $users['password']);
                if (isset($easemob['entities'])) {
                    $this->db->limit(1)->where('userId', $users['userId'])->set(['hxpassword' => $users['password']])->update('users');
                }
            } else {
                $users['password'] = $list['hxpassword'];
            }
            $users['session'] = $this->getSession($list['userId']);
            $this->load->model('friend_model');
            $this->friend_model->addmefriend($users['userId']);
// $this->db->limit(1)->where('userId', $list['userId'])->set(['avatar' => $avatar, 'usernick' => $nickname])->update('users');

            return $users;
        }
    }

    /**
     * 搜索用户
     */
    public function searchUser($uid) {
        $userId = $this->input->post_get('userId');
        if (!empty($userId)) {
            // $this->db->or_where(['tel' => $userId, 'en_s_tel' => 1])->or_where(['userId' => $userId])->or_where(['fxid' => $userId, 'en_s_fxid' => 1]);
            $this->db->where("tel = '" . $userId . "' && en_s_tel = 1 OR userId='" . $userId . "' OR fxid='" . $userId . " ' && en_s_fxid=1");
            $list = $this->db->limit(1)->get('users')->row_array();
            if (!empty($list)) {
                $where = [];
                $where['uid'] = $list['userId'];
                $where['friend'] = $uid;
                if (!$this->db->limit(1)->where($where)->get('black')->row_array()) {
                    $users = [];
                    $users['userId'] = $list['userId'];
                    $users['avatar'] = $list['avatar'];
                    $users['nick'] = $list['usernick'];
                    $users['time'] = date('Y-m-d H:i:s', $list['time']);
                    $users['province'] = $list['province'];
                    $users['city'] = $list['city'];
                    $users['fxid'] = $list['fxid'];
                    $users['tel'] = $list['tel'];
                    $users['sex'] = $list['sex'];
                    $users['sign'] = $list['sign'];
                    $users['password'] = $list['hxpassword'];
                    $users['role'] = $list['role'];
                    $users['teamId'] = $list['group_id'];
                    $users['fatherId'] = $list['fatherId'];
                    $users['regionId'] = $list['area_id'];
                    $users['meetingAuth'] = $list['meetingAuth'];
                    $users['activityAuth'] = $list['activityAuth'];
                    $users['cardId'] = $list['cardId'];
                    $users['en_show_tel'] = $list['en_show_tel'];
                    $users['en_s_tel'] = $list['en_s_tel'];
                    $users['en_s_fxid'] = $list['en_s_fxid'];
                    return $users;
                }
            }
        }

        return 0;
    }

    /**
     * userId或者凡信Id查找用户
     */
    public function getUserInfo() {
        $userId = $this->input->post_get('userId');
        if (!empty($userId)) {
            $where = [];
            if (preg_match('/^13[0-9]{1}\d{8}|14[57]{1}\d{8}|15[012356789]{1}\d{8}|17[0678]{1}\d{8}|18[0-9]{1}\d{8}$/', $userId)) {
                $where['tel'] = $userId;
            } elseif (is_numeric($userId)) {
                $where['userId'] = $userId;
            }
            if (!empty($where)) {
                $list = $this->db->get_where('users', $where, 1)->row_array();
                if (!empty($list)) {
                    $users = [];
                    $users['userId'] = $list['userId'];
                    $users['avatar'] = $list['avatar'];
                    $users['nick'] = $list['usernick'];
                    $users['time'] = date('Y-m-d H:i:s', $list['time']);
                    $users['province'] = $list['province'];
                    $users['city'] = $list['city'];
                    $users['fxid'] = $list['fxid'];
                    $users['tel'] = $list['tel'];
                    $users['sex'] = $list['sex'];
                    $users['sign'] = $list['sign'];
                    $users['password'] = $list['hxpassword'];
                    $users['role'] = $list['role'];
                    $users['activityAuth'] = $list['activityAuth'];
                    $users['meetingAuth'] = $list['meetingAuth'];
                    $users['fatherId'] = $list['fatherId'];
                    $users['teamId'] = $list['group_id'];
                    $users['regionId'] = $list['area_id'];
                    $users['cardId'] = $list['cardId'];
                    $users['en_show_tel'] = $list['en_show_tel'];
                    $users['en_s_tel'] = $list['en_s_tel'];
                    $users['en_s_fxid'] = $list['en_s_fxid'];
                    return $users;
                }
            }
        }
        return 0;
    }

    /**
     * 重置密码
     */
    public function resetPassword($uid) {
        if (isset($_REQUEST['tel']))
            $tel = $this->input->post_get('tel');
        if (isset($_REQUEST['newPassword']))
            $newPassword = $this->input->post_get('newPassword');

        if (!empty($newPassword) && !empty($tel) && preg_match('/^13[0-9]{1}\d{8}|14[57]{1}\d{8}|15[012356789]{1}\d{8}|17[0678]{1}\d{8}|18[0-9]{1}\d{8}$/', $tel)) {
            $where = [];
            $data = [];
            $where['tel'] = $tel;
            if ($this->db->get_where('users', $where, 1)->row_array()) {
                $data['password'] = sha1($newPassword);
                return $this->db->limit(1)->where($where)->set($data)->update('users') ? 1 : 0;
            }
            return 0;
        }
    }

    /**
     * 更新
     * - nick     昵称
     * - sex      性别
     * - fxid     用户设置的凡信ID
     * - avatar   头像
     * - province 省份
     * - city     城市
     * - sign     签名
     * - en_show_tel 是否显示手机号
     * - en_s_fxid   是否通过慈济号搜索到我
     * - en_s_tel    是否通过手机号搜索到我
     */
    public function update($uid) {
        $data = [];
        if (isset($_REQUEST['sign']))
            $data['sign'] = $this->input->post_get('sign');
        if (isset($_REQUEST['avatar']))
            $data['avatar'] = $this->input->post_get('avatar');
        if (isset($_REQUEST['sex']))
            $data['sex'] = $this->input->post_get('sex');
        if (isset($_REQUEST['nick']))
            $data['usernick'] = $this->input->post_get('nick');

        if (isset($_REQUEST['province']))
            $data['province'] = $this->input->post_get('province');
        if (isset($_REQUEST['city']))
            $data['city'] = $this->input->post_get('city');
        if (isset($_REQUEST['fxid']))
            $data['fxid'] = $this->input->post_get('fxid');
        if (isset($_REQUEST['tel']))
            $data['tel'] = $this->input->post_get('tel');

        if (isset($_REQUEST['en_show_tel']))
            $data['en_show_tel'] = (int) $this->input->post_get('en_show_tel');
        if (isset($_REQUEST['en_s_fxid']))
            $data['en_s_fxid'] = (int) $this->input->post_get('en_s_fxid');
        if (isset($_REQUEST['en_s_tel']))
            $data['en_s_tel'] = (int) $this->input->post_get('en_s_tel');

        if (!empty($data['tel']) && preg_match('/^13[0-9]{1}\d{8}|14[57]{1}\d{8}|15[012356789]{1}\d{8}|17[0678]{1}\d{8}|18[0-9]{1}\d{8}$/', $data['tel'])) {
            $where = [];
            $where['tel'] = $data['tel'];
            $where['userId !='] = $uid;

            if ($this->db->select('userId')->get_where('users', $where, 1)->row_array()) {
                return -2;
            }
        }
        if (!empty($data['fxid'])) {
            $where = [];
            $where['fxid'] = $data['fxid'];
            $where['userId !='] = $uid;

            if ($this->db->select('userId')->get_where('users', $where, 1)->row_array()) {
                return -3;
            }
        }

        return !empty($data) && $this->db->limit(1)->where('userId', $uid)->set($data)->update('users') ? 1 : -1;
    }

    /**
     * 更新
     */
    public function edit($uid) {
        $data = [];
        if (isset($_REQUEST['area_id']))
            $data['area_id'] = $this->input->post_get('area_id');
        if (isset($_REQUEST['group_id']))
            $data['group_id'] = $this->input->post_get('group_id');
        if (isset($_REQUEST['role']))
            $data['role'] = $this->input->post_get('role');
        if (isset($_REQUEST['sign']))
            $data['sign'] = $this->input->post_get('sign');
        if (isset($_REQUEST['sex']))
            $data['sex'] = $this->input->post_get('sex');
        if (isset($_REQUEST['usernick']))
            $data['usernick'] = $this->input->post_get('usernick');
        if (isset($_REQUEST['province']))
            $data['province'] = $this->input->post_get('province');
        if (isset($_REQUEST['city']))
            $data['city'] = $this->input->post_get('city');
        if (isset($_REQUEST['fxid']))
            $data['fxid'] = $this->input->post_get('fxid');
        if (isset($_REQUEST['tel']))
            $data['tel'] = $this->input->post_get('tel');

        if (!empty($data['tel']) && preg_match('/^13[0-9]{1}\d{8}|14[57]{1}\d{8}|15[012356789]{1}\d{8}|17[0678]{1}\d{8}|18[0-9]{1}\d{8}$/', $data['tel'])) {
            $where = [];
            $where['userId !='] = $uid;
            $where['tel'] = $data['tel'];
            if ($this->db->select('userId')->get_where('users', $where, 1)->row_array()) {
                return -2;
            }
        }
        if (!empty($data['fxid'])) {
            $where = [];
            $where['fxid'] = $data['fxid'];
            $where['userId !='] = $uid;

            if ($this->db->select('userId')->get_where('users', $where, 1)->row_array()) {
                return -3;
            }
        }
        return !empty($data) && $this->db->limit(1)->where('userId', $uid)->set($data)->update('users') ? 1 : -1;
    }

    public function getSession($uid) {
        mt_srand((double) microtime() * 10000);
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45); // "-"
        $uuid = substr($charid, 0, 8) . $hyphen
                . substr($charid, 8, 4) . $hyphen
                . substr($charid, 12, 4) . $hyphen
                . substr($charid, 16, 4) . $hyphen
                . substr($charid, 20, 12);
        $this->db->replace('session', ['uid' => $uid, 'session' => $uuid]);
        return $uuid;
    }

    public function checkSession() {
        $query = $this->db->select('uid')->get_where('session', array('session' => $this->input->post_get('session')), 1);
        return $query->row_array()['uid'] ?? 0;
    }

    public function easemob() {
        $options = [];
        $options['client_id'] = 'YXA66RgNkNlEEea_pOVMHuoIhQ';
        $options['client_secret'] = 'YXA6Y248VwyZOGuTJHENzVuZ3pPxYWc';
        $options['org_name'] = 'tingyi123';
        $options['app_name'] = 'fanchat';
        $this->load->library('easemob', $options);
        return $this->easemob;
    }

    /**
     * 随机密码
     * @param int $length
     * @return string
     */
    public function makePassword($length = 6) {
        $password = '';
        //将你想要的字符添加到下面字符串中，默认是数字0-9和26个英文字母
        $chars = "123456789123456789123456789";
        $char_len = strlen($chars);
        for ($i = 0; $i < $length; $i++) {
            $loop = mt_rand(0, ($char_len - 1));
            //将这个字符串当作一个数组，随机取出一个字符，并循环拼接成你需要的位数
            $password .= $chars[$loop];
        }
        return $password;
    }

    public function getFather_count() {
        $id = $this->input->post_get('id');
        $list = $this->db->limit(1)->where(['fatherId' => $id])->select('COUNT(DISTINCT c_users.userId) AS userscount')->get('users')->row_array();
        return !empty($list['userscount']) ? $list['userscount'] : 0;
    }

    public function getFatherList($page = 1, $limit = 20) {
        $fatherid = $this->input->post_get('faid');
        $id = $this->input->post_get('id');
        $offset = (int) (($page - 1) * $limit);
        $this->db->limit($limit, $offset);
        $select = 'users.*,users_group.name as groupName,users_attribute.name as roleName,area.name as areaName';
        $this->db->join('users_attribute', 'users.role = users_attribute.id', 'left');
        $this->db->join('users_group', 'users.group_id = users_group.id', 'left');
        $this->db->join('area', 'users.area_id = area.id', 'left');
        $list = $this->db->group_by('users.userId')->order_by('users.userId', 'DESC')->where(['fatherId' => $id])->select($select)->get('users')->result_array();
        if (!empty($list)) {
            for ($index = 0; $index < count($list); $index++) {
                $list[$index]['time'] = date('Y-m-d H:i:s', $list[$index]['time']);
            }
        }
        return $list;
    }

    /**
     * 返回动态列表
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function get_list($page = 1, $limit = 20, $is_admin = false) {
        $where = [];
        $userlist = $this->ion_auth->user()->row_array();
        if ($userlist['region']) {
            $where['users.area_id'] = $userlist['region'];
        }
        $this->db->where($where);
        if ($this->input->post_get('userId')) {
            $this->db->like('users.userId', $this->input->post_get('userId'));
        }
        if ($this->input->post_get('fxid')) {
            $this->db->like('users.fxid', $this->input->post_get('fxid'));
        }

        if ($this->input->post_get('date')) {
            $date = $this->input->post_get('date');
            if (date('Y-m-d', strtotime($date)) === $date) {
                $this->db->where(['users.time >=' => strtotime($date . ' 00:00:00')])->where(['users.time <=' => strtotime($date . ' 23:59:59')]);
            }
        }

        if ($this->input->post_get('tel')) {
            $this->db->like('users.tel', $this->input->post_get('tel'));
        }
        if ($this->input->post_get('usernick')) {
            $this->db->like('users.usernick', $this->input->post_get('usernick'));
        }
        if ($this->input->post_get('name')) {
            $this->db->like('users.usernick', $this->input->post_get('name'));
            $this->db->where(['users.role !=' => 1]);
        }
        if ($this->input->post_get('region')) {
            $this->db->where(['users.area_id' => $this->input->post_get('region')]);
            $this->db->where(['users.is_admin' => 0]);
        }
        if ($is_admin) {
            $this->db->where(['users.is_admin' => 0]);
        }

        $offset = (int) (($page - 1) * $limit);
        $this->db->limit($limit, $offset);


        //$select = 'users.*';
        $select = 'users.*,users_group.name as groupName,users_attribute.name as roleName,area.name as areaName';
        $this->db->join('users_attribute', 'users.role = users_attribute.id', 'left');
        $this->db->join('users_group', 'users.group_id = users_group.id', 'left');
        $this->db->join('area', 'users.area_id = area.id', 'left');

        $list = $this->db->group_by('users.userId')->order_by('users.userId', 'DESC')->select($select)->get('users')->result_array();
        $this->load->model('friend_model');
        if (!empty($list)) {
            $cids = [];
            for ($index = 0; $index < count($list); $index++) {
                $cids[] = (int) $list[$index]['userId'];
                $list[$index]['time'] = date('Y-m-d H:i:s', $list[$index]['time']);

                $list[$index]['friends'] = $this->friend_model->fetchFriends($list[$index]['userId'], $list[$index]['group_id']);
                $list[$index]['blacks'] = $this->friend_model->fetchBlackList($list[$index]['userId']);
                //上级
                if ($list[$index]['fatherId']) {
                    $data = $this->db->get_where('users', ['userId' => $list[$index]['fatherId']], 1)->row_array();
                    $list[$index]['fatherName'] = $data['usernick'] ?: $data['tel'];
                }
            }
        }
        return $list;
    }

    /**
     * 返回动态总数
     * @return int
     */
    public function get_count($type = false, $is_admin = false) {
        $where = [];
        $userlist = $this->ion_auth->user()->row_array();
        if ($userlist['region']) {
            $where['users.area_id'] = $userlist['region'];
        }
        $this->db->where($where);
        if ($this->input->post_get('userId')) {
            $this->db->like('users.userId', $this->input->post_get('userId'));
        }
        if ($this->input->post_get('fxid')) {
            $this->db->like('users.fxid', $this->input->post_get('fxid'));
        }

        if ($this->input->post_get('date')) {
            $date = $this->input->post_get('date');
            if (date('Y-m-d', strtotime($date)) === $date) {
                $this->db->where(['users.time >=' => strtotime($date . ' 00:00:00')])->where(['users.time <=' => strtotime($date . ' 23:59:59')]);
            }
        }
        if ($this->input->post_get('keyword')) {
            $this->db->like('users.content', $this->input->post_get('keyword'));
        }
        if ($this->input->post_get('tel')) {
            $this->db->like('users.tel', $this->input->post_get('tel'));
        }
        if ($this->input->post_get('usernick')) {
            $this->db->like('users.usernick', $this->input->post_get('usernick'));
        }
        if ($this->input->post_get('name')) {
            $this->db->like('users.usernick', $this->input->post_get('name'));
            $this->db->where(['users.role !=' => 1]);
        }
        if ($this->input->post_get('region')) {
            $this->db->where(['users.area_id' => $this->input->post_get('region')]);
            $this->db->where(['users.is_admin' => 0]);
        }
        if ($is_admin) {
            $this->db->where(['users.is_admin' => 0]);
        }


        $list = $this->db->limit(1)->select('COUNT(DISTINCT c_users.userId) AS userscount')->get('users')->row_array();
        return !empty($list['userscount']) ? $list['userscount'] : 0;
    }

    /**
     * 删除
     * @param int $id
     */
    public function delete($id) {
        if (is_numeric($id)) {

            $this->db->trans_start();
            $this->db->limit(1)->where(['userId' => (int) $id])->delete('users');
            $this->db->where(['userId' => (int) $id])->delete('zone');
            $this->db->where(['uid' => (int) $id])->delete('zone_comments');
            $this->db->where(['uid' => (int) $id])->delete('zone_praises');

            $this->db->trans_complete();

            return $this->db->trans_status() ? TRUE : FALSE;
        }
        return FALSE;
    }

    /**
     * 返回区域列表
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function getArealist($page = 1, $limit = 20) {
        $where = [];
        $this->db->where($where);
        $offset = (int) (($page - 1) * $limit);
        $this->db->limit($limit, $offset);
        $select = 'area.*';
        $list = $this->db->group_by('area.id')->order_by('area.id', 'DESC')->select($select)->get('area')->result_array();
        return $list;
    }

    /*
     * 增加区域
     */

    public function addArea() {
        $data = [];
        if (isset($_REQUEST['name']))
            $data['name'] = $this->input->post_get('name');
        $id = $this->input->post_get('id');
        return !empty($data) && (is_numeric($id) ? $this->db->limit(1)->where('id', $id)->set($data)->update('area') : $this->db->insert('area', $data)) ? 1 : -1;
    }

    /**
     * 返回属性列表
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function getAttributelist($page = 1, $limit = 20) {
        $where = [];
        $this->db->where($where);
        $offset = (int) (($page - 1) * $limit);
        $this->db->limit($limit, $offset);
        $select = 'users_attribute.*';
        $list = $this->db->group_by('users_attribute.id')->order_by('users_attribute.id', 'DESC')->select($select)->get('users_attribute')->result_array();
        return $list;
    }

    /*
     * 增加/修改属性
     */

    public function addAttribute() {
        $data = [];
        if (isset($_REQUEST['name']))
            $data['name'] = $this->input->post_get('name');
        $id = $this->input->post_get('id');
        return !empty($data) && (is_numeric($id) ? $this->db->limit(1)->where('id', $id)->set($data)->update('users_attribute') : $this->db->insert('users_attribute', $data)) ? 1 : -1;
    }

    /**
     * 返回小组分类
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function getGrouplist($page = 1, $limit = 20) {
        $where = [];
        $this->db->where($where);
        $offset = (int) (($page - 1) * $limit);
        $this->db->limit($limit, $offset);
        $select = 'users_group.*';
        $list = $this->db->group_by('users_group.id')->order_by('users_group.id', 'DESC')->select($select)->get('users_group')->result_array();
        return $list;
    }

    /*
     * 增加分组
     */

    public function addGroup() {
        $data = [];
        if (isset($_REQUEST['name']))
            $data['name'] = $this->input->post_get('name');
        $id = $this->input->post_get('id');
        return !empty($data) && (is_numeric($id) ? $this->db->limit(1)->where('id', $id)->set($data)->update('users_group') : $this->db->insert('users_group', $data)) ? 1 : -1;
    }

    /**
     * 删除表单数据
     * @param int $id
     */
    public function remove($id, $table = 'users_attribute') {
        if (is_numeric($id)) {
            $this->db->trans_start();
            $this->db->limit(1)->where(['id' => (int) $id])->delete($table);
            if ((string) $table === 'auth_users') {
                $this->db->where(['uid' => (int) $id])->delete('plugin');
            }
            $this->db->trans_complete();
            return $this->db->trans_status() ? TRUE : FALSE;
        }
        return FALSE;
    }

    /*
     * 获取详情
     */

    public function getInfo($table = 'users') {
        $id = $this->input->post_get('id');
        if (is_numeric($id)) {
            $where = [];
            $where['id'] = $id;
            if (!empty($where)) {
                $list = $this->db->get_where($table, $where, 1)->row_array();
                return $list;
            }
        }
        return 0;
    }

    /**
     * 返回列表总数
     * @return int
     */
    public function getCount($table = 'users') {
        $where = [];
        $this->db->where($where);
        $list = $this->db->limit(1)->select('COUNT(DISTINCT c_' . $table . '.id) AS count')->get($table)->row_array();
        return !empty($list['count']) ? $list['count'] : 0;
    }

    /**
     * 认证会员
     */
    public function authVIP($uid) {
        $data = [];
        $data['userId'] = $uid;
        $data['userTel'] = $this->input->post_get('tel');
        $data['username'] = $this->input->post_get('username');
        $data['cardId'] = $this->input->post_get('cardId');
        $data['role'] = $this->input->post_get('role');
        $data['area_id'] = $this->input->post_get('bigRegionId');
        $data['province'] = $this->input->post_get('province');
        $data['city'] = $this->input->post_get('city');
        $data['group_id'] = $this->input->post_get('teamId');
        $data['fatherTel'] = $this->input->post_get('faterTel');
        $data['fatherName'] = $this->input->post_get('faterName');
        $data['sex'] = $this->input->post_get('sex');
        $data['time'] = time();
        if (!empty($data['username']) && !empty($data['userTel'])) {
//            $query = $this->db->select('userId')->get_where('users', array('tel' => $data['userTel']), 1);
//            $list = $query->row_array();
//            if ((int) $list['userId'] !== (int) $uid) {
//                return -1;
//            }
            return $this->db->insert('users_identity', $data) ? 1 : 0;
        }
        return -2;
    }

    /**
     * 返回身份申请
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function getAuthvip($page = 1, $limit = 20) {
        $where = [];
        $userlist = $this->ion_auth->user()->row_array();
        if ($userlist['region']) {
            $where['users.area_id'] = $userlist['region'];
        }
        $this->db->where($where);
        if ($this->input->post_get('name')) {
            $this->db->like('users_identity.username', $this->input->post_get('name'));
        }
        switch ($this->input->post_get('status')) {
            case 1:$this->db->where(['users_identity.status' => 1]);
                break;
            case 2:$this->db->where(['users_identity.status' => 2]);
                break;
            default :$this->db->where(['users_identity.status' => 0]);
                break;
        }
        if (in_array($this->input->post_get('status'), [0, 1, 2])) {
            $this->db->where(['users_identity.status >=' => $this->input->post_get('status') === 1 ? 1 : 0]);
        }

        $offset = (int) (($page - 1) * $limit);
        $this->db->limit($limit, $offset);
        $select = 'users_identity.id,users_identity.username,users_identity.userTel,users_identity.status,users_identity.time';
        $this->db->join('users', 'users_identity.userId = users.userId', 'left');
        $list = $this->db->order_by('users_identity.time', 'DESC')->select($select)->get('users_identity')->result_array();
        for ($index = 0; $index < count($list); $index++) {
            $list[$index]['time'] = date('Y-m-d H:i:s', $list[$index]['time']);
        }
        return $list;
    }

    /**
     * 返回身份申请总数
     * @return int
     */
    public function getAuthvip_count($type = false) {
        $where = [];
        $userlist = $this->ion_auth->user()->row_array();
        if ($userlist['region']) {
            $where['users.area_id'] = $userlist['region'];
        }
        $this->db->where($where);
        if ($this->input->post_get('name')) {
            $this->db->like('users_identity.username', $this->input->post_get('name'));
        }
        switch ($this->input->post_get('status')) {
            case 1:$this->db->where(['users_identity.status' => 1]);
                break;
            case 2:$this->db->where(['users_identity.status' => 2]);
                break;
            default :$this->db->where(['users_identity.status' => 0]);
                break;
        }
        $this->db->join('users', 'users_identity.userId = users.userId', 'left');
        $list = $this->db->limit(1)->select('COUNT(DISTINCT c_users_identity.id) AS count')->get('users_identity')->row_array();
        return !empty($list['count']) ? $list['count'] : 0;
    }

    /**
     * 返回身份申请详情
     * @return array
     */
    public function getAuthvipInfo() {
        $id = $this->input->post_get('id');
        if (is_numeric($id)) {
            $where = [];
            $where['users_identity.id'] = (int) $id;
            if (!empty($where)) {
                $select = 'users_identity.*,users_group.name as groupName,users_attribute.name as roleName,area.name as areaName';
                $this->db->join('users_attribute', 'users_identity.role = users_attribute.id', 'left');
                $this->db->join('users_group', 'users_identity.group_id = users_group.id', 'left');
                $this->db->join('area', 'users_identity.area_id = area.id', 'left');
                $list = $this->db->select($select)->get_where('users_identity', $where, 1)->row_array();
                $list['time'] = date('Y-m-d H:i:s', $list['time']);
                return $list;
            }
        }
        return 0;
    }

    public function AuthvipAudit($info) {
        $data = [];
        if ($info['fatherTel']) {
            $list = $this->db->select('userId')->get_where('users', ['tel' => $info['fatherTel']], 1)->row_array();

            if (empty($list) || $list['userId'] == $info['userId']) { //
                $this->db->limit(1)->where('id', $info['id'])->set(['status' => 2])->update('users_identity');
                return empty($list) ? -1 : -5;
            }
            $data['fatherId'] = $list['userId'];
        }
        $user = $this->db->select('tel')->get_where('users', ['userId' => $info['userId']], 1)->row_array();
        if (empty($user) || $user['tel'] != $info['userTel']) {//
            $this->db->limit(1)->where('id', $info['id'])->set(['status' => 2])->update('users_identity');
            return empty($user) ? -6 : -4;
        }
        $data['cardId'] = $info['cardId'];
        $data['role'] = $info['role'];
        $data['area_id'] = $info['area_id'];
        $data['province'] = $info['province'];
        $data['city'] = $info['city'];
        $data['group_id'] = $info['group_id'];
        $data['sex'] = $info['sex'];
        $data['usernick'] = $info['username'];

        if ($this->db->limit(1)->where('tel', $info['userTel'])->set($data)->update('users')) {
            return $this->db->limit(1)->where('id', $info['id'])->set(['status' => 1])->update('users_identity') ? 1 : -2;
        }
        $this->db->limit(1)->where('id', $info['id'])->set(['status' => 2])->update('users_identity');
        return -3;
    }

    /**
     * 返回活动类型
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function getActivityTypelist($page = 1, $limit = 20) {
        $where = [];
        $this->db->where($where);
        $offset = (int) (($page - 1) * $limit);
        $this->db->limit($limit, $offset);
        $select = 'activity_type.*';
        $list = $this->db->group_by('activity_type.id')->order_by('activity_type.id', 'DESC')->select($select)->get('activity_type')->result_array();
        return $list;
    }

    /*
     * 增加活动
     */

    public function addActivityType() {
        $data = [];
        if (isset($_REQUEST['name']))
            $data['name'] = $this->input->post_get('name');
        $id = $this->input->post_get('id');
        return !empty($data) && (is_numeric($id) ? $this->db->limit(1)->where('id', $id)->set($data)->update('activity_type') : $this->db->insert('activity_type', $data)) ? 1 : -1;
    }

    /*
     * 上传用户最近上线时间戳
     */

    public function updateLoginTime($uid) {
        $data = [];
        // if (isset($_REQUEST['localTimestamp']))
        //    $data['lastloginTimes'] = $this->input->post_get('localTimestamp');
        $data['lastloginTimes'] = time();
        return !empty($data) && is_numeric($uid) ? ($this->db->limit(1)->where('userId', $uid)->set($data)->update('users') ? 1 : 0) : -1;
    }

    /*
     * 返回最近在线用户列表
     */

    public function getRecentlyUser() {
        $limit = (int) ($this->input->post_get('pageSize') ?: 20);
        $offset = (int) ((($this->input->post_get('currentPage') ?: 1) - 1) * $limit);
        $this->db->limit($limit, $offset);
        $list = $this->db->order_by('lastloginTimes', 'DESC')->where(['lastloginTimes>' => 0])->select('userId,avatar,usernick as nick,,sex,sign,lastloginTimes as recentlyTime')->get('users')->result_array();
        foreach ($list as $key => $row) {
            empty($list[$key]['sign']) && $list[$key]['sign'] = '';
            $list[$key]['serviceTime'] = (string) time();
        }
        return $list ? ['data' => $list] : [];
    }

}
