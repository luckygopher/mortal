<?php


namespace app\admin\controller;


use core\Mortal;

/**
 * 后台公告管理控制器
 * Class AboutController
 * @package app\admin\controller
 */
class AboutController extends Mortal
{
    //公告列表
    public function index(){
        $nickname = I('nickname');
        $SystemNotice = D('SystemNotice');
        $page = new \Think\Page($SystemNotice->count(),10);
        $map['title'] = array('like','%'.$nickname.'%');
        $map['nickname'] = $nickname;
        $map['_logic'] = 'or';
        if (!empty($nickname)) {
            $list = $SystemNotice->lists($map,$page->firstRow,$page->listRows);
        }else{
            $list = $SystemNotice->lists('',$page->firstRow,$page->listRows);
        }

        $this->assign('_page',$page->show());//分页显示
        $this->assign('_list',$list);
        $this->display();
    }

    //发布公告
    public function add(){
        $this->display();
    }

    //发布公告动作
    public function addAction(){
        $data['mid'] = is_login();
        $data['title'] = I('post.title');
        $data['content'] = I('post.content');
        $data['iTime'] = date('Y-m-d H:i:s');

        if (!D('SystemNotice')->adds($data)) {
            $this->error('公告发布失败!');
        }else{
            $this->success('公告发布成功！',U('index'));
        }
    }

    //编辑修改公告
    public function edit(){
        $map['id'] = I('id');
        $info = D('SystemNotice')->noticeInfo($map);
        if (!$info) {
            $this->error('获取编辑数据失败!');
        }else{
            $this->assign('info',$info);
            $this->display();
        }
    }

    //编辑公告动作
    public function editAction(){
        $map['id'] = I('get.id');
        $data['title'] = I('post.title');
        $data['content'] = I('post.content');
        if (!D('SystemNotice')->updateInfo($map,$data)) {
            $this->error('公告信息更新失败!');
        }else{
            $this->success('公告信息更新成功！',U('index'));
        }
    }

    //删除公告
    public function del(){
        $map['id'] = I('id');
        if (!D('SystemNotice')->deleteInfo($map)) {
            $this->error('公告信息删除失败！');
        }else{
            $this->success('公告信息删除成功！',U('index'));
        }
    }
}