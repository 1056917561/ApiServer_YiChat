layui.use('jquery', function () {
    var $ = layui.jquery,
            parent = window.parent.frames;

    $('.ckfinder').each(function () {
        CKFinder.widget($(this).attr('id'), {
            width: '100%',
            height: $(document).height() - 45,
            skin: 'jquery-mobile'
        });
    });
    
});