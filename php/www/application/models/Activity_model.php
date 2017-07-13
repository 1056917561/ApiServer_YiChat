<?php

/**
 * 活动
 * @author 费尔
 */
class Activity_model extends CI_Model {

    public function __construct() {
        //连接数据库
        $this->load->database();
    }

    /**
     * 发布活动
     * - title              活动主题
      - cover              活动封面
      - startTime          开始时间
      - endTime            结束时间 
      - activityPlace      活动地点
      - activityDesc       活动详情描述
      - activityType       活动类型
      - enteredSettings    报名设置
      - activityCost       费用
      - activityPeoples    人数
     */
    public function releaseActivity($uid) {
        $data = [];
        $data['uid'] = $uid;
        $data['title'] = (string) $this->input->post_get('title');
        $data['cover'] = (string) $this->input->post_get('cover');
        $data['startTime'] = (int) $this->input->post_get('startTime');
        $data['endTime'] = (int) $this->input->post_get('endTime');
        $data['activityPlace'] = (string) $this->input->post_get('activityPlace');
        $data['activityDesc'] = (string) $this->input->post_get('activityDesc');
        $data['activityType'] = (string) $this->input->post_get('activityType');
        $data['enteredSettings'] = (string) $this->input->post_get('enteredSettings');
        $data['activityCost'] = (double) $this->input->post_get('activityCost');
        $data['activityPeoples'] = (int) $this->input->post_get('activityPeoples');

        $data['isJoin'] = (int) $this->input->post_get('isJoin');
        $data['qrcode'] = (string) $this->input->post_get('qrcode');
        $data['groupName'] = (string) $this->input->post_get('groupName');

        $data['activityLat'] = (string) $this->input->post_get('activityLat');
        $data['activityLng'] = (string) $this->input->post_get('activityLng');
        $data['city'] = (string) $this->input->post_get('city');



//        if (empty($data['title']) || empty($data['startTime']) || empty($data['activityPlace']) || empty($data['activityDesc']) || empty($data['activityType']) || empty($data['qrcode']) || empty($data['groupName'])) {
//            return -1;
//        }



        $data['time'] = time();
        if ($this->db->insert('activity', $data)) {
            $aid = $this->db->insert_id();
            if (!empty($data['isJoin'])) {
                $data = [];
                $data['aid'] = $aid;
                $data['usertel'] = $this->input->post_get('usertel');
                $data['userId'] = (int) $uid;
                $data['time'] = time();
                $data['beizhu'] = $this->input->post_get('beizhu');
                $this->db->insert('activity_join', $data);
            }
            return $aid;
        }
        return -1;
    }

    /**
     * 删除活动
     */
    public function deleteActivity($uid) {
        $aid = $this->input->post_get('aId');
        if (is_numeric($aid) && $this->db->select('id')->get_where('activity', ['id' => (int) $aid, 'uid' => (int) $uid], 1)->row_array()) {

            if ($this->db->limit(1)->where(['id' => $aid])->delete('activity')) {
                $this->db->where(['aid' => $aid])->delete('activity_comments');
                $this->db->where(['aid' => $aid])->delete('activity_join');

                return 1;
            }
        }
        return -1;
    }
    public function remove($id) {
        if (is_numeric($id) && $this->db->select('id')->get_where('activity', ['id' => (int) $id], 1)->row_array()) {

            if ($this->db->limit(1)->where(['id' => $id])->delete('activity')) {
                $this->db->where(['aid' => $id])->delete('activity_comments');
                $this->db->where(['aid' => $id])->delete('activity_join');

                return 1;
            }
        }
        return -1;
    }

    /**
     * 更新活动
     */
    public function updateActivity($uid) {
        $id = $this->input->post_get('aId');
        if (is_numeric($id)) {
            $data = [];
            $data['title'] = $this->input->post_get('usertel');
            $data['cover'] = $this->input->post_get('cover');
            $data['startTime'] = strtotime($this->input->post_get('startTime'));
            $data['endTime'] = strtotime($this->input->post_get('endTime'));
            $data['activityPlace'] = $this->input->post_get('activityPlace');
            $data['activityDesc'] = $this->input->post_get('activityDesc');
            $data['activityType'] = $this->input->post_get('activityType');
            $data['enteredSettings'] = $this->input->post_get('enteredSettings');
            $data['activityCost'] = (double) $this->input->post_get('activityCost');
            $data['activityPeoples'] = (int) $this->input->post_get('activityPeoples');
            $data['time'] = time();
            $where = [];
            $where['uid'] = $uid;
            $where['id'] = (int) $id;
            return $this->db->limit(1)->where($where)->set($data)->update('activity') ? 1 : 0;
        }
        return -1;
    }

    /**
     * 获取活动列表
     */
    public function getMyActivityList($uid) {
        $limit = (int) ($this->input->post_get('pageSize') ?: 100);
        $offset = (int) ((($this->input->post_get('currentPage') ?: 1) - 1) * $limit);
        $this->db->limit($limit, $offset);
        $where = [];
        if ($this->input->post_get('type')) {
            $where['activityType'] = $this->input->post_get('type');
        }
        if ($this->input->post_get('ispublisher')) {
            $where['uid'] = (int) $uid;
        } else {
            $where['activity_join.userId'] = (int) $uid;
            $this->db->join('activity_join', 'activity_join.aid = activity.id', 'inner');
        }
        $list = $this->db->where($where)->order_by('activity.id', 'DESC')->get('activity')->result_array();

        if (!empty($list)) {
            for ($index = 0; $index < count($list); $index++) {
                $list[$index]['time'] = date('Ymd'); //, $list[$index]['time']

                $this->getActivityUsers($uid, $list[$index]);
//                if (!isset($list[$index]['state'])) {
//                    $list[$index]['state'] = 0;
//                }
            }
            return $list;
        }
        return -1;
    }

    /**
     * 获取活动列表
     */
    public function getActivityList($uid) {
        if ((int) $this->input->post_get('type') !== 5) {//type = 5 不分页
            $limit = (int) ($this->input->post_get('pageSize') ?: 100);
            $offset = (int) ((($this->input->post_get('currentPage') ?: 1) - 1) * $limit);
            $this->db->limit($limit, $offset);
        }
        $where = [];
//        if ($this->input->post_get('type')) {
//            $where['activityType'] = $this->input->post_get('type');
//        }
        if ($this->input->post_get('type')) {
            switch ($this->input->post_get('type')) {
                case "1":$this->input->post_get('content') && $this->db->like('activity.city', $this->input->post_get('content'));
                    break;
                case "2":$this->input->post_get('content') && $this->db->like('activity.title', $this->input->post_get('content'));
                    break;
                case "3":
                    if ($this->input->post_get('content')) {
                        $lat_lng = explode('_', $this->input->post_get('content'));
                        if (!empty($lat_lng[0]) && !empty($lat_lng[1])) {
                            // $lat_lng 经纬度
                            $squares = $this->returnSquarePoint($lat_lng[1], $lat_lng['0']);
                            $where['activityLat<>'] = 0;
                            $where['activityLat>'] = $squares['right-bottom']['lat'];
                            $where['activityLat<'] = $squares['left-top']['lat'];
                            $where['activityLng>'] = $squares['left-top']['lng'];
                            $where['activityLng<'] = $squares['right-bottom']['lng'];
                        } else {
                            return -1;
                        }
                    } else {
                        return -1;
                    }

                    break;
                case "4":$this->input->post_get('content') && $where['activityType'] = $this->input->post_get('content');
                    break;
                case "5":
                    $data = $this->db->where(['userId' => $uid])->get('activity_join')->result_array();
                    $data2 = $this->db->where(['uid' => $uid])->get('activity')->result_array();
                    $aids = [];
                    foreach ($data as $d) {
                        $aids[] = $d['aid'];
                    }
                    foreach ($data2 as $val) {
                        $aids[] = $val['id'];
                    }
                    if (empty($aids))
                        return -1;
                    $this->db->where_in('id', $aids);
                    // $where['uid !='] = $uid;
                    break;
                case "6":$this->db->where_in('uid', $uid);
                    break;
            }
        }
        $list = $this->db->where($where)->order_by('activity.id', 'DESC')->get('activity')->result_array();

        if (!empty($list)) {
            for ($index = 0; $index < count($list); $index++) {
                $list[$index]['time'] = date('Ymd'); //, $list[$index]['time']

                $this->getActivityUsers($uid, $list[$index]);
//                if (!isset($list[$index]['state'])) {
//                    $list[$index]['state'] = 0;
//                }
            }
            return $list;
        }
        return -1;
    }

    public function getActivityUsers($uid, &$list) {
        $list['user'] = $this->db->select('avatar,usernick,sign,hxpassword')->get_where('users', ['userId' => (int) $list['uid']], 1)->row_array() ?: [];
        $list['state'] = $this->db->get_where('activity_join', ['userId' => $uid, 'aid' => $list['id']], 1)->row_array()['state'] ?? 0;
        $count = $this->db->limit(1)->where(['aid' => $list['id']])->select('COUNT(DISTINCT c_activity_join.id) AS count')->get('activity_join')->row_array();
        $list['activityPeoples'] = !empty($count['count']) ? $count['count'] : 0;
    }

    /**
     * 计算某个经纬度的周围某段距离的正方形的四个点
     * @param  radius 地球半径 平均6371km
     * @param  lng float 经度
     * @param  lat float 纬度
     * @param  distance float 该点所在圆的半径，该圆与此正方形内切，默认值为100千米
     * @return array 正方形的四个点的经纬度坐标
     */
    public function returnSquarePoint($lng, $lat, $distance = 100, $radius = 6371) {
        $dlng = 2 * asin(sin($distance / (2 * $radius)) / cos(deg2rad($lat)));
        $dlng = rad2deg($dlng);

        $dlat = $distance / $radius;
        $dlat = rad2deg($dlat);

        return array(
            'left-top' => array(
                'lat' => $lat + $dlat,
                'lng' => $lng - $dlng
            ),
            'right-top' => array(
                'lat' => $lat + $dlat,
                'lng' => $lng + $dlng
            ),
            'left-bottom' => array(
                'lat' => $lat - $dlat,
                'lng' => $lng - $dlng
            ),
            'right-bottom' => array(
                'lat' => $lat - $dlat,
                'lng' => $lng + $dlng
            )
        );
    }

    /**
     * 获取活动详情
     */
    public function getActivityDetails($uid) {
        $aid = $this->input->post_get('aId');
        if (is_numeric($aid)) {
            $list = $this->db->get_where('activity', ['id' => $aid], 1)->row_array();
            if (!empty($list)) {
                $list['time'] = date('Ymd');
                $this->getActivityUsers($uid, $list);
//                if (!isset($list['state'])) {
//                    $list['state'] = $list['state'];
//                }
                return $list;
            }
        }
        return -1;
    }

    /**
     * 取消报名
     * @param int $uid
     */
    public function ignoreActivity($uid) {
        $aid = $this->input->post_get('aId');
        if (is_numeric($aid)) {
            $list = $this->db->select('id')->get_where('activity_join', ['aid' => (int) $aid, 'userId' => (int) $uid, 'state' => 1], 1)->row_array();
            if (!empty($list)) {
                $this->db->limit(1)->where(['aid' => (int) $aid, 'userId' => (int) $uid, 'state' => 1])->set(['state' => 2])->update('activity_join');
            } else {
                $this->db->insert('activity_join', ['aid' => (int) $aid, 'userId' => (int) $uid, 'state' => 2]);
            }
            return 1;
        }
        return -1;
    }

    /**
     * 签到
     * @param int $uid
     */
    public function clockActivity($uid) {
        //$qrcode = $this->input->post_get('qrcode'); 
        $aid = $this->input->post_get('aid');
        $list = $this->db->select('id,startTime')->get_where('activity', ['id' => $aid], 1)->row_array();
        if (empty($list)) {
            return -2;
        }
        if ((int) $list['startTime'] !== (int) date('Ymd')) {
            return -3;
        }
        $data = [];
        $data['aid'] = (int) $this->input->post_get('aid');
        $data['username'] = $this->input->post_get('username');
        $data['sex'] = $this->input->post_get('sex');
        $data['type'] = (int) $this->input->post_get('type');
        $data['tel'] = $this->input->post_get('tel');
        $data['time'] = time();
        if ($data['type'] === 2) {
            $data['proxyclockuid'] = $uid;
        } else {
            $data['uid'] = $uid;
        }
//        if ($this->db->select('userId')->get_where('users', ['tel' => $data['tel']], 1)->row_array()) {
//            $data['uid'] = $uid;
//        }
        return $this->db->insert('activity_clock', $data) ? 1 : -1;
    }

//    public function clockActivity($uid) {
//        //$qrcode = $this->input->post_get('qrcode'); 
//        $aid = $this->input->post_get('aid');
//        $list = $this->db->select('id,startTime')->get_where('activity', ['id' => $aid], 1)->row_array();
//
//        if (empty($list)) {
//            return -2;
//        }
//        if ((int) $list['startTime'] !== (int) date('Ymd')) {
//            return -3;
//        }
//
//        if ($this->db->select('id')->get_where('activity_join', ['aid' => (int) $list['id'], 'userId' => (int) $uid, 'state' => 1], 1)->row_array()) {
//            $data = [];
//            $data['state'] = 3;
//            $data['username'] = $this->input->post_get('username');
//            $data['sex'] = $this->input->post_get('sex');
//            $data['type'] = $this->input->post_get('type');
//            $data['tel'] = $this->input->post_get('tel');
//            $this->db->limit(1)->where(['aid' => (int) $list['id'], 'userId' => (int) $uid, 'state' => 1])->set($data)->update('activity_join');
//            return 1;
//        }
//        // echo $this->db->last_query();
//        return -1;
//    }

    /**
     * 活动报名
     */
    public function joinActivity($uid) {
        $aid = $this->input->post_get('aId');
        if (is_numeric($aid) && $this->db->select('id')->get_where('activity', ['id' => $aid], 1)->row_array()) {

            $list = $this->db->select('id,state')->get_where('activity_join', ['aid' => $aid, 'userId' => $uid], 1)->row_array();
            if (!empty($list['state'])) {
                if ((int) $list['state'] === 3) {
                    return -1;
                } elseif ((int) $list['state'] === 1) {
                    return 1;
                } elseif ((int) $list['state'] === 2) {
                    $this->db->limit(1)->where('id', (int) $list['id'])->set(['state' => 1])->update('activity_join');
                    return 1;
                }
            }
            $data = [];
            $data['aid'] = $aid;
            $data['userId'] = $uid;
            $data['usertel'] = $this->input->post_get('usertel');
            $data['isEat'] = $this->input->post_get('isEat');
            $data['time'] = time();
            $data['beizhu'] = $this->input->post_get('beizhu');
            if ($this->db->insert('activity_join', $data)) {
                return 1; //$this->db->insert_id();
            }
        }
        return -1;
    }

    /**
     * 获取报名人员列表
     */
    public function getJoinActivityMembers($uid) {
        $aid = $this->input->post_get('aId');
        if (is_numeric($aid) && $this->db->select('id')->get_where('activity', ['id' => $aid], 1)->row_array()) {
            $where = [];
            $where['aid'] = $aid;
            //$where['uid'] = $uid;
            $this->db->select('activity_join.usertel,users.userId,users.avatar,users.usernick as nickname,activity_join.time,activity_join.beizhu,activity_join.state,users.role,activity_join.isEat');
            $this->db->join('users', 'users.userId = activity_join.userId', 'left');
            $list = $this->db->where($where)->get('activity_join')->result_array();
            for ($index = 0; $index < count($list); $index++) {
                $list[$index]['time'] = date('Y-m-d H:i:s', $list[$index]['time']);
            }
            return $list;
        }
        return -1;
    }

    /**
     * 活动打卡人员列表
     */
    public function getClockMembers($uid) {
        $aid = $this->input->post_get('aId');
        if (is_numeric($aid) && $this->db->select('id')->get_where('activity', ['id' => $aid], 1)->row_array()) {
            $where = [];
            $where['aid'] = $aid;
            // $where['state'] = 3;
            //  $this->db->select('activity_join.tel,activity_join.sex,activity_join.type,activity_join.username');
            // $list = $this->db->where($where)->get('activity_join')->result_array();
            $this->db->select('activity_clock.tel,activity_clock.sex,activity_clock.type,activity_clock.username');
            $list = $this->db->where($where)->get('activity_clock')->result_array();
            return !empty($list) ? $list : -1;
        }
        return -1;
    }

    /**
     * 对活动进行评论
     */
    public function commentActivity($uid) {
        $aid = $this->input->post_get('aId');
        if (is_numeric($aid) && $this->db->select('id')->get_where('activity', ['id' => $aid], 1)->row_array()) {
            $data = [];
            $data['aid'] = $aid;
            $data['uid'] = $uid;
            $data['content'] = $this->input->post_get('content');
            $data['time'] = time();
            if ($this->db->insert('activity_comments', $data)) {
                return $this->db->insert_id();
            }
        }
        return -1;
    }

    /**
     * 删除对活动进行评论
     */
    public function deleteActivityComment($uid) {
        $acid = $this->input->post_get('acid');
        if (is_numeric($acid)) {
            $where = [];
            $where['uid'] = $uid;
            $where['id'] = $acid;
            return $this->db->limit(1)->where($where)->delete('activity_comments') ? 1 : 0;
        }
        return -1;
    }

    /**
     * 点赞活动评论
     */
    public function praiseComment($uid) {
        $acid = $this->input->post_get('acid');
        if (is_numeric($acid) && $this->db->select('id')->get_where('activity_comments', ['id' => $acid], 1)->row_array()) {

            $where = [];
            $where['uid'] = $uid;
            $where['acid'] = $acid;
            if (!$this->db->select('id')->get_where('c_activity_comments_praises', $where, 1)->row_array()) {
                $data = [];
                $data['acid'] = $acid;
                $data['uid'] = $uid;
                $data['time'] = time();
                if ($this->db->insert('c_activity_comments_praises', $data)) {
                    return $this->db->insert_id();
                }
            }
        }
        return -1;
    }

    /**
     * 取消点赞活动评论
     */
    public function deletePraiseComment($uid) {
        $id = $this->input->post_get('apid');
        if (is_numeric($id)) {
            $where = [];
            $where['uid'] = $uid;
            $where['id'] = $id;
            return $this->db->limit(1)->where($where)->delete('c_activity_comments_praises') ? 1 : 0;
        }
        return -1;
    }

    /**
     * 回复该活动下的评论
     */
    public function replyComment($uid) {
        $acid = $this->input->post_get('acid');
        if (is_numeric($acid) && $this->db->select('id')->get_where('activity_comments', ['id' => $acid], 1)->row_array()) {
            $data = [];
            $data['acid'] = $acid;
            $data['uid'] = $uid;
            $data['content'] = $this->input->post_get('content');
            $data['time'] = time();
            if ($this->db->insert('activity_comments_reply', $data)) {
                return $this->db->insert_id();
            }
        }
        return -1;
    }

    /**
     * 删除评论下的回复
     */
    public function deleteActivityCommentReply($uid) {
        $acrid = $this->input->post_get('acrid');
        if (is_numeric($acrid) && $this->db->select('id')->get_where('activity_comments_reply', ['id' => $acrid], 1)->row_array()) {
            $where = [];
            $where['uid'] = $uid;
            $where['id'] = $acrid;
            return $this->db->limit(1)->where($where)->delete('activity_comments_reply') ? 1 : 0;
        }
        return -1;
    }

    /**
     * 获取活动的评论列表
     */
    public function getCommentList($uid) {
        $aid = $this->input->post_get('aId');
        if (is_numeric($aid) && $this->db->select('id')->get_where('activity', ['id' => $aid], 1)->row_array()) {
            $where = [];
            $where['aid'] = $aid;
            $this->db->select('activity_comments.id as acid,activity_comments.content as comment,users.userId,users.avatar,users.usernick as nickname,activity_comments.time');


            $this->db->join('users', 'users.userId = activity_comments.uid', 'left');



            $list = $this->db->where($where)->group_by('activity_comments.id')->get('activity_comments')->result_array();
            for ($index = 0; $index < count($list); $index++) {
                $list[$index]['time'] = date('Y-m-d H:i:s', $list[$index]['time']);
                $list[$index]['praiseAmount'] = $this->db->where(['acid' => $list[$index]['acid']])->count_all_results('activity_comments_praises');
                $list[$index]['commentAmout'] = $this->db->where(['acid' => $list[$index]['acid']])->count_all_results('activity_comments_reply');
            }
            //print_r($this->db->last_query());
            return $list;
        }
        return -1;
    }

    /**
     * 获取活动评论的点赞列表
     */
    public function getCommentPraiseList($uid) {
        $acid = $this->input->post_get('acid');
        if (is_numeric($acid) && $this->db->select('id')->get_where('activity_comments', ['id' => $acid], 1)->row_array()) {
            $where = [];
            $where['acid'] = $acid;
            $this->db->select('users.userId,users.avatar,users.usernick as nickname,activity_comments_reply.time');


            $this->db->join('users', 'users.userId = activity_comments_reply.uid', 'left');



            $list = $this->db->where($where)->group_by('activity_comments_reply.id')->get('activity_comments_reply')->result_array();
            for ($index = 0; $index < count($list); $index++) {
                $list[$index]['time'] = date('Y-m-d H:i:s', $list[$index]['time']);
            }
            return $list;
        }
        return -1;
    }

    /**
     * 获取活动评论下的回复列表
     */
    public function getCommentReplyCommentList($uid) {
        $acid = $this->input->post_get('acid');
        if (is_numeric($acid)) {
            $where = [];
            $where['activity_comments_reply.acid'] = $acid;
            $this->db->select('activity_comments_reply.content as comment,users.userId,users.avatar,users.usernick as nickname,activity_comments_reply.time,COUNT(DISTINCT B.id) as praiseAmount');


            $this->db->join('users', 'users.userId = activity_comments_reply.uid', 'left');

            $this->db->join('activity_comments_reply_praises as B', 'B.acrid=activity_comments_reply.id', 'left');



            $list = $this->db->where($where)->group_by('activity_comments_reply.id')->get('activity_comments_reply')->result_array();


            if (!empty($list)) {
                for ($index = 0; $index < count($list); $index++) {
                    $list[$index]['time'] = date('Y-m-d H:i:s', $list[$index]['time']);
                }
                return $list;
            }
        }
        return -1;
    }

    /**
     * 点赞活动评论
     */
    public function praiseReplycontent($uid) {
        $acid = $this->input->post_get('acrid');
        if (is_numeric($acid) && $this->db->select('id')->get_where('activity_comments_reply', ['id' => $acid], 1)->row_array()) {

            $where = [];
            $where['uid'] = $uid;
            $where['acid'] = $acid;
            if (!$this->db->select('id')->get_where('activity_comments_reply_praises', $where, 1)->row_array()) {
                $data = [];
                $data['acid'] = $acid;
                $data['uid'] = $uid;
                $data['time'] = time();
                if ($this->db->insert('activity_comments_reply_praises', $data)) {
                    return $this->db->insert_id();
                }
            }
        }
        return -1;
    }

    /**
     * 取消点赞活动评论
     */
    public function deletePraiseReplycontent($uid) {
        $id = $this->input->post_get('acpid');
        if (is_numeric($id)) {
            $where = [];
            $where['uid'] = $uid;
            $where['id'] = $id;
            return $this->db->limit(1)->where($where)->delete('activity_comments_reply_praises') ? 1 : 0;
        }
        return -1;
    }

    /**
     * 返回活动列表
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function get_list($page = 1, $limit = 20) {
        $where = [];
        $userlist = $this->ion_auth->user()->row_array();
        if ($userlist['region']) {
            $where['users.area_id'] = $userlist['region'];
        }
        $this->db->where($where);
        if ($this->input->post_get('date')) {
            $date = $this->input->post_get('date');
            if (date('Y-m-d', strtotime($date)) === $date) {
                $this->db->where(['activity.time >=' => strtotime($date . ' 00:00:00')])->where(['activity.time <=' => strtotime($date . ' 23:59:59')]);
            }
        }

        if ($this->input->post_get('keyword')) {
            $this->db->like('activity.content', $this->input->post_get('keyword'));
        }
        if ($this->input->post_get('usernick')) {
            $this->db->like('users.usernick', $this->input->post_get('usernick'));
        }

        $offset = (int) (($page - 1) * $limit);
        $this->db->limit($limit, $offset);

        $this->db->join('users', 'users.userId=activity.uid', 'left');
        $this->db->join('activity_comments', 'activity_comments.aid=activity.id', 'left');
        $this->db->join('activity_join', 'activity_join.aid=activity.id', 'left');
        $this->db->join('activity_clock', 'activity_clock.aid=activity.id', 'left');

        $select = 'activity.*,users.usernick,COUNT(DISTINCT c_activity_comments.id) AS comments,COUNT(DISTINCT c_activity_join.id) AS population,COUNT(DISTINCT c_activity_clock.id) AS clock';

        $list = $this->db->group_by('activity.id')->order_by('activity.id', 'DESC')->select($select)->get('activity')->result_array();

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
     * 返回活动总数
     * @return int
     */
    public function get_count() {
        $where = [];
        $userlist = $this->ion_auth->user()->row_array();
        if ($userlist['region']) {
            $where['users.area_id'] = $userlist['region'];
        }
        $this->db->where($where);
        if ($this->input->post_get('date')) {
            $date = $this->input->post_get('date');
            if (date('Y-m-d', strtotime($date)) === $date) {
                $this->db->where(['activity.time >=' => strtotime($date . ' 00:00:00')])->where(['activity.time <=' => strtotime($date . ' 23:59:59')]);
            }
        }
        if ($this->input->post_get('keyword')) {
            $this->db->like('activity.content', $this->input->post_get('keyword'));
        }
        if ($this->input->post_get('usernick')) {
            $this->db->like('users.usernick', $this->input->post_get('usernick'));
        }


        $this->db->join('users', 'users.userId=' . 'activity.uid', 'left');

        $list = $this->db->limit(1)->select('COUNT(DISTINCT c_activity.id) AS activitycount')->get('activity')->row_array();
        return !empty($list['activitycount']) ? $list['activitycount'] : 0;
    }

    /**
     * 返回活动报名列表
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function getActivityJoinList($page = 1, $limit = 20) {
        $where = [];
//        $userlist = $this->ion_auth->user()->row_array();
//        if ($userlist['region']) {
//            $where['users.area_id'] = $userlist['region'];
//        }
        if ($this->input->post_get('id')) {
            $where['activity_join.aid'] = $this->input->post_get('id');
        }
        $this->db->where($where);
        if ($this->input->post_get('date')) {
            $date = $this->input->post_get('date');
            if (date('Y-m-d', strtotime($date)) === $date) {
                $this->db->where(['activity_join.time >=' => strtotime($date . ' 00:00:00')])->where(['activity_join.time <=' => strtotime($date . ' 23:59:59')]);
            }
        }
        if ($this->input->post_get('usernick')) {
            $this->db->like('users.usernick', $this->input->post_get('usernick'));
        }
        $offset = (int) (($page - 1) * $limit);
        $this->db->limit($limit, $offset);

        $this->db->join('users', 'users.userId=activity_join.userId', 'left');

        $select = 'activity_join.*,users.usernick,users.tel as usertel';

        $list = $this->db->group_by('activity_join.id')->order_by('activity_join.id', 'DESC')->select($select)->get('activity_join')->result_array();

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
     * 返回活动打卡列表
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function getActivityClockList($page = 1, $limit = 20) {
        $where = [];
//        $userlist = $this->ion_auth->user()->row_array();
//        if ($userlist['region']) {
//            $where['users.area_id'] = $userlist['region'];
//        }
        if ($this->input->post_get('id')) {
            $where['activity_clock.aid'] = $this->input->post_get('id');
        }
        $this->db->where($where);
        if ($this->input->post_get('date')) {
            $date = $this->input->post_get('date');
            if (date('Y-m-d', strtotime($date)) === $date) {
                $this->db->where(['activity_clock.time >=' => strtotime($date . ' 00:00:00')])->where(['activity_clock.time <=' => strtotime($date . ' 23:59:59')]);
            }
        }

        if ($this->input->post_get('keyword')) {
            $this->db->like('activity_clock.username', $this->input->post_get('keyword'));
        }
        $offset = (int) (($page - 1) * $limit);
        $this->db->limit($limit, $offset);

        $this->db->join('users', 'users.userId=activity_clock.uid', 'left');

        $select = 'activity_clock.*,users.usernick,users.tel as usertel';

        $list = $this->db->group_by('activity_clock.id')->order_by('activity_clock.id', 'DESC')->select($select)->get('activity_clock')->result_array();
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
     * 返回活动报名总数
     */
    public function getJoin_count() {
        $where = [];
//        $userlist = $this->ion_auth->user()->row_array();
//        if ($userlist['region']) {
//            $where['users.area_id'] = $userlist['region'];
//        }
        if ($this->input->post_get('id')) {
            $where['activity_join.aid'] = $this->input->post_get('id');
        }
        $this->db->where($where);

        if ($this->input->post_get('date')) {
            $date = $this->input->post_get('date');
            if (date('Y-m-d', strtotime($date)) === $date) {
                $this->db->where(['activity_join.time >=' => strtotime($date . ' 00:00:00')])->where(['activity_join.time <=' => strtotime($date . ' 23:59:59')]);
            }
        }
        if ($this->input->post_get('usernick')) {
            $this->db->like('users.usernick', $this->input->post_get('usernick'));
        }


        $this->db->join('users', 'users.userId=' . 'activity_join.userId', 'left');

        $list = $this->db->limit(1)->select('COUNT(DISTINCT c_activity_join.id) AS activitycount')->get('activity_join')->row_array();
        return !empty($list['activitycount']) ? $list['activitycount'] : 0;
    }

    /**
     * 返回活动打卡总数
     */
    public function getClock_count() {
        $where = [];
//        $userlist = $this->ion_auth->user()->row_array();
//        if ($userlist['region']) {
//            $where['users.area_id'] = $userlist['region'];
//        }
        if ($this->input->post_get('id')) {
            $where['activity_clock.aid'] = $this->input->post_get('id');
        }
        $this->db->where($where);
        if ($this->input->post_get('date')) {
            $date = $this->input->post_get('date');
            if (date('Y-m-d', strtotime($date)) === $date) {
                $this->db->where(['activity_clock.time >=' => strtotime($date . ' 00:00:00')])->where(['activity_clock.time <=' => strtotime($date . ' 23:59:59')]);
            }
        }
        if ($this->input->post_get('keyword')) {
            $this->db->like('activity_clock.username', $this->input->post_get('keyword'));
        }

        $this->db->join('users', 'users.userId=' . 'activity_clock.uid', 'left');

        $list = $this->db->limit(1)->select('COUNT(DISTINCT c_activity_clock.id) AS activitycount')->get('activity_clock')->row_array();
        return !empty($list['activitycount']) ? $list['activitycount'] : 0;
    }

}
