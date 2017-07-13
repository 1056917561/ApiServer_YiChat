<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    private $uid;

    /**
     * 注册
     */
    public function register() {
        $users = $this->usersModel()->register();
        if (is_numeric($users)) {
            $this->error($users);
        } else {
            $this->success(['user' => is_array($users) ? $users : '']);
        }
    }

    /**
     * 登录
     */
    public function login() {
        $users = $this->usersModel()->login();
        if (is_numeric($users)) {
            $this->error($users);
        } else {
            $this->load->model('friend_model');
            $friend = $this->friend_model->fetchFriends($users['userId'], $users['myTeam']);
            $users['friend'] = is_array($friend) ? $friend : [];
            $users['teams'] = $this->db->order_by('id', 'ASC')->get('users_group')->result_array();
            $users['bigRegions'] = $this->db->order_by('id', 'ASC')->get('area')->result_array();
            $users['roles'] = $this->db->order_by('id', 'ASC')->get('users_attribute')->result_array();
            $users['activityTypes'] = $this->db->order_by('id', 'ASC')->get('activity_type')->result_array();
            $this->success(['user' => is_array($users) ? $users : '']);
        }
    }

    /**
     * 第三方登录
     */
    public function thirdlogin() {
        $users = $this->usersModel()->thirdlogin();
        if (is_numeric($users)) {
            $this->error($users);
        } else {
            $this->success(['user' => is_array($users) ? $users : '']);
        }
    }

    /**
     * 搜索用户
     */
    public function searchuser() {
        $this->initsession();
        $users = $this->usersModel()->searchUser($this->uid);
        if (is_numeric($users)) {
            $this->error(-1);
        } else {
            $this->success(['user' => $users]);
        }
    }

    /**
     * 获取好友列表
     */
    public function fetchfriends() {
        $this->initsession();
        $this->load->model('friend_model');
        $list = $this->db->get_where('users', ['userId' => $this->uid], 1)->row_array();
        $users = $this->friend_model->fetchFriends($this->uid, $list['group_id']);
        if (is_numeric($users)) {
            $this->error(-1);
        } else {
            $this->success(['user' => $users]);
        }
    }

    /**
     * 获取好友列表
     */
    public function eggs() {
        $this->initsession();
        $this->load->model('friend_model');
        $users = $this->friend_model->fetchEggs($this->uid);
        if (is_numeric($users)) {
            $this->error(-1);
        } else {
            $this->success(['user' => $users]);
        }
    }

    /**
     * 新增好友
     */
    public function addfriend() {
        $this->initsession();
        $this->load->model('friend_model');
        $users = $this->friend_model->addFriend($this->uid);
        $this->error($users);
    }

    /**
     * userId或者凡信Id查找用户
     */
    public function getuserinfo() {
        $this->initsession();
        $users = $this->usersModel()->getUserInfo();
        if (is_numeric($users)) {
            $this->error(-1);
        } else {
            $this->success(['user' => $users]);
        }
    }

    /**
     * 删除好友
     */
    public function removefriend() {
        $this->initsession();
        $this->load->model('friend_model');
        $users = $this->friend_model->removeFriend($this->uid);
        $this->error($users);
    }

    /**
     * 加入黑名单
     */
    public function addblacklist() {
        $this->initsession();
        $this->load->model('friend_model');
        $users = $this->friend_model->addBlackList($this->uid);
        $this->error($users);
    }

    /**
     * 移除黑名单
     */
    public function removeblacklist() {
        $this->initsession();
        $this->load->model('friend_model');
        $users = $this->friend_model->removeBlackList($this->uid);
        $this->error($users);
    }

    /**
     * 获取黑名单列表
     */
    public function fetchblacklist() {
        $this->initsession();
        $this->load->model('friend_model');
        $users = $this->friend_model->fetchBlackList($this->uid);
        if (is_numeric($users)) {
            $this->error(-1);
        } else {
            $this->success(['user' => $users]);
        }
    }

    /**
     * 查询用户是否在黑名单
     */
    public function searchtoblacklist() {
        $this->initsession();
        $this->load->model('friend_model');
        $users = $this->friend_model->searchToBlackList($this->uid);
        $this->error($users);
    }

    /**
     * 重置密码
     */
    public function resetpassword() {
        // $this->initsession();
        $users = $this->usersModel()->resetPassword($this->uid);
        $this->error($users);
    }

    /**
     * 更新
     */
    public function update() {
        $this->initsession();
        $users = $this->usersModel()->update($this->uid);
        $this->error($users);
    }

    /**
     * 发布社区动态
     */
    public function publish() {
        $this->initsession();
        $this->load->model('zone_model');
        $id = $this->zone_model->publish($this->uid);
        if ($id > 0) {
            $this->success(['tid' => $id]);
        }
        $this->error($id);
    }

    /**
     * 删除一条动态
     */
    public function removetimeline() {
        $this->initsession();
        $this->load->model('zone_model');
        $list = $this->zone_model->removeTimeline($this->uid);
        $this->error($list);
    }

    /**
     * 获取动态列表
     */
    public function fetchtimeline() {
        $this->initsession();
        $this->load->model('zone_model');
        $list = $this->zone_model->fetchTimeline($this->uid);
        if (!empty($list)) {
            $info = [];
            $info['time'] = date('Y-m-d H:i:s');
            $info['data'] = $list;
            $this->success($info);
        } else {
            $this->error(-1);
        }
    }

    /**
     * 查看别人动态列表
     */
    public function fetchothertimeline() {
        $this->initsession();
        $this->load->model('zone_model');
        $list = $this->zone_model->fetchOtherTimeline($this->uid);
        if (!empty($list) && is_array($list)) {
            $this->success(['data' => $list]);
        } else {
            $this->error(-1);
        }
        $this->error(0);
    }

    /**
     * 朋友圈动态点赞
     */
    public function praisetimeline() {
        $this->initsession();
        $this->load->model('zone_model');
        $pid = $this->zone_model->praiseTimeline($this->uid);
        if ($pid > 0) {
            $this->success(['pid' => $pid]);
        }
        $this->error($pid);
    }

    /**
     * 删除朋友圈动态点赞
     */
    public function deletepraisetimeline() {
        $this->initsession();
        $this->load->model('zone_model');
        $list = $this->zone_model->deletePraiseTimeline($this->uid);
        $this->error($list);
    }

    /**
     * 朋友圈动态评论
     */
    public function commenttimeline() {
        $this->initsession();
        $this->load->model('zone_model');
        $cid = $this->zone_model->commentTimeline($this->uid);
        if (is_array($cid)) {
            $this->success($cid);
        }
        $this->error($cid);
    }

    /**
     * 删除朋友圈动态评论
     */
    public function deletecommenttimeline() {
        $this->initsession();
        $this->load->model('zone_model');
        $list = $this->zone_model->deleteCommentTimeline($this->uid);
        $this->error($list);
    }

    /**
     * 回复朋友圈动态评论
     */
    public function replycommenttimeline() {
        $this->initsession();
        $this->load->model('zone_model');
        $cid = $this->zone_model->replyCommentTimeline($this->uid);
        if ($cid > 0) {
            $this->success(['crid' => $cid]);
        }
        $this->error($cid);
    }

    /**
     * 删除回复朋友圈动态评论
     */
    public function deletereplycommenttimeline() {
        $this->initsession();
        $this->load->model('zone_model');
        $list = $this->zone_model->deleteReplyCommentTimeline($this->uid);
        $this->error($list);
    }

    /**
     * 获取动态评论列表
     */
    public function fetchtimelinecomments() {
        $this->initsession();
        $this->load->model('zone_model');
        $list = $this->zone_model->fetchTimelineComments($this->uid);
        if (is_array($list)) {
            $this->success(['comments' => $list]);
        } else {
            $this->error(-1);
        }
        // $this->error($list);
    }

    /**
     * 获取动态评论列表
     */
    public function fetchtimelineparises() {
        $this->initsession();
        $this->load->model('zone_model');
        $list = $this->zone_model->fetchTimelineParises($this->uid);
        if (is_array($list)) {
            $this->success(['praises' => $list]);
        } else {
            $this->error(-1);
        }
        //$this->error($list);
    }

    /**
     * 发布活动
     */
    public function releaseactivity() {
        $this->initsession();
        $this->load->model('activity_model');
        $aid = $this->activity_model->releaseActivity($this->uid);
        if ($aid > 0) {
            $this->success(['aId' => $aid]);
        }
        $this->error($aid);
    }

    /**
     * 删除活动
     */
    public function deleteactivity() {
        $this->initsession();
        $this->load->model('activity_model');
        $list = $this->activity_model->deleteActivity($this->uid);
        $this->error($list);
    }

    /**
     * 更新活动
     */
    public function updateactivity() {
        $this->initsession();
        $this->load->model('activity_model');
        $list = $this->activity_model->updateActivity($this->uid);
        $this->error($list);
    }

    public function getmyactivityList() {
        $this->initsession();
        //$this->uid = 100093;
        $this->load->model('activity_model');
        $list = $this->activity_model->getMyActivityList($this->uid);
        if (is_array($list)) {
            $this->success(['data' => $list]);
        } else {
            $this->error(-1);
        }
    }

    /**
     * 获取活动列表
     */
    public function getactivitylist() {
        $this->initsession();
        //$this->uid = 100093;
        $this->load->model('activity_model');
        $list = $this->activity_model->getActivityList($this->uid);
        if (is_array($list)) {
            $this->success(['data' => $list]);
        } else {
            $this->error(-1);
        }
        //$this->error($list);
    }

    /**
     * 获取活动详情
     */
    public function getactivitydetails() {
        $this->initsession();

        $this->load->model('activity_model');
        $list = $this->activity_model->getActivityDetails($this->uid);
        if (is_array($list)) {
            $this->success(['data' => $list]);
        } else {
            $this->error(-1);
        }
        //$this->error($list);
    }

    /**
     * 活动报名
     */
    public function joinactivity() {
        $this->initsession();
        $this->load->model('activity_model');
        $list = $this->activity_model->joinActivity($this->uid);
        $this->error($list);
    }

    /**
     * 取消报名
     */
    public function ignoreactivity() {
        $this->initsession();
        $this->load->model('activity_model');
        $list = $this->activity_model->ignoreActivity($this->uid);
        $this->error($list);
    }

    /**
     * 签到
     */
    public function clockactivity() {
        $this->initsession();
        $this->load->model('activity_model');
        $list = $this->activity_model->clockActivity($this->uid);
        $this->error($list);
    }

    /**
     * 获取报名人员列表
     */
    public function getjoinactivitymembers() {
        $this->initsession();
        $this->load->model('activity_model');
        $list = $this->activity_model->getJoinActivityMembers($this->uid);
        if (is_array($list)) {
            $this->success(['data' => $list]);
        } else {
            $this->error(-1);
        }
        //$this->error($list);
    }

    /**
     * 活动打卡人员列表
     */
    public function getClockMembers() {
        $this->initsession();
        $this->load->model('activity_model');
        $list = $this->activity_model->getClockMembers($this->uid);
        if (is_array($list)) {
            $this->success(['data' => $list]);
        } else {
            $this->error(-1);
        }
        //$this->error($list);
    }

    /**
     * 对活动进行评论
     */
    public function commentactivity() {
        $this->initsession();
        $this->load->model('activity_model');
        $list = $this->activity_model->commentActivity($this->uid);
        $this->error($list);
    }

    /**
     * 删除对活动进行评论
     */
    public function deleteactivitycomment() {
        $this->initsession();
        $this->load->model('activity_model');
        $list = $this->activity_model->deleteActivityComment($this->uid);
        $this->error($list);
    }

    /**
     * 点赞活动评论
     */
    public function praisecomment() {
        $this->initsession();
        $this->load->model('activity_model');
        $apid = $this->activity_model->praiseComment($this->uid);
        if ($apid > 0) {
            $this->success(['apid' => $apid]);
        }
        $this->error($apid);
    }

    /**
     * 取消点赞活动评论
     */
    public function deletepraisecomment() {
        $this->initsession();
        $this->load->model('activity_model');
        $list = $this->activity_model->deletePraiseComment($this->uid);
        $this->error($list);
    }

    /**
     * 回复该活动下的评论
     */
    public function replycomment() {
        $this->initsession();
        $this->load->model('activity_model');
        $acrid = $this->activity_model->replyComment($this->uid);
        if ($acrid > 0) {
            $this->success(['acrid' => $acrid]);
        }
        $this->error($acrid);
    }

    /**
     * 删除评论下的回复
     */
    public function deleteactivitycommentreply() {
        $this->initsession();
        $this->load->model('activity_model');
        $acrid = $this->activity_model->deleteActivityCommentReply($this->uid);
        $this->error($acrid);
    }

    /**
     * 获取活动的评论列表
     */
    public function getcommentlist() {
        $this->initsession();
        $this->load->model('activity_model');
        $list = $this->activity_model->getCommentList($this->uid);
        if (is_array($list)) {
            $this->success(['data' => $list]);
        } else {
            $this->error(-1);
        }
        //$this->error($list);
    }

    /**
     * 获取活动评论的点赞列表
     */
    public function getcommentpraiselist() {
        $this->initsession();
        $this->load->model('activity_model');
        $list = $this->activity_model->getCommentPraiseList($this->uid);
        if (is_array($list)) {
            $this->success(['data' => $list]);
        } else {
            $this->error(-1);
        }
        //$this->error($list);
    }

    /**
     * 获取活动评论下的回复列表
     */
    public function getcommentreplycommentlist() {
        $this->initsession();
        $this->load->model('activity_model');
        $list = $this->activity_model->getCommentReplyCommentList($this->uid);
        if (is_array($list)) {
            $this->success(['data' => $list]);
        } else {
            $this->error(-1);
        }
        //$this->error($list);
    }

    /**
     * 点赞评论下的回复内容
     */
    public function praisereplycontent() {
        $this->initsession();
        $this->load->model('activity_model');
        $apid = $this->activity_model->praiseReplycontent($this->uid);
        if ($apid > 0) {
            $this->success(['acpid' => $apid]);
        }
        $this->error($apid);
    }

    /**
     * 取消回复点赞
     */
    public function deletepraisereplycontent() {
        $this->initsession();
        $this->load->model('activity_model');
        $list = $this->activity_model->deletePraiseReplycontent($this->uid);
        $this->error($list);
    }

    private function initsession() {
        $this->uid = $this->usersModel()->checkSession();
        empty($this->uid) && $this->error(0, '请提供登录session');
    }

    private function usersModel() {
        $this->load->model('users_model');
        return $this->users_model;
    }

    /**
     * 操作错误跳转的快捷方法
     * @access protected
     * @param string $message 错误信息
     */
    private function error($code = 0, $message = '') {
        $list['code'] = $code;
        if (!empty($message)) {
            $list['message'] = $message;
        }
        $this->showJson($list);
    }

    /**
     * 操作成功跳转的快捷方法
     * @access protected
     * @param string $list 提示信息
     */
    private function success($list, $code = 1) {
        $list['code'] = $code;
//        if (!empty($list['user'])) {
//            foreach ($list['user'] as $key => $value) {
//                if (is_null($value)) {
//                    $list['user'][$key] = '';
//                }
//            }
//        }
        $this->showJson($list);
    }

    /**
     * 直接输出json
     * @param mixed $value
     */
    private function showJson($value) {
//        print_r($value);
//        exit;
        header('Content-type:application/json;charset=utf-8');
        exit(json_encode($value, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 软件版本
     */
    public function version() {
        $this->load->model(['version_model']);
        $list = $this->version_model->get_version();
        !empty($list) ? $this->success(['data' => $list], 1000) : $this->error(-1);
    }

    /**
     * 游戏
     */
    public function game() {
        $this->load->model(['game_section_model']);
        $list = $this->game_section_model->get_game();
        !empty($list) ? $this->success(['data' => $list], 1000) : $this->error(-1);
    }

    /**
     * 申请审核
     */
    public function gameapply() {
        $this->initsession();
        $this->load->model(['users_gamerole_model']);
        $list = $this->users_gamerole_model->gameapply($this->uid);
        !empty($list) ? $this->success(1) : $this->error(-1);
    }

    /**
     * 认证会员申请
     */
    public function authVIP() {
        $this->initsession();
        $this->load->model('Users_model');
        $users = $this->Users_model->authVIP($this->uid);
        $this->error($users);
    }

    /**
     * 上传用户最近上线时间戳
     */
    public function updateLocalTimestamp() {
        $this->initsession();
        $this->load->model('Users_model');
        $users = $this->Users_model->updateLoginTime($this->uid);
        $this->error($users);
    }

    /**
     * 获取最近在线用户列表
     */
    public function getRecentlyUser() {
        $this->initsession();
        $this->load->model('Users_model');
        $users = $this->Users_model->getRecentlyUser();
        !empty($users) ? $this->success($users) : $this->error(0);
    }

}
