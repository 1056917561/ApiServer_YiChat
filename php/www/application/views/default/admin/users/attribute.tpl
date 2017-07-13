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
                $('#'+$(this).data('userid')).fadeToggle();
            });


           

        });
    </script>
{/block}
{block name=body}
    <div class="admin-main">
        <blockquote id='searchform' class="layui-elem-quote">


            <form class="layui-form" action="" method="post">
                <div>
                    <div class="layui-input-inline">
                        <input type="text" name="name" value="{$edit.name}" autocomplete="off" class="layui-input" placeholder="增加属性">
                    </div>
                    <div class="layui-inline">
                        <button class="layui-btn" lay-submit="" lay-filter="demo1"><i class="layui-icon">&#xe62a;</i> 提交</button>
                        {if $edit.name}
                            <a href="{site_url('users/attribute')}" class="layui-btn"><i class="fa fa-remove" aria-hidden="true"></i> 取消</a>
                        {/if}
                    </div>
                </div>
            </form>

        </blockquote>
        {if !empty( $list)}

            <div class="layui-field-box">
                <table class="site-table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>属性名称</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach $list as $row}
                            <tr>
                                <td>{$row.id}</td>
                                <td>{$row.name}</td>
                                <td align="center">
                                    <a href="?id={$row.id}" class="layui-btn layui-btn-mini "><i class="fa fa-edit" aria-hidden="true"></i> 编辑</a>
                                    {if (int)$row.id!==1}
                                    <a href="{site_url('users/deleteattribute/')}{$row.id}" data-confirm="你确定要删除吗？" class="layui-btn layui-btn-danger layui-btn-mini"><i class="fa fa-remove" aria-hidden="true"></i> 删除</a>
                                    {/if}
                                </td>
                            </tr>
                        {/foreach}
                    </tbody>
                </table>

            </div>


            {if $pages>1}
                <div class="admin-table-page">
                    <div id="page" class="page">
                    </div>
                </div>
            {/if}
        {/if}
    </div>
{/block}