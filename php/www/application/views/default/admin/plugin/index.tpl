{extends file="mainlayout.tpl"}
{block name=body}
    <div class="admin-main">
        <fieldset class="layui-elem-field">
            <legend>应用列表</legend>
            <div class="layui-field-box">
                <table class="site-table table-hover">
                    <thead>
                        <tr>
                            <!--<th>插件</th>-->
                            <th>应用</th>
                            <th>说明</th>
                            <th>作者</th>
                            <th>版本</th>
                            <th>作者主页</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach $plugin as $row}
                            <tr>
                                <!--<td>{$row.name}</td>-->
                                <td>{$row.desc}</td>
                                <td>{$row.example}</td>
                                <td>{$row.author}</td>
                                <td>{$row.version}</td>
                                <td>
                                    {if !empty($row.link)}
                                        <a href="{$row.link}" target="_blank">{$row.link}</a>
                                    {/if}
                                </td>

                                <td>
                                    {if !empty($row.plugin)}
                                        <a href="{site_url('plugin/delete/')}{$row.name}" data-confirm="你确定要卸载{$row.desc}吗？" data-id="1" data-opt="del" class="layui-btn layui-btn-danger layui-btn-mini">卸载</a>
                                        {if !empty($row.setting)}
                                            <a href="{site_url($row.name)}/setting" class="layui-btn layui-btn-normal layui-btn-mini">设置</a>
                                        {/if}
                                    {else}
                                        <a href="{site_url('plugin/install/')}{$row.name}" data-confirm="你确定要安装{$row.desc}吗？" class="layui-btn layui-btn-mini">安装</a>
                                    {/if}
                                </td>
                            </tr>
                        {/foreach}

                    </tbody>
                </table>

            </div>
        </fieldset>
    </div>
{/block}
