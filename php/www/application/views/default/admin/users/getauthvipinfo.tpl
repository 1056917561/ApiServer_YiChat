{extends file="mainlayout.tpl"}
{block name=javascript}
    <script type="text/javascript">
        layui.config({
            base: theme_url + 'plugins/layui/modules/'
        });
        layui.use(['jquery', 'form', 'icheck', 'laypage', 'layer', 'laydate', 'query'], function () {
            var $ = layui.jquery,
                    form = layui.form(),
                    laypage = layui.laypage,
                    layer = parent.layer === undefined ? layui.layer : parent.layer,
                    laydate = layui.laydate;



            $("[data-tab]").on('click', function () {
                var t = $(this);
                parent.tab.tabAdd({
                    title: t.data('title'),
                    icon: t.data('icon'),
                    href: t.attr('href')
                });
                return false;
            });

        {if empty( $list)}
            layer.msg('没有任何数据');
        {elseif $pages>1}
            laypage({
                cont: 'page',
                pages: {$pages},
                curr:{$page},
                groups: 5,
                jump: function (obj, first) {

                    var curr = obj.curr;
                    if (!first) {
                        self.location = $.query.set("page", obj.curr);
                    }
                }
            });
        {/if}


            $(".friends").on('click', function (event) {
                event.preventDefault();
                //$('.rowtable').hide();
                $('#' + $(this).data('userid')).fadeToggle();
            });




        });
    </script>
{/block}
{block name=body}
    <style>
        .layui-input-block {
            line-height: 36px;
        }
        .layui-form-label {
            width: 120px;
            font-weight: 500;
            font-size: 15px;
        }
    </style>
    <div class="admin-main">
        <fieldset class="layui-elem-field">
            <legend>身份审核</legend>
            <div class="layui-field-box">
                <form class="layui-form" action="" method="get">
                    <div class="layui-form-item">
                        <label class="layui-form-label">姓名：</label>
                        <div class="layui-input-block">{$list.username}</div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">性别：</label>
                        <div class="layui-input-block">{$list.sex}</div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">手机号：</label>
                        <div class="layui-input-block">{$list.userTel}</div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">身份证号：</label>
                        <div class="layui-input-block">{$list.cardId}</div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">身份属性：</label>
                        <div class="layui-input-block">{$list.roleName}</div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">所属区域：</label>
                        <div class="layui-input-block">{$list.areaName}</div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">所属省份：</label>
                        <div class="layui-input-block">{$list.province}</div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">所属城市：</label>
                        <div class="layui-input-block">{$list.city}</div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">所属小组：</label>
                        <div class="layui-input-block">{$list.groupName}</div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">母鸡：</label>
                        <div class="layui-input-block">{$list.fatherName}</div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">母鸡手机号：</label>
                        <div class="layui-input-block">{$list.fatherTel}</div>
                    </div>
                    {if !$list.status}
                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <a href="{site_url('users/getAuthvipInfo')}?action=audit&id={$list.id}" data-confirm="你确定要审核当前认证申请吗？" class="layui-btn"><i class="fa fa-check" aria-hidden="true"></i> 审核</a>
                                <a href="{site_url('users/authvip')}" class="layui-btn"><i class="fa fa-remove" aria-hidden="true"></i> 取消</a>
                            </div>
                        </div>
                    {else}
                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <a href="{site_url('users/authvip')}" class="layui-btn"><i class="fa fa-history" aria-hidden="true"></i> 返回</a>
                            </div>
                        </div>
                    {/if}
                </form>                
            </div>
        </fieldset>
    </div>
{/block}