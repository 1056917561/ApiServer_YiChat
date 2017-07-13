<?php

/**
 * 评论
 * @author 费尔
 */
class Activity_comments_model extends CI_Model {

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
            $where['C.area_id'] = $userlist['region'];
        }
        $this->db->where($where);
        if ($this->input->post_get('date')) {
            $date = $this->input->post_get('date');
            if (date('Y-m-d', strtotime($date)) === $date) {
                $this->db->where(['activity_comments.time >=' => strtotime($date . ' 00:00:00')])->where(['activity_comments.time <=' => strtotime($date . ' 23:59:59')]);
            }
        }

        if ($this->input->post_get('keyword')) {
            $this->db->like('activity_comments.content', $this->input->post_get('keyword'));
        }
        if ($this->input->post_get('usernick')) {
            $this->db->like('B.usernick', $this->input->post_get('usernick'));
        }


        if ($this->input->post_get('replydate')) {
            $date = $this->input->post_get('replydate');
            if (date('Y-m-d', strtotime($date)) === $date) {
                $this->db->where(['activity_comments.replyTime >=' => strtotime($date . ' 00:00:00')])->where(['activity_comments.replyTime <=' => strtotime($date . ' 23:59:59')]);
            }
        }

        if ($this->input->post_get('replykeyword')) {
            $this->db->like('activity_comments.replyContent', $this->input->post_get('replykeyword'));
        }
        if ($this->input->post_get('replyusernick')) {
            $this->db->like('C.usernick', $this->input->post_get('replyusernick'));
        }


        $offset = (int) (($page - 1) * $limit);
        $this->db->limit($limit, $offset);

        $this->db->join('users AS B', 'B.userId=activity_comments.uid', 'left');
        //update
        $this->db->join('activity AS A', 'A.id=activity_comments.aid', 'left');
        $this->db->join('users AS C', 'C.userId=A.uid', 'left');

      //  $this->db->join('users AS C', 'C.userId=activity_comments.replyUid', 'left');

        $select = 'activity_comments.*,B.usernick';

        $list = $this->db->group_by('activity_comments.id')->order_by('activity_comments.id', 'DESC')->select($select)->get('activity_comments')->result_array();

        if (!empty($list)) {
            $cids = [];
            for ($index = 0; $index < count($list); $index++) {
                $cids[] = (int) $list[$index]['id'];
                $list[$index]['time'] = date('Y-m-d H:i:s', $list[$index]['time']);
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
            $where['C.area_id'] = $userlist['region'];
        }
        $this->db->where($where);
        if ($this->input->post_get('date')) {
            $date = $this->input->post_get('date');
            if (date('Y-m-d', strtotime($date)) === $date) {
                $this->db->where(['activity_comments.time >=' => strtotime($date . ' 00:00:00')])->where(['activity_comments.time <=' => strtotime($date . ' 23:59:59')]);
            }
        }

        if ($this->input->post_get('keyword')) {
            $this->db->like('activity_comments.content', $this->input->post_get('keyword'));
        }
        if ($this->input->post_get('usernick')) {
            $this->db->like('B.usernick', $this->input->post_get('usernick'));
        }


        if ($this->input->post_get('replydate')) {
            $date = $this->input->post_get('replydate');
            if (date('Y-m-d', strtotime($date)) === $date) {
                $this->db->where(['activity_comments.replyTime >=' => strtotime($date . ' 00:00:00')])->where(['activity_comments.replyTime <=' => strtotime($date . ' 23:59:59')]);
            }
        }

        if ($this->input->post_get('replykeyword')) {
            $this->db->like('activity_comments.replyContent', $this->input->post_get('replykeyword'));
        }
        if ($this->input->post_get('replyusernick')) {
            $this->db->like('C.usernick', $this->input->post_get('replyusernick'));
        }


        $this->db->join('users AS B', 'B.userId=activity_comments.uid', 'left');
        //update
        $this->db->join('activity AS A', 'A.id=activity_comments.aid', 'left');
        $this->db->join('users AS C', 'C.userId=A.uid', 'left');
        
       // $this->db->join('users AS C', 'C.userId=activity_comments.replyUid', 'left');

        $list = $this->db->limit(1)->select('COUNT(DISTINCT c_activity_comments.id) AS activity_commentscount')->get('activity_comments')->row_array();
        
        
        return !empty($list['activity_commentscount']) ? $list['activity_commentscount'] : 0;
    }

    /**
     * 删除
     * @param int $id
     */
    public function delete($id) {
        if (is_numeric($id)) {
            $where = [];
            $where['id'] = (int) $id;
            return $this->db->limit(1)->where($where)->delete('activity_comments');
        }
        return FALSE;
    }

}
