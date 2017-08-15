<?php
namespace Admin\Controller;
use Think\Controller;
class CategoryController extends Controller 
{
    /*分类列表*/
    public function lst()
    {
        $model = D("category");
        $data = $model->getTree();
        $this->assign(array(
                'data'            => $data,
                '_page_title'     => '商品分类列表',
                '_page_btn_name'  => '添加商品分类',
                '_page_btn_link'     => U('add'),
            ));
        $this->display();
    }
    /*删除功能*/
    public function delete()
    {
        $model = D("category");
        if (false != $model->delete(I('get.id'))) 
        {
            $this->success('删除成功!',U('lst'));
        }
        else
        {
            $this->error($model->getError());
        }
    }
    /*添加功能*/
    public function add()
    {
        $model = D("category");
        if ($_POST) 
        {
            if ($model->create(I('post.'),1)) 
            {
                if ($model->add()) 
                {
                    $this->success('添加商品分类成功！',U('lst?p='.I('get.p')));
                }
                else
                {
                    $this->error($model->getError());
                }
            }
        }
        
        $data = $model->getTree();
        $this->assign(array(
                'data'  => $data,
                '_page_title'     => '添加分类',
                '_page_btn_name'  => '分类列表',
                '_page_btn_link'     => U('lst'),
            ));
        $this->display();
    }
    /*修改功能*/
    public function edit()
    {
        $id = I('get.id');
        $model = D("category");
        if ($_POST) 
        {
            
            if ($model->create(I('post.'),2)) {
                
                if (false !== $model->save()) {
                    $this->success("修改分类成功！",U('lst'));
                    exit;
                }
            }
            $error = $model->getError();
            $this->error($error);
        }
        //查找当前需要修改的分类
        $data = $model->find($id);
        //查找所有分类
        $catData = $model->getTree();
        //查找需要修改的所有子分类
        $children = $model->getChildren($id);
        var_dump($data);
        $this->assign(array(
                'data'     => $data,
                'children' => $children,
                'catData'  => $catData,
                '_page_title'     => '修改分类',
                '_page_btn_name'  => '分类列表',
                '_page_btn_link'     => U('lst'),
            ));
        $this->display();
    }
}