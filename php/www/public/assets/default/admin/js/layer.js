layui.use('layer', function () {
    var $ = layui.jquery,
            parent = window.parent.frames,
            layer = layui.layer;
    parent.layer.load();
    $(function () {
        parent.layer.closeAll('loading');
    });

    $("[data-confirm]").on('click', function (event) {
        event.preventDefault();
        var t = $(this);
        parent.layer.confirm(t.data('confirm'), {
            btn: ['确定', '取消'] //按钮
        }, function () {
            parent.layer.load();
            $.post(t.attr('href'),
                    function (data) {
                        parent.layer.closeAll('loading');
                        if (data.status === 1) {
                            parent.layer.msg(data.info, {icon: 1});
                        } else {
                            parent.layer.msg(data.info, {icon: 2});
                        }
                        if (data.url !== '') {
                            url = data.url;
                            setTimeout("self.location=url", 1000);
                        } else {
                            setTimeout("location.reload() ", 1000);
                        }
                    }, "json").error(function () {
                parent.layer.closeAll('loading');
                parent.layer.msg('服务器出错', {icon: 2});
            });
        }, function () {
        });
    });

    $("form[method='post']").on('submit', function (event) {
        event.preventDefault();
        var t = $(this);
        parent.layer.load();
        $.post(t.attr('action'), t.serializeArray(),
                function (data) {
                    parent.layer.closeAll('loading');
                    if (data.status === 1) {
                        parent.layer.msg(data.info, {icon: 1});
                    } else {
                        parent.layer.msg(data.info, {icon: 2});
                    }
                    if (data.url !== '') {
                        url = data.url;
                        setTimeout("self.location=url", 1000);
                    }
                }, "json").error(function () {
            parent.layer.closeAll('loading');
            parent.layer.msg('服务器出错', {icon: 2});
        });
    });



//    var index = layer.load(0, {shade: false});
//    
//    layer.close(index);
});