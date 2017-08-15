<?php
namespace Admin\Model;
use Think\Model;
use Think\Upload;
use Think\Image;
use Think\Page;

class GoodsModel extends Model
{
	//添加调用create方法时允许接受的字段
	protected $insertFields = "goods_name,market_price,shop_price,is_on_sale,goods_desc,brand_id";
	//添加调用create方法时允许接受的字段
	protected $updateFields = "id,goods_name,market_price,shop_price,is_on_sale,goods_desc,brand_id";
	//定义验证规则
	protected $_validate = array(
			array('goods_name','require','商品名称不能为空！',1),
			array('market_price','currency','市场价格必须为货币类型！',1),
			array('shop_price','currency','本店价格必须为货币类型！',1)
		);
	//添加商品信息后调用
	protected function _after_insert($data,$option)
	{
		//处理相册图片
		if (isset($_FILES['pic'])) 
		{
			//转换成一维数组
			$pics = array();
			foreach ($_FILES['pic']['name'] as $k => $v) {
				$pics[] = array(
						'name' => $v,
						'type' => $_FILES['pic']['type'][$k],
						'tmp_name' => $_FILES['pic']['tmp_name'][$k],
						'error' => $_FILES['pic']['error'][$k],
						'size' => $_FILES['pic']['size'][$k],
					);
			}
			$_FILES = $pics;//给$_FILES赋值
			$gdModel = D('goods_pic');
			foreach ($pics as $k => $v) 
			{
				if ($v['error'] == 0) 
				{
					$ret = uploadOne($k,'Goods',array(
						array(650,650),
						array(350,350),
						array(50,50),
					));
					if ($ret['ok'] == 1) 
					{
						$gdModel->add(array(
								'pic' => $ret['images'][0],
								'big_pic' => $ret['images'][1],
								'mid_pic' => $ret['images'][2],
								'sm_pic' => $ret['images'][3],
								'goods_id' => $data['id']
							));
					}
				}
				
			}

		}
		//保存会员价格至数据库
		$mlData = I('post.member_price');
		$mpModel = D("member_price");
		foreach ($mlData as $k => $v) {
			$_v = (float)$v;
			if ($_v > 0) {
				$mpModel->add(array(
						'price'	=> $_v,
						'level_id'	=>	$k,
						'goods_id'	=>	$data['id'],
					));
			}
		}
	}
	//添加商品信息前调用
	protected function _before_insert(&$data,$option)
	{
		/**********处理LOGO图片***********/
		if ($_POST['logo']['error'] == 0) {
			$upload = new Upload();
			$upload->maxSize = 1024*1024;//最大上传文件1M
			$upload->exts = array('jpg','jpeg','png','gif');//允许上传类型
			$upload->rootPath = "./Public/Uploads/";//设置上传根目录
			$upload->savePath = 'Goods/';//设置上传子目录
			$info = $upload->upload();
			if (!$info) 
			{
				/***************返回上传失败原因**********************/
				$this->error = $upload->getError();
				return false;
			}
			else
			{
				/***********生成缩略图******************/
				//原图路径

				$logo = $info['logo']['savepath'].$info['logo']['savename'];
				//缩略图路径
				$smlogo = $info['logo']['savepath'].'sm_'.$info['logo']['savename'];
				$midlogo = $info['logo']['savepath'].'mid_'.$info['logo']['savename'];
				$biglogo = $info['logo']['savepath'].'big_'.$info['logo']['savename'];
				$mbiglogo = $info['logo']['savepath'].'mbig_'.$info['logo']['savename'];

				$image = new Image();
				//打开要生成缩略图的图片
				$image->open('./Public/Uploads/'.$logo);
				//生成缩略图
				$image->thumb(700,700)->save('./Public/Uploads/'.$mbiglogo);
				$image->thumb(350,350)->save('./Public/Uploads/'.$biglogo);
				$image->thumb(130,130)->save('./Public/Uploads/'.$midlogo);
				$image->thumb(50,50)->save('./Public/Uploads/'.$smlogo);
				/************把路径放入表中***************/
				$data['sm_logo'] = $smlogo;
				$data['logo'] = $logo;
				$data['mid_logo'] = $midlogo;
				$data['big_logo'] = $biglogo;
				$data['mbig_logo'] = $mbiglogo;
			}
		}
		//获取当前时间并添加到表单中
		$data['addtime'] = date('Y-m-d H:i:s',time());
		$data['goods_desc'] = removeXSS($_POST['goods_desc']);
	}
	//修改商品信息前调用
	protected function _before_update(&$data, $option)
	{
		$id = $option['where']['id'];  // 要修改的商品的ID
		
		
		/**************** 处理LOGO *******************/
		// 判断有没有选择图片
		if($_FILES['logo']['error'] == 0)
		{
			$ret = uploadOne('logo', 'Goods', array(
				array(700, 700),
				array(350, 350),
				array(130, 130),
				array(50, 50),
			));
			$data['logo'] = $ret['images'][0];
			$data['mbig_logo'] = $ret['images'][1];
			$data['big_logo'] = $ret['images'][2];
			$data['mid_logo'] = $ret['images'][3];
			$data['sm_logo'] = $ret['images'][4];
			/*************** 删除原来的图片 *******************/
		    	// 先查询出原来图片的路径
			$oldLogo = $this->field('logo,mbig_logo,big_logo,mid_logo,sm_logo')->find($id);
			deleteImage($oldLogo);
		}
		
		/************ 处理相册图片 *****************/
		if(isset($_FILES['pic']))
		{
			$pics = array();
			foreach ($_FILES['pic']['name'] as $k => $v)
			{
				$pics[] = array(
					'name' => $v,
					'type' => $_FILES['pic']['type'][$k],
					'tmp_name' => $_FILES['pic']['tmp_name'][$k],
					'error' => $_FILES['pic']['error'][$k],
					'size' => $_FILES['pic']['size'][$k],
				);
			}
			$_FILES = $pics;  // 把处理好的数组赋给$_FILES，因为uploadOne函数是到$_FILES中找图片
			$gpModel = D('goods_pic');
			// 循环每个上传
			foreach ($pics as $k => $v)
			{
				if($v['error'] == 0)
				{
					$ret = uploadOne($k, 'Goods', array(
						array(650, 650),
						array(350, 350),
						array(50, 50),
					));
					if($ret['ok'] == 1)
					{
						$gpModel->add(array(
							'pic' => $ret['images'][0],
							'big_pic' => $ret['images'][1],
							'mid_pic' => $ret['images'][2],
							'sm_pic' => $ret['images'][3],
							'goods_id' => $id,
						));
					}
				}
			}
		}
		
		/************ 处理会员价格 ****************/
		$mp = I('post.member_price');
		$mpModel = D('member_price');
		// 先删除原来的会员价格
		$mpModel->where(array(
			'goods_id' => array('eq', $id),
		))->delete();
		foreach ($mp as $k => $v)
		{
			$_v = (float)$v;
			// 如果设置了会员价格就插入到表中
			if($_v > 0)
			{
				$mpModel->add(array(
					'price' => $_v,
					'level_id' => $k,
					'goods_id' => $id,
				));
			}
		}
		
		// 我们自己来过滤这个字段
		$data['goods_desc'] = removeXSS($_POST['goods_desc']);
	}
	//删除商品时调用
	protected function _before_delete($option)
	{
		$id = $option['where']['id'];
		/*********删除相册中的图片**********/
		$gdModel = D("goods_pic");
		//查询数据表的存储路径
		$pics = $gdModel->field('pic,big_pic,mid_pic,sm_pic')->where(array(
				'goods_id' => array('eq',$id),
			))->select();
		//循环删除原相册图片文件
		foreach ($pics as $k => $v) {
			deleteImage($v);
		}
		//删除数据表的记录
		$gdModel->where(array(
				'goods_id' => array('eq',$id),
			))->delete();




		/*******删除原来的图片*********/
		//先查询原来的图片路径
		$oldLogo = $this->field("logo,sm_logo,mid_logo,big_logo,mbig_logo")->find($id);
		//从硬盘上删除
		deleteImage($oldLogo);
		/*************删除会员价格***************/
		$mpModel = D("member_price");
		$mpModel->where(array(
				'goods_id' =>array('eq',$id),
			))->delete();
	}


	public function search($perPage = 3)
	{	
		/**********搜索功能***************/
		$where = array();//空的where条件
		//商品名称
		$gn = I('get.gn');
		if ($gn) 
		{
			$where['a.goods_name'] = array('like',"%{$gn}%");
		}
		//商品的价格
		$fp = I('get.fp');
		$tp = I('get.tp');
		if ($fp && $tp) {
			$where['a.shop_price'] = array('between',array($fp,$tp));
		}elseif ($fp) {
			$where['a.shop_price'] = array('egt',$fp); // >=$fp
		}elseif ($tp) {
			$where['a.shop_price'] = array('elt',$tp); // <=$tp
		}
		//是否上架
		$ios = I('get.ios');
		if ($ios) {
			$where['a.is_on_sale'] = array('eq',$ios);
		}
		//添加时间
		$fa = I('get.fa');
		$ta = I('get.ta');
		if ($fa && $ta) {
			$where['a.addtime'] = array('between',array($fa,$ta));
		}elseif ($fa) {
			$where['a.addtime'] = array('egt',$fa); // >=$fa
		}elseif ($ta) {
			$where['a.addtime'] = array('elt',$ta); // <=$ta
		}
		//所属品牌
		$brand_id = I('get.brand_id');
		if ($brand_id) {
			$where['a.brand_id'] = array('eq',$brand_id);
		}


		/**********翻页************/
		//取出总的记录数
		$count = $this->where($where)->count();

		//生成翻页类的对象
		$page = new Page($count,$perPage);
		//生成页面显示的上一页、下一页字符串
		$page->setconfig('next','下一页');
		$page->setconfig('prev','上一页');
		$pageString = $page->show();
		/**************排序*******************/
		$orderby = 'a.id'; //默认排序字段
		$orderway = 'desc'; //默认排序方式
		$odby = I('get.odby');
		if ($odby) 
		{
			if ($odby == 'id_asc') 
			{
				$orderway = 'asc';
			}
			elseif ($odby == 'price_desc') 
			{
				$orderby = 'shop_price';
			}
			elseif ($odby == 'price_asc') 
			{
				$orderby = 'shop_price';
				$orderway = 'asc';
			}
		}
		

		/*********获得某一页数据***********/

		$data = $this->order("$orderby $orderway")
		->field('a.*,b.brand_name')
		->alias('a')
		->join('LEFT JOIN shop_brand b on a.brand_id=b.id')
		->where($where)
		->limit($page->firstRow,$page->listRows)
		->select();
		
		
		/***********返回数据****************/
		return array(
				'data' => $data,
				'page' => $pageString
			);
	}
}