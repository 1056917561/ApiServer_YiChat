<?php

/**
 * 游戏栏目
 * @author 费尔
 */
class Game_section_model extends CI_Model {

    public function __construct() {
        //连接数据库
        $this->load->database();
    }

    public function get_game() {
        $where = [];

        $where['game_section.isgame'] = 1;
        $this->db->where($where);

        if ($this->input->post_get('pid')) {
            $this->db->where(['pid' => (int) $this->input->post_get('pid')]);
        } else {
            $this->db->where(['pid' => 0]);
        }

        $list = $this->db->select('id,name,pid')->get('game_section')->result_array();

        return $list;
    }

    /**
     * 返回活动列表
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function get_list($page = 1, $limit = 20) {

        $where = [];

        $where['game_section.isgame'] = 1;
        $this->db->where($where);
        if ($this->input->post_get('pid')) {
            $this->db->where(['game_section.pid' => (int) $this->input->post_get('pid')]);
        } else {
            $this->db->where(['game_section.pid' => 0]);
        }
        $offset = (int) (($page - 1) * $limit);
        $this->db->limit($limit, $offset);
        $select = 'game_section.*';
        $this->db->join('game_section AS B', 'B.pid=game_section.id', 'left');
        $select .= ',COUNT(DISTINCT B.id) AS channel';
        $this->db->join('game_section AS C', 'C.pid=B.id', 'left');
        $select .= ',COUNT(DISTINCT C.id) AS services';
        $this->db->join('game_section AS D', 'D.pid=C.id', 'left');
        $select .= ',COUNT(DISTINCT D.id) AS system';
        $list = $this->db->group_by('game_section.id')->order_by('game_section.id', 'DESC')->select($select)->get('game_section')->result_array();
        return $list;
    }

    /**
     * 返回活动总数
     * @return int
     */
    public function get_count() {
        $where = [];
        $where['isgame'] = 1;
        $this->db->where($where);
        if ($this->input->post_get('pid')) {
            $this->db->where(['pid' => (int) $this->input->post_get('pid')]);
        } else {
            $this->db->where(['pid' => 0]);
        }
        $list = $this->db->limit(1)->select('COUNT(*) AS gamesection')->get('game_section')->row_array();
        return !empty($list['gamesection']) ? $list['gamesection'] : 0;
    }

    /**
     * 返回下载渠道列表
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function get_channel_list($page = 1, $limit = 20) {

        $where = [];

        $where['game_section.isgame'] = 1;
        $this->db->where($where);
        $this->db->where(['game_section.pid' => (int) $this->input->post_get('pid')]);
        $offset = (int) (($page - 1) * $limit);
        $this->db->limit($limit, $offset);
        $select = 'game_section.*';
        $this->db->join('game_section AS B', 'B.id=game_section.pid', 'left');
        $select .= ',B.name AS game';
        $this->db->join('game_section AS C', 'C.pid=game_section.id', 'left');
        $select .= ',COUNT(DISTINCT C.id) AS services';
        $this->db->join('game_section AS D', 'D.pid=C.id', 'left');
        $select .= ',COUNT(DISTINCT D.id) AS system';
        $list = $this->db->group_by('game_section.id')->order_by('game_section.id', 'DESC')->select($select)->get('game_section')->result_array();
        return $list;
    }

    /**
     * 返回下载渠道总数
     * @return int
     */
    public function get_channel_count() {
        $where = [];
        $where['isgame'] = 1;
        $this->db->where($where);
        $this->db->where(['pid' => (int) $this->input->post_get('pid')]);
        $list = $this->db->limit(1)->select('COUNT(*) AS gamesection')->get('game_section')->row_array();
        return !empty($list['gamesection']) ? $list['gamesection'] : 0;
    }

    /**
     * 返回区服列表
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function get_services_list($page = 1, $limit = 20) {

        $where = [];

        $where['game_section.isgame'] = 1;
        $this->db->where($where);
        $this->db->where(['game_section.pid' => (int) $this->input->post_get('pid')]);
        $offset = (int) (($page - 1) * $limit);
        $this->db->limit($limit, $offset);
        $select = 'game_section.*';
        $this->db->join('game_section AS B', 'B.id=game_section.pid', 'left');
        $select .= ',B.name AS servicesname';
        $this->db->join('game_section AS C', 'C.id=B.pid', 'left');
        $select .= ',C.name AS game';
        $this->db->join('game_section AS D', 'D.pid=game_section.id', 'left');
        $select .= ',COUNT(DISTINCT D.id) AS system';
        $list = $this->db->group_by('game_section.id')->order_by('game_section.id', 'DESC')->select($select)->get('game_section')->result_array();
        return $list;
    }

    /**
     * 返回区服总数
     * @return int
     */
    public function get_services_count() {
        $where = [];
        $where['isgame'] = 1;
        $this->db->where($where);
        $this->db->where(['game_section.pid' => (int) $this->input->post_get('pid')]);
        $list = $this->db->limit(1)->select('COUNT(*) AS gamesection')->get('game_section')->row_array();
        return !empty($list['gamesection']) ? $list['gamesection'] : 0;
    }

    /**
     * 返回平台列表
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function get_system_list($page = 1, $limit = 20) {

        $where = [];

        $where['game_section.isgame'] = 1;
        $this->db->where($where);
        $this->db->where(['game_section.pid' => (int) $this->input->post_get('pid')]);
        $offset = (int) (($page - 1) * $limit);
        $this->db->limit($limit, $offset);
        $select = 'game_section.*';
        $this->db->join('game_section AS B', 'B.id=game_section.pid', 'left');
        $select .= ',B.name AS services';
        $this->db->join('game_section AS C', 'C.id=B.pid', 'left');
        $select .= ',C.name AS channel';
        $this->db->join('game_section AS D', 'D.id=C.pid', 'left');
        $select .= ',D.name AS game';
        $list = $this->db->group_by('game_section.id')->order_by('game_section.id', 'DESC')->select($select)->get('game_section')->result_array();
        return $list;
    }

    /**
     * 返回平台总数
     * @return int
     */
    public function get_system_count() {
        $where = [];
        $where['isgame'] = 1;
        $this->db->where($where);
        $this->db->where(['game_section.pid' => (int) $this->input->post_get('pid')]);
        $list = $this->db->limit(1)->select('COUNT(*) AS gamesection')->get('game_section')->row_array();
        return !empty($list['gamesection']) ? $list['gamesection'] : 0;
    }

    /**
     * 删除
     * @param int $id
     */
    public function delete($id) {
        if (is_numeric($id)) {
            $where = [];
            $where['id'] = (int) $id;
            return $this->db->limit(1)->where($where)->delete('game_section');
        }
        return FALSE;
    }

    /**
     * 新增游戏
     */
    public function gameadd() {
        $data = [];
        $data['name'] = trim($this->input->post('name'));
        if (empty($data['name'])) {
            return FALSE;
        }
        $data['pid'] = 0;
        $data['isgame'] = 1;

        return $this->db->insert('game_section', $data);
    }

    /**
     * 更新游戏
     */
    public function gameedit($id) {
        $data = [];
        $data['name'] = trim($this->input->post('name'));
        if (empty($data['name'])) {
            return FALSE;
        }
        $data['pid'] = 0;
        $data['isgame'] = 1;

        return $this->db->limit(1)->where(['id' => (int) $id])->set($data)->update('game_section');
    }

    /**
     * 新增下载渠道
     */
    public function channeladd() {
        $data = [];
        $data['name'] = trim($this->input->post('name'));
        if (empty($data['name'])) {
            return FALSE;
        }
        $data['pid'] = (int) $this->input->post('pid');
        $data['isgame'] = 1;

        return $this->db->insert('game_section', $data);
    }

    /**
     * 更新下载渠道
     */
    public function channeledit($id) {
        $data = [];
        $data['name'] = trim($this->input->post('name'));
        if (empty($data['name'])) {
            return FALSE;
        }
        $data['pid'] = (int) $this->input->post('pid');
        $data['isgame'] = 1;

        return $this->db->limit(1)->where(['id' => (int) $id])->set($data)->update('game_section');
    }

}
