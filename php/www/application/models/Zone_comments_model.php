<?php

/**
 * 评论
 * @author 费尔
 */
class Zone_comments_model extends CI_Model {

    /**
     * 返回评论列表
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function get_list($page = 1, $limit = 20) {
        $where = [];
        $userlist = $this->ion_auth->user()->row_array();
        if ($userlist['region']) {
            $where['D.area_id'] = $userlist['region'];
        }
        $this->db->where($where);
        if ($this->input->post_get('userId')) {
            $this->db->where(['B.userId' => $this->input->post_get('userId')]);
        }
        if ($this->input->post_get('fxid')) {
            $this->db->where(['B.fxid' => $this->input->post_get('fxid')]);
        }

        if ($this->input->post_get('date')) {
            $date = $this->input->post_get('date');
            if (date('Y-m-d', strtotime($date)) === $date) {
                $this->db->where(['zone_comments.time >=' => strtotime($date . ' 00:00:00')])->where(['zone_comments.time <=' => strtotime($date . ' 23:59:59')]);
            }
        }

        if ($this->input->post_get('keyword')) {
            $this->db->like('zone_comments.content', $this->input->post_get('keyword'));
        }
        if ($this->input->post_get('usernick')) {
            $this->db->like('B.usernick', $this->input->post_get('usernick'));
        }


        if ($this->input->post_get('replydate')) {
            $date = $this->input->post_get('replydate');
            if (date('Y-m-d', strtotime($date)) === $date) {
                $this->db->where(['zone_comments.replyTime >=' => strtotime($date . ' 00:00:00')])->where(['zone_comments.replyTime <=' => strtotime($date . ' 23:59:59')]);
            }
        }

        if ($this->input->post_get('replykeyword')) {
            $this->db->like('zone_comments.replyContent', $this->input->post_get('replykeyword'));
        }
        if ($this->input->post_get('replyusernick')) {
            $this->db->like('C.usernick', $this->input->post_get('replyusernick'));
        }
        if ($this->input->post_get('id')) {
            $this->db->like('zone_comments.zid', (int) $this->input->post_get('id'));
        }


        $offset = (int) (($page - 1) * $limit);
        $this->db->limit($limit, $offset);

        $this->db->join('users AS B', 'B.userId=zone_comments.uid', 'left');

        $this->db->join('users AS C', 'C.userId=zone_comments.replyUid', 'left');
        //update
        $this->db->join('zone AS Z', 'Z.id=zone_comments.zid', 'left');
        $this->db->join('users AS D', 'D.userId=Z.userId', 'left');

        $select = 'zone_comments.*,B.userId,B.fxid,B.usernick,C.usernick AS replyUsernick';

        $list = $this->db->order_by('zone_comments.id', 'DESC')->group_by('zone_comments.id')->select($select)->get('zone_comments')->result_array(); //->order_by('zone_comments.id', 'DESC')

        if (!empty($list)) {
            $cids = [];
            for ($index = 0; $index < count($list); $index++) {
                $cids[] = (int) $list[$index]['id'];
                $list[$index]['time'] = date('Y-m-d H:i:s', $list[$index]['time']);
                $list[$index]['replyTime'] = !empty($list[$index]['replyTime']) ? date('Y-m-d H:i:s', $list[$index]['replyTime']) : '';
            }
        }

        return $list;
    }

    /**
     * 返回评论总数
     * @return int
     */
    public function get_count() {
        $where = [];
        $userlist = $this->ion_auth->user()->row_array();
        if ($userlist['region']) {
            $where['D.area_id'] = $userlist['region'];
        }
        $this->db->where($where);
        if ($this->input->post_get('userId')) {
            $this->db->where(['B.userId' => $this->input->post_get('userId')]);
        }
        if ($this->input->post_get('fxid')) {
            $this->db->where(['B.fxid' => $this->input->post_get('fxid')]);
        }
        if ($this->input->post_get('date')) {
            $date = $this->input->post_get('date');
            if (date('Y-m-d', strtotime($date)) === $date) {
                $this->db->where(['zone_comments.time >=' => strtotime($date . ' 00:00:00')])->where(['zone_comments.time <=' => strtotime($date . ' 23:59:59')]);
            }
        }

        if ($this->input->post_get('keyword')) {
            $this->db->like('zone_comments.content', $this->input->post_get('keyword'));
        }
        if ($this->input->post_get('usernick')) {
            $this->db->like('B.usernick', $this->input->post_get('usernick'));
        }


        if ($this->input->post_get('replydate')) {
            $date = $this->input->post_get('replydate');
            if (date('Y-m-d', strtotime($date)) === $date) {
                $this->db->where(['zone_comments.replyTime >=' => strtotime($date . ' 00:00:00')])->where(['zone_comments.replyTime <=' => strtotime($date . ' 23:59:59')]);
            }
        }

        if ($this->input->post_get('replykeyword')) {
            $this->db->like('zone_comments.replyContent', $this->input->post_get('replykeyword'));
        }
        if ($this->input->post_get('replyusernick')) {
            $this->db->like('C.usernick', $this->input->post_get('replyusernick'));
        }
        if ($this->input->post_get('id')) {
            $this->db->like('zone_comments.zid', (int) $this->input->post_get('id'));
        }

        $this->db->join('users AS B', 'B.userId=zone_comments.uid', 'left');

        $this->db->join('users AS C', 'C.userId=zone_comments.replyUid', 'left');
        //update
        $this->db->join('zone AS Z', 'Z.id=zone_comments.zid', 'left');
        $this->db->join('users AS D', 'D.userId=Z.userId', 'left');

        $list = $this->db->limit(1)->select('COUNT(DISTINCT c_zone_comments.id) AS zone_commentscount')->get('zone_comments')->row_array();
        return !empty($list['zone_commentscount']) ? $list['zone_commentscount'] : 0;
    }

    /**
     * 删除
     * @param int $id
     */
    public function delete($id) {
        if (is_numeric($id)) {
            $where = [];
            $where['id'] = (int) $id;
            return $this->db->limit(1)->where($where)->delete('zone_comments');
        }
        return FALSE;
    }

    /**
     * 删除
     * @param int $id
     */
    public function deletes() {

        $ids = $this->input->post_get('ids');
        if (!empty($ids)) {
            $this->db->trans_start();


            $this->db->where_in('id', $ids)->delete('zone_comments');

            $this->db->trans_complete();

            return $this->db->trans_status() ? TRUE : FALSE;
        }
        return FALSE;
    }

}
