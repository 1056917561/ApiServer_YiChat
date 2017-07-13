<?php

/**
 * 软件版本
 * @author 费尔
 */
class Version_model extends CI_Model {

    public function __construct() {
        //连接数据库
        $this->load->database();
    }

    /**
     * 返回软件列表
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function get_list($page = 1, $limit = 20) {

        $where = [];

        if ($this->input->post_get('name')) {
            $this->db->like('version.name', $this->input->post_get('name'));
        }

        $offset = (int) (($page - 1) * $limit);
        $this->db->limit($limit, $offset);



        $select = 'version.*';

        $list = $this->db->group_by('version.id')->order_by('version.id', 'DESC')->where($where)->select($select)->get('version')->result_array();



        return $list;
//        $this->load->library('Tree');
//        $_list = $this->tree->toTree($list);
//        print_r($_list);
    }

    /**
     * 返回软件总数
     * @return int
     */
    public function get_count() {
        if ($this->input->post_get('name')) {
            $this->db->like('version.name', $this->input->post_get('name'));
        }
        $list = $this->db->limit(1)->select('COUNT(*) AS gamesection')->get('version')->row_array();
        return !empty($list['gamesection']) ? $list['gamesection'] : 0;
    }

    public function add_version() {
        $data = [];
        $data['system'] = (int) $this->input->post('system');
        $data['version'] = $this->input->post('version');
        $data['name'] = $this->input->post('name');
        $data['url'] = $this->input->post('url');

        return $this->db->insert('version', $data);
    }

    /**
     * 删除
     * @param int $id
     */
    public function delete($id) {
        if (is_numeric($id)) {
            $where = [];
            $where['id'] = (int) $id;
            return $this->db->limit(1)->where($where)->delete('version');
        }
        return FALSE;
    }

    /**
     * 删除
     * @param int $id
     */
    public function edit($id) {
        $data = [];
        $data['system'] = (int) $this->input->post('system');
        $data['version'] = $this->input->post('version');
        $data['name'] = $this->input->post('name');
        $data['url'] = $this->input->post('url');
        return $this->db->limit(1)->where(['id' => (int) $id])->set($data)->update('version');
    }
    
    public function get_version(){
        return $this->db->limit(1)->order_by('id', 'DESC')->select('system,version,name,url')->get('version')->row_array();
    }

}
