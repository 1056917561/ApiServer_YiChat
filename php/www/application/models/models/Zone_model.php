<?php

/**
 * 朋友圈
 * @author 费尔
 */
class Zone_model extends CI_Model {

    public function __construct() {
        //连接数据库
        $this->load->database();
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
            $this->db->where(['users.userId' => $this->input->post_get('userId')]);
        }
        if ($this->input->post_get('fxid')) {
            $this->db->where(['users.fxid' => $this->input->post_get('fxid')]);
        }
        if ($this->input->post_get('date')) {
            $date = $this->input->post_get('date');
            if (date('Y-m-d', strtotime($date)) === $date) {
                $this->db->where(['zone.time >=' => strtotime($date . ' 00:00:00')])->where(['zone.time <=' => strtotime($date . ' 23:59:59')]);
            }
        }



        if ($this->input->post_get('keyword')) {
            $this->db->like('zone.content', $this->input->post_get('keyword'));
        }
        if ($this->input->post_get('usernick')) {
            $this->db->like('users.usernick', $this->input->post_get('usernick'));
        }




        $offset = (int) (($page - 1) * $limit);
        $this->db->limit($limit, $offset);

        $this->db->join('users', 'users.userId=zone.userId', 'left');
        $this->db->join('zone_comments', 'zone_comments.zid=zone.id', 'left');
        $this->db->join('zone_praises', 'zone_praises.zid=zone.id', 'left');

        $select = 'zone.*,users.usernick,users.userId,users.fxid,COUNT(DISTINCT c_zone_comments.id) AS comments,COUNT(DISTINCT c_zone_praises.id) AS praises';

        $list = $this->db->group_by('zone.id')->order_by('zone.id', 'DESC')->select($select)->get('zone')->result_array();

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
     * 返回动态总数
     * @return int
     */
    public function get_count() {
        $where = [];
        $this->db->where($where);
        if ($this->input->post_get('userId')) {
            $this->db->where(['users.userId' => $this->input->post_get('userId')]);
        }
        if ($this->input->post_get('fxid')) {
            $this->db->where(['users.fxid' => $this->input->post_get('fxid')]);
        }
        if ($this->input->post_get('date')) {
            $date = $this->input->post_get('date');
            if (date('Y-m-d', strtotime($date)) === $date) {
                $this->db->where(['zone.time >=' => strtotime($date . ' 00:00:00')])->where(['zone.time <=' => strtotime($date . ' 23:59:59')]);
            }
        }
        if ($this->input->post_get('keyword')) {
            $this->db->like('zone.content', $this->input->post_get('keyword'));
        }
        if ($this->input->post_get('usernick')) {
            $this->db->like('users.usernick', $this->input->post_get('usernick'));
        }

        $this->db->join('users', 'users.userId=' . 'zone.userId', 'left');



        $list = $this->db->limit(1)->select('COUNT(DISTINCT c_zone.id) AS zonecount')->get('zone')->row_array();
        return !empty($list['zonecount']) ? $list['zonecount'] : 0;
    }

    /**
     * 发布社区动态
     */
    public function publish($uid) {
        $data = [];
        $data['userId'] = $uid;
        $data['category'] = $this->input->post_get('category');
        $data['content'] = $this->input->post_get('content');
        $data['imagestr'] = $this->input->post_get('imagestr');
        $data['coordinate'] = $this->input->post_get('coordinate');
        $data['location'] = $this->input->post_get('location');
        $data['time'] = time();
        if ($this->db->insert('zone', $data)) {
            return $this->db->insert_id();
        }
        return 0;
    }

    /**
     * 删除一条动态
     */
    public function removeTimeline($uid) {
        $zid = $this->input->post_get('tid');
        if (is_numeric($zid)) {
            $where = [];
            $where['userId'] = $uid;
            $where['id'] = $zid;
            if ($this->db->select('id')->get_where('zone', $where, 1)->row_array()) {
                return $this->delete($zid) ? 1 : 0;
            }
        }
        return 0;
    }

    /**
     * 删除
     * @param int $id
     */
    public function deletes() {

        $ids = $this->input->post_get('ids');
        if (!empty($ids)) {
            $this->db->trans_start();


            $this->db->where_in('id', $ids)->delete('zone');
            $this->db->where_in('zid', $ids)->delete('zone_comments');
            $this->db->where_in('zid', $ids)->delete('zone_praises');

            $this->db->trans_complete();

            return $this->db->trans_status() ? TRUE : FALSE;
        }
        return FALSE;
    }

    /**
     * 删除
     * @param int $id
     */
    public function delete($id) {
        if (is_numeric($id)) {

            $this->db->trans_start();

            $this->db->limit(1)->where(['id' => (int) $id])->delete('zone');
            $this->db->where(['zid' => (int) $id])->delete('zone_comments');
            $this->db->where(['zid' => (int) $id])->delete('zone_praises');

            $this->db->trans_complete();

            return $this->db->trans_status() ? TRUE : FALSE;
        }
        return FALSE;
    }

    /**
     * 获取动态列表
     * - isFriend     是否需要经过好友关系的筛选，拓展时候会用到，作为一个查询条件
     * - category     朋友圈分类，拓展的时候会用到，作为一个查询条件
     * - currentPage  1
     * - pageSize     20
     * - isFold       是否返回评论列表和点赞列表 1返回，0不返回
     * @param int $uid
     */
    public function fetchTimeline($uid) {
        $where = [];
        if ($this->input->post_get('category')) {
            $this->db->like('category', $this->input->post_get('category'));
        }
        $this->db->join('users', 'users.userId = zone.userId', 'left');


        if ($this->input->post_get('isFriend')) {

            $this->db->join('friend', 'friend.friend=zone.userId AND friend.uid=' . $uid, 'inner');

//            $this->db->join('friend', 'friend.uid=' . $uid . ' AND friend.friend=zone.userId', 'left');
//            $this->db->or_group_start()
//                    ->where('friend.uid', $uid)
//                    ->or_where('zone.userId', $uid)
//                    ->group_end();
        }


        $limit = (int) ($this->input->post_get('pageSize') ?: 20);
        $offset = (int) ((($this->input->post_get('currentPage') ?: 1) - 1) * $limit);
        $this->db->limit($limit, $offset);

        $this->db->select('zone.*,avatar,usernick,sign,hxpassword');
        //
        $list = $this->db->group_by('zone.id')->order_by('zone.id', 'DESC')->where($where)->get('zone')->result_array();

        for ($index = 0; $index < count($list); $index++) {
            $list[$index]['time'] = date('Y-m-d H:i:s', $list[$index]['time']);
        }


        if ($this->input->post_get('isFold') && !empty($list)) {
            $ids = array_column($list, 'id');
            $praises = $this->getPraises($ids, $uid);
            $comment = $this->getComment($ids, $uid);
            for ($index1 = 0; $index1 < count($list); $index1++) {
                $list[$index1]['praisesAmount'] = count($praises[$list[$index1]['id']] ?? []);
                $list[$index1]['commentAmount'] = count($comment[$list[$index1]['id']] ?? []);
                $list[$index1]['praises'] = $praises[$list[$index1]['id']] ?? [];
                $list[$index1]['comment'] = $comment[$list[$index1]['id']] ?? [];
            }
        }

        return $list;
    }

    /**
     * 查看别人动态列表
     * @param int $uid
     */
    public function fetchOtherTimeline($uid) {
        $limit = (int) ($this->input->post_get('pageSize') ?: 20);
        $offset = (int) ((($this->input->post_get('currentPage') ?: 1) - 1) * $limit);
        $this->db->limit($limit, $offset);


        $userId = $this->input->post_get('userId');
        if (is_numeric($userId)) {
            $where = [];
            $where['zone.userId'] = $userId;

            $this->db->join('users', 'users.userId = zone.userId', 'left');
            $this->db->select('zone.*,avatar,usernick,sign,hxpassword');
//
            $list = $this->db->group_by('zone.id')->order_by('zone.id', 'DESC')->where($where)->get('zone')->result_array();
            for ($index = 0; $index < count($list); $index++) {
                $list[$index]['time'] = date('Y-m-d H:i:s', $list[$index]['time']);
            }
            if (!empty($list)) {
                $ids = array_column($list, 'id');
                $praises = $this->getPraises($ids, $uid);
                $comment = $this->getComment($ids, $uid);
                for ($index1 = 0; $index1 < count($list); $index1++) {
                    $list[$index1]['praisesAmount'] = count($praises[$list[$index1]['id']] ?? []);
                    $list[$index1]['commentAmount'] = count($comment[$list[$index1]['id']] ?? []);


                    $list[$index1]['praises'] = $praises[$list[$index1]['id']] ?? [];
                    $list[$index1]['comment'] = $comment[$list[$index1]['id']] ?? [];
                }
            }
            if (!empty($list)) {

                return $list;
            }
        }

        return 0;
    }

    /**
     * 朋友圈动态点赞
     */
    public function praiseTimeline($uid) {
        $zid = $this->input->post_get('tid');
        if (is_numeric($zid) && $this->db->select('id')->get_where('zone', ['id' => $zid], 1)->row_array()) {

            $where = [];
            $where['uid'] = $uid;
            $where['zid'] = $zid;
            if (!$this->db->select('id')->get_where('zone_praises', $where, 1)->row_array()) {
                $data = [];
                $data['zid'] = $zid;
                $data['uid'] = $uid;
                $data['time'] = time();
                if ($this->db->insert('zone_praises', $data)) {
                    return $this->db->insert_id();
                }
            }
        }
        return 0;
    }

    /**
     * 删除朋友圈动态点赞
     */
    public function deletePraiseTimeline($uid) {
        $pid = $this->input->post_get('pid');
        if (is_numeric($pid)) {
            $where = [];
            $where['uid'] = $uid;
            $where['id'] = $pid;
            return $this->db->limit(1)->where($where)->delete('zone_praises') ? 1 : 0;
        }
        return 0;
    }

    /**
     * 朋友圈动态评论
     * @param int $uid
     */
    public function commentTimeline($uid) {
        $zid = $this->input->post_get('tid');
        if (is_numeric($zid) && $this->db->select('id')->get_where('zone', ['id' => $zid], 1)->row_array()) {
            $data = [];
            $data['zid'] = $zid;
            $data['uid'] = $uid;
            $data['content'] = $this->input->post_get('content');
            $data['time'] = time();
            if ($this->db->insert('zone_comments', $data)) {
                $list = [];
                $list['cid'] = $this->db->insert_id();
                $this->db->where(['zone_comments.id' => $list['cid']]);
                $list['comments'] = $this->getComment($zid, $uid);
                return $list;
            }
        }
        return 0;
    }

    /**
     * 删除朋友圈动态评论
     */
    public function deleteCommentTimeline($uid) {
        $pid = $this->input->post_get('cid');
        if (is_numeric($pid)) {
            $where = [];
            $where['uid'] = $uid;
            $where['id'] = $pid;
            return $this->db->get_where('zone_comments', $where, 1)->row_array() && $this->db->limit(1)->where($where)->delete('zone_comments') ? 1 : -1;
        }
        return 0;
    }

    /**
     * 回复朋友圈动态评论
     */
    public function replyCommentTimeline($uid) {
        $cid = $this->input->post_get('cid');
        if (is_numeric($cid) && ($list = $this->db->get_where('zone_comments', ['id' => $cid], 1)->row_array()) && empty($list['replyUid'])) {
            $data = [];
            $data['replyUid'] = $uid;
            $data['replyContent'] = $this->input->post_get('content');
            $data['replyTime'] = time();
            if ($this->db->limit(1)->where('id', $cid)->set($data)->update('zone_comments')) {
                return $cid;
            }
        }
        return 0;
    }

    /**
     * 删除回复朋友圈动态评论
     */
    public function deleteReplyCommentTimeline($uid) {
        $cid = $this->input->post_get('crid');
        if (is_numeric($cid) && ($list = $this->db->get_where('zone_comments', ['id' => $cid], 1)->row_array()) && !empty($list['replyUid'])) {
            $data = [];
            $data['replyUid'] = '';
            $data['replyContent'] = '';
            $data['replyTime'] = '';
            if ($this->db->limit(1)->where('id', $cid)->or_group_start()->where('replyUid', $uid)->where('uid', $uid)->group_end()->set($data)->update('zone_comments')) {
                return 1;
            }
        }
        return 0;
    }

    /**
     * 获取朋友圈动态点赞
     */
    public function getPraises($id, $uid) {
        $this->db->select('zone_praises.id as pid,zone_praises.zid,userId,avatar,usernick as nickname,zone_praises.time');
        $this->db->join('users', 'users.userId = zone_praises.uid', 'left');

        if ($this->input->post_get('isFriend')) {
            $this->db->join('friend', 'friend.friend=zone_praises.uid AND friend.uid=' . $uid, 'inner');
        }

        $list = $this->db->order_by('zone_praises.id', 'ASC')->where_in('zid', $id)->get('zone_praises')->result_array();
        $praises = [];
        for ($index = 0; $index < count($list); $index++) {
            $list[$index]['time'] = date('Y-m-d H:i:s', $list[$index]['time']);
            $praises[$list[$index]['zid']][] = $list[$index];
        }
        return $praises;
    }

    /**
     * 获取朋友圈动态评论
     */
    public function getComment($id, $uid) {
        $this->db->select('zone_comments.id as cid,zone_comments.content,zone_comments.zid,B.userId,B.avatar,B.usernick as nickname,zone_comments.replyContent,C.userId as replyUid,C.avatar as replyAvatar,C.usernick as replyNickname,zone_comments.time,zone_comments.replyTime');
        $this->db->join('users AS B', 'B.userId = zone_comments.uid', 'left');
        $this->db->join('users AS C', 'C.userId = zone_comments.replyUid', 'left');

        if ($this->input->post_get('isFriend')) {
            $this->db->join('friend', 'friend.friend=zone_comments.uid AND friend.uid=' . $uid, 'inner');
        }
//->order_by('zone_comments.id', 'DESC')

        $list = $this->db->order_by('zone_comments.id', 'ASC')->where_in('zid', $id)->get('zone_comments')->result_array();
        $comments = [];
        for ($index = 0; $index < count($list); $index++) {
            $list[$index]['time'] = date('Y-m-d H:i:s', $list[$index]['time']);
            if (!empty($list[$index]['replyTime'])) {
                $list[$index]['replyTime'] = date('Y-m-d H:i:s', $list[$index]['replyTime']);
            } else {
                $list[$index]['replyTime'] = '';
            }
            $comments[$list[$index]['zid']][] = $list[$index];
        }
        return $comments;
    }

    /**
     * 获取动态评论列表
     */
    public function fetchTimelineComments($uid) {
        $zid = $this->input->post_get('tid');
        if (is_numeric($zid)) {
            $limit = (int) ($this->input->post_get('pageSize') ?: 20);
            $offset = (int) ((($this->input->post_get('currentPage') ?: 1) - 1) * $limit);
            $this->db->limit($limit, $offset);
            if ($this->input->post_get('isFriend')) {
                $this->db->join('friend', 'friend.friend=zone_comments.uid AND friend.uid=' . $uid, 'inner');
            }
            return $this->getComment($zid, $uid) ?: 1;
        }
        return 0;
    }

    /**
     * 获取动态赞列表
     */
    public function fetchTimelineParises($uid) {
        $zid = $this->input->post_get('tid');
        if (is_numeric($zid)) {
            $limit = (int) ($this->input->post_get('pageSize') ?: 20);
            $offset = (int) ((($this->input->post_get('currentPage') ?: 1) - 1) * $limit);
            $this->db->limit($limit, $offset);
            if ($this->input->post_get('isFriend')) {
                $this->db->join('friend', 'friend.friend=zone_praises.uid AND friend.uid=' . $uid, 'inner');
            }
            return $this->getPraises($zid, $uid) ?: 1;
        }
        return 0;
    }

}
