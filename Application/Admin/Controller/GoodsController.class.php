<?php
namespace Admin\Controller;
use Think\Controller;

class GoodsController extends Controller
{
	//处理Ajax删除图片请求
	public function ajaxDelPic()
	{
		$picId = I('get.picid');
		//查询相册图片路径
		$gpModel = D("goods_pic");
		$pic = $gpData = $gpModel->field('pic,sm_pic,mid_pic,big_pic')->find($picId);
		//从硬盘删除图片
		deleteImage($pic);
		//从数据库中删除记录
		$gpModel->delete($picId);
	}
	//商品添加
	public function add()
	{
		//var_dump($_FILES);die;
		if ($_POST) {
			set_time_limit(0);
			//接受商品数据并添加至数据表
			$model = D("goods");
			if ($model->create(I('post'),1)) {
				if ($model->add()) {
					$this->success("添加商品成功！",U('lst'));
					exit;
				}
			}
			$error = $model->getError();
			$this->error($error);
		}
		//取出所有品牌
		$brandModel = D("brand");
		$brandData = $brandModel->select();
		//取出所有会员级别
		$mlModel = D("member_level");
		$mlData = $mlModel->select();

		$this->assign(array(
				'mlData'		  => $mlData,
				'brandData'		  => $brandData,
				'_page_title'     => '添加新商品',
				'_page_btn_name'  => '商品列表',
				'_page_btn_link'  => U('lst'),
			));
		$this->display();
	}
	//商品修改
	public function edit()
	{
		$id = I('get.id');
		$model = D("goods");

		if ($_POST) {
			
			if ($model->create(I('post.'),2)) {
				
				if (false !== $model->save()) {
					$this->success("修改商品成功！",U('lst'));
					exit;
				}
			}
			$error = $model->getError();
			$this->error($error);
		}
		//根据ID取出要修改的商品信息
		$data = $model->find($id);
		//根据ID取出要修改会员价格信息
		$mpData = D("member_price")->where(array(
				'goods_id'	=> array('eq',$id),
			))->select();
		//将二维数组转成一维数组
		foreach ($mpData as $k => $v) {
			$_mpData[$v['level_id']] = $v['price'];
		}
		
		//取出所有品牌
		$brandModel = D("brand");
		$brandData = $brandModel->select();
		//取出所有会员级别
		$mlModel = D("member_level");
		$mlData = $mlModel->select();
		//查询所有相册图片
		$gpModel = D("goods_pic");
		$gpData = $gpModel->field('id,mid_pic')->where(array(
				'goods_id' => array('eq',$id),
			))->select();
		$this->assign("goodsInfo",$data);
		$this->assign(array(
				'mpData'		  => $_mpData,
				'mlData'		  => $mlData,
				'brandData'		  => $brandData,
				'gpData'		  => $gpData,
				'_page_title'     => '商品编辑',
				'_page_btn_name'  => '商品列表',
				'_page_btn_link'  => U('lst'),
			));
		$this->display();
	}
	//商品删除
	public function delete()
	{
		$id = I('get.id');
		$model = D("goods");
		if (false !== $model->delete($id)) {
			$this->success("商品删除成功！",U("lst"));
		}else{
			$this->error("商品删除失败！原因：".$model->getError());
		}
	}
	//商品列表页面
	public function lst()
	{
		$model = D("goods");
		//实现搜索和翻页
		$goodsInfo = $model->search();
		$this->assign("list",$goodsInfo['data']);
		$this->assign("showPage",$goodsInfo['page']);
		$this->assign(array(
				'_page_title'     => '商品列表',
				'_page_btn_name'  => '添加新商品',
				'_page_btn_link'	 => U('add'),
			));
		$this->display();
	}

}