{extends file="mainlayout.tpl"}
{block name=javascript}
    {js('js/element.js')}
    {js('js/form.js')}
{/block}
{block name=body}
    <div class="admin-main">


        <fieldset class="layui-elem-field">
            <legend>新增区服</legend>
            <div class="layui-field-box">
                <form class="layui-form" action="" method="post">
                    <input type="hidden" name="pid" value="{$pid}" />
                    <div class="layui-form-item">
                        <label class="layui-form-label">区服名称</label>
                        <div class="layui-input-inline">
                            <input type="text" name="name" value="" autocomplete="off" placeholder="区服名称" class="layui-input">
                        </div>
                    </div>
                    
                   

                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <div class='ui mini buttons'>
                                <button type="submit" lay-submit="" class="ui positive button"><i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;保存</button>
                                <div class='or'></div>
                                <a href="{site_url('game/services')}?pid={$pid}" class="ui button"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;取消</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </fieldset>
    </div>
{/block}