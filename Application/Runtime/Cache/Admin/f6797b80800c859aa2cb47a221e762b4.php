<?php if (!defined('THINK_PATH')) exit();?>

<!-- 网站头部 -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>管理中心 - <?php echo ($_page_title); ?> </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/www.myshop.com/Public/Admin/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/www.myshop.com/Public/Admin/Styles/main.css" rel="stylesheet" type="text/css" />
<style>
	form,ul,li{margin:0;padding:0;}
	ul{line-height:25px;list-style-type:none;}
</style>
</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo ($_page_btn_link); ?>"><?php echo ($_page_btn_name); ?></a>
    </span>
    <span class="action-span1"><a href="__GROUP__">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - <?php echo ($_page_title); ?> </span>
    <div style="clear:both"></div>
</h1>

<!-- 网站内容 -->

<style>
    #page-table a{padding: 5px;border: 1px solid #F00;margin: 5px}
    #page-table span.current{padding: 5px;background: #F00;margin: 5px;color:#FFF;font-weight: bold;}
</style>
        <!-- 搜索 -->
<div class="form-div">
    <form action="/www.myshop.com/index.php/Admin/Goods/lst" name="searchForm">
        <img src="/www.myshop.com/Public/Admin/Images/icon_search.gif" width="26" height="22" border="0" alt="search" />
        <p>
            品　　牌：
            <?php buildSelect('brand','brand_id','id','brand_name',I('get.brand_id')) ?>
        </p>
        <p>
            商品名称：
            <input value="<?php echo I('get.gn'); ?>" type="text" name="gn" size="60" />
        </p>
        <p>
            价　　格：
            从<input value="<?php echo I('get.fp'); ?>" type="text" name="fp" size="8" />
            到<input value="<?php echo I('get.tp'); ?>" type="text" name="tp" size="8" />
        </p>
        <p>
            是否上架：
            <?php $ios = I('get.ios'); ?>
            <input type="radio" name="ios" value="" <?php if($ios == '') echo 'checked="checked"'; ?> />全部
            <input type="radio" name="ios" value="是" <?php if($ios == '是') echo 'checked="checked"'; ?> />上架
            <input type="radio" name="ios" value="否" <?php if($ios == '否') echo 'checked="checked"'; ?> />下架
        </p>
        <p>
            添加时间：
            从<input type="text" name="fa" id="fa" value="<?php echo I('get.fa'); ?>" size="20" />
            到<input type="text" name="ta" id="ta" value="<?php echo I('get.ta'); ?>" size="20" />
        </p>
        <p>
            排序方式：
            <?php $odby = I('get.odby','id_desc'); ?>
            <input onclick="this.parentNode.parentNode.submit()" type="radio" name="odby" value="id_desc" <?php if($odby == 'id_desc') echo 'checked="checked"'; ?> /> 以添加时间降序
            <input onclick="this.parentNode.parentNode.submit()" type="radio" name="odby" value="id_asc" <?php if($odby == 'id_asc') echo 'checked="checked"'; ?> /> 以添加时间升序
            <input onclick="this.parentNode.parentNode.submit()" type="radio" name="odby" value="price_desc" <?php if($odby == 'price_desc') echo 'checked="checked"'; ?> /> 以价格降序
            <input onclick="this.parentNode.parentNode.submit()" type="radio" name="odby" value="price_asc" <?php if($odby == 'price_asc') echo 'checked="checked"'; ?> /> 以价格升序
        </p>
        <p>
            <input type="submit" value="搜索" />
        </p>
        
    </form>
</div>

<!-- 商品列表 -->
<form method="post" action="" name="listForm" onsubmit="">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr>
                <th>编号</th>
                <th>品牌</th>
                <th>商品名称</th>
                <th>商品图片</th>
                <th>市场价格</th>
                <th>本店价格</th>
                <th>是否上架</th>
                <th>添加时间</th>
                <th>操作</th>
            </tr>
            <?php if(is_array($list)): foreach($list as $key=>$val): ?><tr class="tron">
                <td align="center"><<?php echo ($val["id"]); ?>></td>
                <td align="center"><?php echo ($val["brand_name"]); ?></td>
                <td align="center" width="200">
                    <span onclick=""><<?php echo ($val["goods_name"]); ?>></span>
                </td>
                <td align="center">
                    <img src="/www.myshop.com/Public/Uploads/<?php echo ($val["sm_logo"]); ?>" alt="" />
                </td>
                <td align="center">
                    <span onclick=""><<?php echo ($val["market_price"]); ?>></span>
                </td>
                <td align="center">
                    <span onclick=""><<?php echo ($val["shop_price"]); ?>></span>
                </td>
                <td align="center">
                    <span onclick=""><<?php echo ($val["is_on_sale"]); ?>></span>
                </td>
                <td align="center">
                    <span onclick=""><<?php echo ($val["addtime"]); ?>></span>
                </td> 
                <td align="center">
                    <a href="/www.myshop.com/index.php/Admin/Goods/edit/id/<?php echo ($val["id"]); ?>.html">修改</a>
                    <a onclick="return confirm('确定删除吗？')" href="/www.myshop.com/index.php/Admin/Goods/delete/id/<?php echo ($val["id"]); ?>.html">删除</a>
                </td>  
            </tr><?php endforeach; endif; ?>
        </table>

    <!-- 分页开始 -->
        <table id="page-table" cellspacing="0">
            <tr>
                <td width="80%">&nbsp;</td>
                <td align="center" nowrap="true">
                    <?php echo ($showPage); ?>
                </td>
            </tr>
        </table>
    <!-- 分页结束 -->
    </div>
</form>



<!-- 引入JQ -->
<script type="text/javascript" src="/www.myshop.com/Public/umeditor1_2_2-utf8-php/third-party/jquery.min.js"></script>

<!-- 时间插件 -->
<link href="/www.myshop.com/Public/datetimepicker/jquery-ui-1.9.2.custom.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" charset="utf-8" src="/www.myshop.com/Public/datetimepicker/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/www.myshop.com/Public/datetimepicker/datepicker-zh_cn.js"></script>
<link rel="stylesheet" media="all" type="text/css" href="/www.myshop.com/Public/datetimepicker/time/jquery-ui-timepicker-addon.min.css" />
<script type="text/javascript" src="/www.myshop.com/Public/datetimepicker/time/jquery-ui-timepicker-addon.min.js"></script>
<script type="text/javascript" src="/www.myshop.com/Public/datetimepicker/time/i18n/jquery-ui-timepicker-addon-i18n.min.js"></script>
<script>
    $.timepicker.setDefaults($.timepicker.regional['zh-CN']);//设置中文
    $("#fa").datetimepicker();  //调用
    $("#ta").datetimepicker();
</script>

<!-- 引入高亮显示 -->
<script type="text/javascript" src="/www.myshop.com/Public/Admin/Js/tron.js"></script>



<!-- 网站脚部 -->

<div id="footer">
共执行 9 个查询，用时 0.025161 秒，Gzip 已禁用，内存占用 3.258 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>