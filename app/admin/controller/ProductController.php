<?php


namespace app\admin\controller;


use core\Mortal;

/**
 * 产品后台管理
 * Class ProductController
 * @package app\admin\controller
 */
class ProductController extends Mortal
{
    /*产品列表*/
    public function index(){
        //获取列表数据
        $nickname = I('nickname');
        $parentId = I('pid');
        $sonId = I('id');
        $lvid = I('lvid');
        $map = array();
        if (!empty($nickname)) {
            $map['product_name'] = array('like','%'.$nickname.'%');
        }
        if ($parentId != 0) {
            $map['category_pid'] = $parentId;
            $fson = D('ShopCategory')->getParent($parentId,'id,name');
            $this->assign('_fson',$fson);
        }
        if ($sonId != 0) {
            $map['category_id'] = $sonId;
        }
        if ($lvid != 0) {
            $map['level_id'] = $lvid;
        }

        $ShopProductInfo = D('ShopProductInfo');
        $page = new \Think\Page($ShopProductInfo->countNum($map),10);

        $list = $ShopProductInfo->lists($map,$page->firstRow,$page->listRows);

        //搜索条件获取一级分类信息
        $arr = D('ShopCategory')->getParent(0,'id,name');

        //搜索条件获取所有品质
        $levelArr = M('ShopProductLevel')->select();

        $this->assign('fpid',$parentId);
        $this->assign('fid',$sonId);
        $this->assign('flvid',$lvid);
        $this->assign('_arr',$arr);
        $this->assign('_levelArr',$levelArr);
        $this->assign('_page',$page->show());
        $this->assign('_list',$list);
        $this->meta_title = '产品';
        $this->display();
    }

    /**
     * [getCategroy 根据id获取分类]
     * @Author   Augus
     * @DateTime 2017-07-10T11:19:18+0800
     * @return   [type]                   [description]
     */
    public function getCategroy(){
        $cate_id = I('parent_id');
        if ($cate_id != 0) {
            $result = D('ShopCategory')->getParent($cate_id,'id,name');
        }else{
            $result = null;
        }
        echo json_encode($result);
    }

    /**
     * [addProduct 新增产品]
     * @Author   Augus
     * @DateTime 2017-07-06T16:29:05+0800
     */
    public function addProduct(){
        //分类选择
        $arr = D('ShopCategory')->getParent(0,'id,name');
        //品质选择
        $levelArr = M('ShopProductLevel')->select();
        //计价单位
        $unitArr = M('ShopProductUnit')->select();
        //供应商
        $suppArr = D('SystemSupplier')->alists();

        $this->assign('_arr',$arr);
        $this->assign('_levelArr',$levelArr);
        $this->assign('_unitArr',$unitArr);
        $this->assign('_suppArr',$suppArr);
        $this->meta_title = '新增产品';
        $this->display();
    }
    /**
     * [addProductAction 新增产品处理]
     * @Author   Augus
     * @DateTime 2017-07-10T16:07:01+0800
     */
    public function addProductAction(){
        $data['product_name'] = I('post.name');
        $data['description'] = I('post.description');
        $data['purchasing_price'] = I('post.purchasing_price');
        $data['promotion_price'] = I('post.promotion_price');
        $data['price'] = I('post.price');
        $data['origin'] = I('post.origin');
        $data['unit_id'] = I('post.unit');
        $data['minimum_purchases'] = I('post.minimum_purchases');
        $data['level_id'] = I('post.level');
        $data['storage_conditions'] = I('post.storage_conditions');
        $data['category_pid'] = I('post.parent');
        $data['category_id'] = I('post.son');
        $data['supplier_id'] = I('post.supplier');
        $data['update_time'] = date("Y-m-d H:i:s");
        $data['in_time'] = date("Y-m-d H:i:s");
        $data['img'] = I('post.icon');
        if (I('post.id')) {
            $map['id'] = I('post.id');
            if (!D('ShopProductInfo')->edit($data,$map)) {
                $this->error('产品编辑失败!');
            }else{
                $this->success('产品编辑成功！',U('index'));
            }
        }else{
            if (!D('ShopProductInfo')->adds($data)) {
                $this->error('产品新增失败!');
            }else{
                $this->success('产品新增成功！',U('index'));
            }
        }
    }

    /**
     * [editProduct 编辑产品]
     * @Author   Augus
     * @DateTime 2017-07-10T16:40:11+0800
     * @return   [type]                   [description]
     */
    public function editProduct(){
        $id = I('get.id');
        $info = D('ShopProductInfo')->getProductInfo($id);
        if (!$info) {
            $this->error('获取编辑数据失败!');
        }else{
            //分类选择
            $arr = D('ShopCategory')->getParent(0,'id,name');
            //品质选择
            $levelArr = M('ShopProductLevel')->select();
            //计价单位
            $unitArr = M('ShopProductUnit')->select();
            //供应商
            $suppArr = D('SystemSupplier')->alists();

            $this->assign('info',$info);
            $this->assign('_arr',$arr);
            $this->assign('_levelArr',$levelArr);
            $this->assign('_unitArr',$unitArr);
            $this->assign('_suppArr',$suppArr);
            $this->meta_title = '编辑产品';
            $this->display('addProduct');
        }
    }

    /**
     * [operation 产品操作]
     * @Author   Augus
     * @DateTime 2017-07-07T15:47:38+0800
     * @return   [type]                   [description]
     */
    public function operation($action,$val,$id){
        $map['id'] = $id;//条件
        switch (strtolower($action)) {
            case 'putaway'://产品上下架
                $data['putaway'] = $val;
                switch ($val) {
                    case 0:
                        $msg = array( 'success'=>'下架成功！', 'error'=>'下架失败！');
                        break;

                    case 1:
                        $msg = array( 'success'=>'上架成功！', 'error'=>'上架失败！');
                        break;

                    default:
                        $this->error('非法参数');
                        break;
                }

                $this->editRow('ShopProductInfo',$data,$map,$msg);
                break;

            case 'tegong'://产品特供
                $data['tegong'] = $val;
                switch ($val) {
                    case 0:
                        $msg = array( 'success'=>'取消特供成功！', 'error'=>'取消特供失败！');
                        break;

                    case 1:
                        $msg = array( 'success'=>'添加特供成功！', 'error'=>'添加特供失败！');
                        break;

                    default:
                        $this->error('非法参数');
                        break;
                }
                $this->editRow('ShopProductInfo',$data,$map,$msg);
                break;
            case 'cuxiao'://产品促销
                $data['cuxiao'] = $val;
                switch ($val) {
                    case 0:
                        $msg = array( 'success'=>'取消促销成功！', 'error'=>'取消促销失败！');
                        break;

                    case 1:
                        $msg = array( 'success'=>'添加促销成功！', 'error'=>'添加促销失败！');
                        break;

                    default:
                        $this->error('非法参数');
                        break;
                }
                $this->editRow('ShopProductInfo',$data,$map,$msg);
                break;

            case 'tuijian'://产品推荐
                $data['tuijian'] = $val;
                switch ($val) {
                    case 0:
                        $msg = array( 'success'=>'取消推荐成功！', 'error'=>'取消推荐失败！');
                        break;

                    case 1:
                        $msg = array( 'success'=>'添加推荐成功！', 'error'=>'添加推荐失败！');
                        break;

                    default:
                        $this->error('非法参数');
                        break;
                }
                $this->editRow('ShopProductInfo',$data,$map,$msg);
                break;

            case 'new_product'://新品
                $data['new_product'] = $val;
                switch ($val) {
                    case 0:
                        $msg = array( 'success'=>'取消新品成功！', 'error'=>'取消新品失败！');
                        break;

                    case 1:
                        $msg = array( 'success'=>'添加新品成功！', 'error'=>'添加新品失败！');
                        break;

                    default:
                        $this->error('非法参数');
                        break;
                }
                $this->editRow('ShopProductInfo',$data,$map,$msg);
                break;

            default:
                $this->error('非法参数');
                break;
        }

    }

    /**
     * 分类管理列表
     * @author Augus
     */
    public function category(){
        $tree = D('ShopCategory')->getTree(0,'id,name,sort,parent_id');
        $this->assign('tree', $tree);
        C('_SYS_GET_CATEGORY_TREE_', true); //标记系统获取分类树模板
        $this->meta_title = '品类列表';
        $this->display();
    }

    /**
     * 显示分类树，仅支持内部调
     * @param  array $tree 分类树
     * @author Augus
     */
    public function tree($tree = null){
        C('_SYS_GET_CATEGORY_TREE_') || $this->_empty();
        $this->assign('tree', $tree);
        $this->display('tree');
    }

    /* 编辑分类 */
    public function edit($id = null, $parent_id = 0){
        $ShopCategory = D('ShopCategory');

        if(IS_POST){ //提交表单
            if(false !== $ShopCategory->update()){
                $this->success('编辑成功！', U('category'));
            } else {
                $error = $ShopCategory->getError();
                $this->error(empty($error) ? '未知错误！' : $error);
            }
        } else {
            $cate = '';
            if($parent_id){
                /* 获取上级分类信息 */
                $cate = $ShopCategory->info($parent_id, 'id,name,sort,parent_id');
                if(!$cate){
                    $this->error('指定的上级分类不存在！');
                }
            }

            /* 获取分类信息 */
            $info = $id ? $ShopCategory->info($id) : '';

            $this->assign('info',       $info);
            $this->assign('category',   $cate);
            $this->meta_title = '编辑分类';
            $this->display();
        }
    }

    /* 新增分类 */
    public function add($parent_id = 0){
        $ShopCategory = D('ShopCategory');

        if(IS_POST){ //提交表单
            if(false !== $ShopCategory->update()){
                $this->success('新增成功！', U('category'));
            } else {
                $error = $ShopCategory->getError();
                $this->error(empty($error) ? '未知错误！' : $error);
            }
        } else {
            $cate = array();
            if($parent_id){
                /* 获取上级分类信息 */
                $cate = $ShopCategory->info($parent_id, 'id,name,sort,parent_id');
                if(!$cate){
                    $this->error('指定的上级分类不存在！');
                }
            }

            /* 获取分类信息 */
            $this->assign('info',       null);
            $this->assign('category', $cate);
            $this->meta_title = '新增分类';
            $this->display('edit');
        }
    }

    /**
     * 删除一个分类
     * @author Augus
     */
    public function remove(){
        $cate_id = I('id');
        if(empty($cate_id)){
            $this->error('参数错误!');
        }

        //判断该分类下有没有子分类，有则不允许删除
        $child = D('ShopCategory')->where(array('parent_id'=>$cate_id))->field('id')->select();
        if(!empty($child)){
            $this->error('请先删除该分类下的子分类');
        }

        //判断该分类下有没有产品
        $product_list = D('ShopProductInfo')->where(array('category_id'=>$cate_id))->field('id')->select();
        if(!empty($product_list)){
            $this->error('请先删除该分类下的产品');
        }

        //删除该分类信息
        $res = D('ShopCategory')->delete($cate_id);
        if($res !== false){
            $this->success('删除分类成功！');
        }else{
            $this->error('删除分类失败！');
        }
    }
}