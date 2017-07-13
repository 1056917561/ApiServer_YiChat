layui.use('jquery', function () {
    var $ = layui.jquery,
            parent = window.parent.frames;

    $('.editor').each(function () {
        KindEditor.create(this, {
            themeType: 'simple',
            urlType: 'absolute',
            allowFileManager: true,
            allowImageUpload: true,
            allowFileUpload: true,
            allowFlashUpload: false,
            allowMediaUpload: false,
            imageUploadLimit: 300,
            imageSizeLimit: '10MB',
            uploadJson: uploadJson,
            fileManagerJson: fileManagerJson,
            items: ['source', '|', 'undo', 'redo', '|', 'preview', 'print', 'template', 'code', 'cut', 'copy', 'paste', 'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright', 'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript', 'superscript', 'clearhtml', 'quickformat', 'selectall', '|', 'fullscreen', '/', 'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'image', 'multiimage', 'flash', 'media', 'insertfile', 'table', 'hr', 'emoticons', 'baidumap', 'pagebreak', 'anchor', 'link', 'unlink'],
            afterBlur: function () {
                this.sync();
            }
        });

    });
    var editor = KindEditor.editor({
        themeType: 'simple',
        urlType: 'absolute',
        allowFileManager: true,
        allowImageUpload: true,
        allowFileUpload: true,
        allowFlashUpload: false,
        allowMediaUpload: false,
        imageUploadLimit: 300,
        imageSizeLimit: '10MB',
        uploadJson: uploadJson,
        fileManagerJson: fileManagerJson
    });
    $('.imageDialog').each(function () {
        var input = $(this).data('input');
        var img = $(this).data('img');
        $(this).unbind('click');
        $(this).bind('click', function (event) {
            event.preventDefault();
            editor.loadPlugin('image', function () {
                editor.plugin.imageDialog({
                    imageUrl: $('#' + input).val(),
                    clickFn: function (url, title, width, height, border, align) {
                        if (input) {
                            $('#' + input).val(url);
                        }
                        if (img) {
                            $('#' + img).attr('src', url).hide().fadeIn();
                        }
                        editor.hideDialog();
                    }
                });
            });
        });
    });

});