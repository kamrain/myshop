<?php if (!defined('THINK_PATH')) exit();?>

<!-- 网站头部 -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>管理中心 - <?php echo ($_page_title); ?> </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/www.myshop.com/Public/Admin/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/www.myshop.com/Public/Admin/Styles/main.css" rel="stylesheet" type="text/css" />

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


<div class="main-div">
    <form name="main_form" method="POST" action="/www.myshop.com/index.php/Admin/MemberLevel/edit/id/3.html" enctype="multipart/form-data" >
    	<input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
        <table cellspacing="1" cellpadding="3" width="100%">
            <tr>
                <td class="label">级别名称：</td>
                <td>
                    <input  type="text" name="level_name" value="<?php echo $data['level_name']; ?>" />
                </td>
            </tr>
            <tr>
                <td class="label">积分下限：</td>
                <td>
                    <input  type="text" name="jifen_bottom" value="<?php echo $data['jifen_bottom']; ?>" />
                </td>
            </tr>
            <tr>
                <td class="label">积分上限：</td>
                <td>
                    <input  type="text" name="jifen_top" value="<?php echo $data['jifen_top']; ?>" />
                </td>
            </tr>
            <tr>
                <td colspan="99" align="center">
                    <input type="submit" class="button" value=" 确定 " />
                    <input type="reset" class="button" value=" 重置 " />
                </td>
            </tr>
        </table>
    </form>
</div>


<script>
</script>


<!-- 网站脚部 -->

<div id="footer">
共执行 9 个查询，用时 0.025161 秒，Gzip 已禁用，内存占用 3.258 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>