<?php

/**
 * 申请
 * @author 费尔
 */
class Users_gamerole_model extends CI_Model {

    public function __construct() {
        //连接数据库
        $this->load->database();
    }

    public function gameapply($uid) {
        $data = [];
        $data['uid'] = (int) $uid;
        $data['status'] = 0;

        $data['game'] = (int) $this->input->post_get('game');
        $data['channel'] = (int) $this->input->post_get('channel');
        $data['services'] = (int) $this->input->post_get('services');
        $data['system'] = (int) $this->input->post_get('system');

        $data['name'] = $this->input->post_get('name');

        $data['nameimg'] = $this->upload('nameimg');
        $data['phoneimg'] = $this->upload('phoneimg');
        $data['imimg'] = $this->upload('imimg');
//        if (empty($data['nameimg']) || empty($data['phoneimg']) || empty($data['imimg'])) {
//           $this->alert('部分未提供上传图片');
//        }



        $data['time'] = time();

        $data2 = [];
        $data2['usernick'] = $data['name'];

        $this->db->limit(1)->where('userId', (int) $uid)->set($data2)->update('users');

        return $this->db->replace('users_gamerole', $data);
    }

    private function upload($name) {

//        print_r($_REQUEST);
//        print_r($_FILES);exit;
        $config = [];
        $root = rtrim($_SERVER['DOCUMENT_ROOT'], '/\\');
        $path = DIRECTORY_SEPARATOR . 'attached' . DIRECTORY_SEPARATOR . date('Y-m-d') . DIRECTORY_SEPARATOR;
        $config['upload_path'] = $root . $path;

        $this->load->model('file_model');
        $this->file_model->makeDirectory($config['upload_path']);

        if (empty($_FILES[$name])) {
            $this->alert('未提供上传图片');
        }

//PHP上传失败
        if (!empty($_FILES[$name]['error'])) {
            switch ($_FILES[$name]['error']) {
                case '1':
                    $error = '超过php.ini允许的大小。';
                    break;
                case '2':
                    $error = '超过表单允许的大小。';
                    break;
                case '3':
                    $error = '图片只有部分被上传。';
                    break;
                case '4':
                    $error = '请选择图片。';
                    break;
                case '6':
                    $error = '找不到临时目录。';
                    break;
                case '7':
                    $error = '写文件到硬盘出错。';
                    break;
                case '8':
                    $error = 'File upload stopped by extension。';
                    break;
                case '999':
                default:
                    $error = '未知错误。';
            }
            $this->alert($error);
        }

        //原文件名
        $file_name = $_FILES[$name]['name'];
        //服务器上临时文件名
        $tmp_name = $_FILES[$name]['tmp_name'];
        //文件大小
        $file_size = $_FILES[$name]['size'];

        //获得文件扩展名
        $temp_arr = explode(".", $file_name);
        $file_ext = array_pop($temp_arr);
        $file_ext = trim($file_ext);
        $file_ext = strtolower($file_ext);
        //检查扩展名
        if (in_array($file_ext, ['gif', 'jpg', 'jpeg', 'png', 'bmp']) === false) {
            $this->alert("上传文件扩展名是不允许的扩展名");
        }
        //新文件名
        $new_file_name = date("YmdHis") . '_' . rand(10000, 99999) . '.' . $file_ext;
        //移动文件
        $file_path = $config['upload_path'] . $new_file_name;
        if (move_uploaded_file($tmp_name, $file_path) === false) {
            $this->alert("上传文件失败。");
        }

        $url = substr($file_path, strlen($root));
        return str_replace(DIRECTORY_SEPARATOR, '/', $url);


        //$config['upload_path'] = FCPATH . 'attached' . DIRECTORY_SEPARATOR . COMPANY_ID . DIRECTORY_SEPARATOR;
//        $config['file_ext_tolower'] = TRUE;
//        $config['overwrite'] = FALSE;
//        $config['allowed_types'] = 'gif|jpg|png';
//        $this->load->model('file_model');
//        $this->file_model->makeDirectory($config['upload_path']);
//        $this->load->library('upload', $config);
//        if (!$this->upload->do_upload($name)) {
//            $this->alert($this->upload->display_errors());
//        } else {
//            $data = $this->upload->data();
//            $url = substr($data['full_path'], strlen($root));
//            return str_replace(DIRECTORY_SEPARATOR, '/', $url);
//        }
    }

    private function alert($message) {
        $value = [];
        $value['code'] = -1;
        $value['message'] = $message;
        header('Content-type:application/json;charset=utf-8');
        exit(json_encode($value, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 返回申请列表
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function get_list($page = 1, $limit = 20) {

        $where = [];

        if ($this->input->post_get('status')) {
            $this->db->where(['users_gamerole.status' => (int) $this->input->post_get('status')]);
        } else {
            $this->db->where(['users_gamerole.status' => 0]);
        }

        $offset = (int) (($page - 1) * $limit);
        $this->db->limit($limit, $offset);

        $this->db->join('users', 'users.userId=users_gamerole.uid', 'left');

        $select = 'users_gamerole.*,users.usernick,users.userId,users.fxid,users.tel';

        $this->db->join('game_section AS B', 'B.id=users_gamerole.services', 'left');
        $select .= ',B.name AS services';
        $this->db->join('game_section AS C', 'C.id=users_gamerole.channel', 'left');
        $select .= ',C.name AS channel';
        $this->db->join('game_section AS D', 'D.id=users_gamerole.game', 'left');
        $select .= ',D.name AS game';


        $list = $this->db->group_by('users_gamerole.uid')->order_by('users_gamerole.uid', 'DESC')->where($where)->select($select)->get('users_gamerole')->result_array();


        return $list;
//        $this->load->library('Tree');
//        $_list = $this->tree->toTree($list);
//        print_r($_list);
    }

    /**
     * 返回申请总数
     * @return int
     */
    public function get_count() {

        if ($this->input->post_get('status')) {
            $this->db->where(['users_gamerole.status' => (int) $this->input->post_get('status')]);
        } else {
            $this->db->where(['users_gamerole.status' => 0]);
        }

        //$this->db->join('users', 'users.userId=users_gamerole.uid', 'left');

        $list = $this->db->limit(1)->select('COUNT(*) AS gamesection')->get('users_gamerole')->row_array();
        return !empty($list['gamesection']) ? $list['gamesection'] : 0;
    }

    public function rolecheck($id) {
        if (is_numeric($id)) {
            return $this->db->limit(1)->where(['uid' => (int) $id])->set(['status' => 1])->update('users_gamerole');
        }
        return FALSE;
    }

    public function roleremove($id) {
        if (is_numeric($id)) {
            return $this->db->limit(1)->where(['uid' => (int) $id])->set(['status' => -1])->update('users_gamerole');
        }
        return FALSE;
    }

    public function get_info($uid) {
        $select = 'users_gamerole.status,users_gamerole.name,users_gamerole.system';
        $this->db->join('game_section AS B', 'B.id=users_gamerole.services', 'left');
        $select .= ',B.name AS services';
        $this->db->join('game_section AS C', 'C.id=users_gamerole.channel', 'left');
        $select .= ',C.name AS channel';
        $this->db->join('game_section AS D', 'D.id=users_gamerole.game', 'left');
        $select .= ',D.name AS game';
        $list = $this->db->limit(1)->where(['uid' => (int) $uid])->select($select)->get('users_gamerole')->row_array();
        if (!empty($list)) {
            $users = [];
            foreach ($list as $key => $value) {
                if (is_numeric($value)) {
                    $users[$key] = (int) $value;
                } else {
                    $users[$key] = !empty($value) ? $value : '';
                }
            }
            return $users;
        }
        $list = [];
        $list['name'] = '';
        $list['services'] = '';
        $list['channel'] = '';
        $list['game'] = '';
        $list['system'] = '';
        $list['status'] = '';
        return $list;
    }

}
