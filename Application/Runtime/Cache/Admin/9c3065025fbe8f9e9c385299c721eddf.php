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


<div class="tab-div">
    <div id="tabbar-div">
        <p>
            <span class="tab-front">通用信息</span>
            <span class="tab-back">商品描述</span>
            <span class="tab-back">会员价格</span>
            <span class="tab-back">商品属性</span>
            <span class="tab-back">商品相册</span>
        </p>
    </div>
    <div id="tabbody-div">
        <form enctype="multipart/form-data" action="/www.myshop.com/index.php/Admin/Goods/add.html" method="post">
            <!-- 基本信息表 -->
            <table width="90%" class="tab_table" id="general-table" align="center">
                <tr>
                    <td class="label">所在品牌：</td>
                    <td>
                        <?php buildSelect('brand','brand_id','id','brand_name') ?>
                    </td>
                </tr>
                <tr>
                    <td class="label">商品名称：</td>
                    <td><input type="text" name="goods_name" value=""size="30" />
                    <span class="require-field">*</span></td>
                </tr>
                <tr>
                    <td class="label">LOGO：</td>
                    <td><input type="file" name="logo" value="" size="60" />
                </tr>
                
                <tr>
                    <td class="label">本店售价：</td>
                    <td>
                        <input type="text" name="shop_price" value="0" size="20"/>
                        <span class="require-field">*</span>
                    </td>
                </tr>
                
                <tr>
                    <td class="label">市场售价：</td>
                    <td>
                        <input type="text" name="market_price" value="0" size="20" />
                    </td>
                </tr>
                
                <tr>
                    <td class="label">是否上架：</td>
                    <td>
                        <input type="radio" name="is_onsale" value="1"/> 是
                        <input type="radio" name="is_onsale" value="0"/> 否
                    </td>
                </tr>
                
            </table>
            <!-- 商品描述 -->
            <table style="display:none" width="90%" class="tab_table" align="center" >
                <tr>
                    <td>
                        <textarea id="goods_desc" name="goods_desc"></textarea>
                    </td>
                </tr>
            </table>
            <!-- 会员价格 -->
            <table style="display:none" width="90%" class="tab_table" align="center" >
                <tr>
                    <td class="label">会员价格：</td>  
                    <td>
                        <?php if(is_array($mlData)): $i = 0; $__LIST__ = $mlData;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i; echo ($v["level_name"]); ?>：￥<input type="text" name="member_price[<?php echo ($v["id"]); ?>]" value="" size="10" />元<br><?php endforeach; endif; else: echo "" ;endif; ?>
                    </td>  
                </tr>
            </table>
            <!-- 商品属性 -->
            <table style="display:none" width="90%" class="tab_table" align="center" >
                
            </table>
            <!-- 商品相册 -->
            <table style="display:none" width="90%" class="tab_table" align="center" >
            <tr>
                <td>
                    <input id="btn-add-pic" type="button" value="添加一张"> 
                    <hr>
                    <ul id="ul-pic-list"></ul>
                </td>
            </tr>
            </table>

            <div class="button-div">
                <input type="submit" value=" 确定 " class="button"/>
                <input type="reset" value=" 重置 " class="button" />
            </div>
        </form>
    </div>
</div>



<!-- 导入在线编辑器 -->
<link href="/www.myshop.com/Public/umeditor1_2_2-utf8-php/themes/default/css/umeditor.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/www.myshop.com/Public/umeditor1_2_2-utf8-php/third-party/jquery.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/www.myshop.com/Public/umeditor1_2_2-utf8-php/umeditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/www.myshop.com/Public/umeditor1_2_2-utf8-php/umeditor.min.js"></script>
<script type="text/javascript" src="/www.myshop.com/Public/umeditor1_2_2-utf8-php/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript">
    UM.getEditor('goods_desc', {
        initialFrameWidth:"100%",
        initialFrameHeight:350
    });
</script>

<script>
     /*功能键切换*/
    $('#tabbar-div p span').click(function(){
        var i = $(this).index();
        $('#tabbody-div .tab_table').hide();
        $('#tabbody-div .tab_table').eq(i).show();
        $('#tabbar-div p span').removeClass('tab-front').addClass('tab-back');
        $(this).addClass('tab-front').removeClass('tab-back');
    });
   /* 添加一张商品图片*/
   $('#btn-add-pic').click(function(){
       var file = '<li><input type="file" name="pic[]"></li>';
       $('#ul-pic-list').append(file);
   })
</script>


<!-- 网站脚部 -->

<div id="footer">
共执行 9 个查询，用时 0.025161 秒，Gzip 已禁用，内存占用 3.258 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>