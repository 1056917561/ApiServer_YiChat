{extends file="mainlayout.tpl"}
{block name=javascript}
    {js('js/element.js')}
    {js('js/form.js')}
{/block}
{block name=body}
    <div class="admin-main">


        <fieldset class="layui-elem-field">
            <legend>更新软件</legend>
            <div class="layui-field-box">
                <form class="layui-form" action="" method="post">
                    <div class="layui-form-item">
                        <label class="layui-form-label">系统平台</label>
                        <div class="layui-input-inline">
                            <select name="system">
                                <option value="">请选择平台</option>
                                <optgroup label="移动平台">
                                    <option value="1"{if (int)$list.system===1} selected="selected"{/if}>Android</option>
                                    <option value="2"{if (int)$list.system===2} selected="selected"{/if}>iOS</option>
                                </optgroup>
                                
                            </select>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">软件名称</label>
                        <div class="layui-input-inline">
                            <input type="text" name="name" value="{$list.name}" autocomplete="off" placeholder="软件名称" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">版本</label>
                        <div class="layui-input-inline">
                            <input type="text" name="version" value="{$list.version}" autocomplete="off" placeholder="版本" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">连接</label>
                        <div class="layui-input-inline">
                            <input type="text" name="url" value="{$list.url}" autocomplete="off" placeholder="连接" class="layui-input">
                        </div>
                    </div>
                   

                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <div class='ui mini buttons'>
                                <button type="submit" lay-submit="" class="ui positive button"><i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;保存</button>
                                <div class='or'></div>
                                <a href="{site_url('game/version')}" class="ui button"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;取消</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </fieldset>
    </div>
{/block}