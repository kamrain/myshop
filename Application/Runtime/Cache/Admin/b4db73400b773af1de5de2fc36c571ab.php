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

<div class="main-div">
    <form action="/www.myshop.com/index.php/Admin/Category/edit/id/1.html" method="post" name="theForm">
        <table width="100%" id="general-table">
            <tr>
                <td class="label">分类名称:</td>
                <td>
                    <input type='text' name='cat_name' maxlength="20" value="<?php echo $data['cat_name']; ?>" size='27' /> <font color="red">*</font>
                </td>
            </tr>
            <tr>
                <td class="label">上级分类:</td>
                <td>
                    <select name="parent_id">
                        <option value="0">顶级分类</option>
                        <?php foreach ($catData as $k => $v) { if ($v['id'] == $data['id'] || in_array($v['id'], $children) ) continue; if ($v['id'] == $data['parent_id']) { $select = 'selected="selected"'; } else { $select = ''; } ?>
                        <option <?php echo $select; ?>  value="<?php echo $v['id']; ?>" ><?php echo str_repeat('-', $v['level']*8).$v['cat_name'] ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
        </table>
        <div class="button-div">
            <input type="submit" value=" 确定 " />
            <input type="reset" value=" 重置 " />
        </div>
    </form>
</div>




<!-- 网站脚部 -->

<div id="footer">
共执行 9 个查询，用时 0.025161 秒，Gzip 已禁用，内存占用 3.258 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>