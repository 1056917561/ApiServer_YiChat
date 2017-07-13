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


                $users['password'] = $this->makePassword();
                $users['session'] = $this->getSession($users['userId']);


                $easemob = $this->easemob()->createUser($users['userId'], $users['password']);
                if (isset($easemob['entities'])) {
                    $this->db->limit(1)->where('userId', $users['userId'])->set(['hxpassword' => $users['password']])->update('users');
                }
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
            $this->db->or_where(['tel' => $userId])->or_where(['userId' => $userId])->or_where(['fxid' => $userId]);
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
    public function makePassword($length = 8) {
        $chars = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h',
            'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's',
            't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D',
            'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O',
            'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
            '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '!',
            '@', '#', '$', '%', '^', '&', '*', '(', ')', '-', '_',
            '[', ']', '{', '}', '<', '>', '~', '`', '+', '=', ',',
            '.', ';', ':', '/', '?', '|');
        $keys = array_rand($chars, $length);
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password .= $chars[$keys[$i]];
        }
        return $password;
    }
    public function get_father_count(){
		$fatherid= $this->input->post_get('faid');
		$id= $this->input->post_get('id');
	    $list = $this->db->limit(1)->where($id)->select('COUNT(DISTINCT c_users.userId) AS userscount')->get('users')->row_array();
		if(!empty($fatherId)){
			return !empty($list['userscount']) ? $list['userscount']+1 : 0;
		}
        return !empty($list['userscount']) ? $list['userscount'] : 0;
	}
	public function get_father_list($page = 1, $limit = 20){
        $fatherid= $this->input->post_get('faid');
		$id= $this->input->post_get('id');
		$offset = (int) (($page - 1) * $limit);
        $this->db->limit($limit, $offset);
		$list = $this->db->group_by('users.userId')->where(['fatherId'=>$id])->order_by('userId', 'DESC')->get('users')->result_array();
		 if (!empty($list)) {
            $cids = [];
            for ($index = 0; $index < count($list); $index++) {
                $list[$index]['time'] = date('Y-m-d H:i:s', $list[$index]['time']);
                $list[$index]['fa_type']=2;
            }
        }
		if(!empty($fatherId)){
			$ar=$this->db->where("userId"=>$fatherId)->getInfo("users");
			$ar['fa_type']=1
		    $list []=$ar;	
		}		
        return $list;
	}
    /**
     * 返回动态列表
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function get_list($page = 1, $limit = 20) {
        $where = [];

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

        $offset = (int) (($page - 1) * $limit);
        $this->db->limit($limit, $offset);


        $select = 'users.*';

        $list = $this->db->group_by('users.userId')->order_by('users.userId', 'DESC')->select($select)->get('users')->result_array();
        $this->load->model('friend_model');
        if (!empty($list)) {
            $cids = [];
            for ($index = 0; $index < count($list); $index++) {
                $cids[] = (int) $list[$index]['userId'];
                $list[$index]['time'] = date('Y-m-d H:i:s', $list[$index]['time']);

                $list[$index]['friends'] = $this->friend_model->fetchFriends($list[$index]['userId']);
                $list[$index]['blacks'] = $this->friend_model->fetchBlackList($list[$index]['userId']);
            }
        }
        return $list;
    }

    /**
     * 返回动态总数
     * @return int
     */
    public function get_count() {
        $where = [];
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
        if ($this->input->post_get('usernick')) {
            $this->db->like('users.usernick', $this->input->post_get('usernick'));
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

}
