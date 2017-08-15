<?php
namespace Admin\Model;
use Think\Model;
class CategoryModel extends Model 
{
	protected $insertFields = array('cat_name','parent_id');
	protected $updateFields = array('id','cat_name','parent_id');
	protected $_validate = array(
		array('cat_name', 'require', '分类名称不能为空', 1, 'regex', 3),
	);

	//找一个分类所有子分类的ID
	public function getChildren($catId)
	{
		//获得所有分类
		$data = $this->select();
		//递归从所有分类中获得子分类的ID
		return $this->_getChildren($data,$catId,true);
	}
	/*递归从数据中找出子类*/
	private function _getChildren($data,$catId,$isClear=false)
	{
		static $ret = array(); //保存子分类的Id
		if ($isClear) 
		{
			$ret = array();
		}
		foreach ($data as $k => $v) 
		{
			if ($v['parent_id'] == $catId) 
			{
				$ret[] = $v['id'];
				$this->_getChildren($data,$v['id']);
			}
		}
		return $ret;
	}

	/*重新排序打印树状结构*/
	public function getTree()
	{
		$data = $this->select();
		return $this->_getTree($data);
	}
	private function _getTree($data,$parent_id=0,$level=0)
	{
		static $ret = array();
		foreach ($data as $k => $v) {
			if ($v['parent_id'] == $parent_id) {
				$v['level'] = $level;//记录第几级分类
				$ret[] = $v;
				$this->_getTree($data,$v['id'],$level+1);
			}
		}
		return $ret;
	}
	//删除商品分类前调用
	protected function _before_delete($option)
	{
		//找出所有子分类的ID
		$children = $this->getChildren($option['where']['id']);
		if ($children)
		{
			$children = implode(',', $children);//('1','2','3',...)
			//生成新的模型防止重复调用本钩子函数造成死循环
			$model = new Model(); 
			$model->table("__CATEGORY__")->delete($children);
		}
	}
}