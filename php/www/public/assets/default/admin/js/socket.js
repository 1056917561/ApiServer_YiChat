//layui.define(['jquery'], function (exports) {
//    var $ = jQuery = layui.jquery;
//
//
//    $(document).ready(function () {
//        // 连接服务端
//        var socket = io('http://' + document.domain + ':2120');
//        // 连接后登录
//        socket.on('connect', function () {
//            socket.emit('login', uid);
//        });
//        // 后端推送来消息时
//        socket.on('new_msg', function (msg) {
//            $('#content').html('收到消息：' + msg);
//            $('.notification.sticky').notify();
//        });
//        // 后端推送来在线数据时
//        socket.on('update_online_count', function (online_stat) {
//            $('#online_box').html(online_stat);
//        });
//    });
//
//
//    exports('socket', null);
//});