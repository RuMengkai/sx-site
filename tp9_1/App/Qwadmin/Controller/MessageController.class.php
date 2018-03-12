<?php
/**
*
* 版权所有：恰维网络<qwadmin.qiawei.com>
* 作    者：寒川<hanchuan@qiawei.com>
* 日    期：2016-09-20
* 版    本：1.0.0
* 功能说明：文章控制器。
*
**/

namespace Qwadmin\Controller;
use Qwadmin\Controller\ComController;
use Vendor\Tree;

class MessageController extends ComController {

	public function add(){
		$this -> display();
	}
	//留言列表
	public function index($mid=0,$p=1){
		
		$mid = intval($mid);
		$p = intval($p)>0?$p:1;
		
		$message = M('message');
		$pagesize = 20;#每页数量
		$offset = $pagesize*($p-1);//计算记录偏移量
		$prefix = C('DB_PREFIX');
		if($mid){
			$where = "{$prefix}message.mid=$mid";
		}else{
			$where = '';
		}
		$count = $message->where($where)->count();
		$list  = $message->field("{$prefix}message.*")->where($where)->order("{$prefix}message.mid desc")->limit($offset.','.$pagesize)->select();
		
		$page	=	new \Think\Page($count,$pagesize); 
		$page = $page->show();
        $this->assign('list',$list);	
        $this->assign('page',$page);
		$this -> display();
	}
	
	public function del(){
		
		$mids = isset($_REQUEST['mids'])?$_REQUEST['mids']:false;
		if($mids){
			if(is_array($mids)){
				$mids = implode(',',$mids);
				$map['mid']  = array('in',$mids);
			}else{
				$map = 'mid='.$mids;
			}
			if(M('message')->where($map)->delete()){
				addlog('删除留言，AID：'.$mids);
				$this->success('恭喜，留言删除成功！');
			}else{
				$this->error('参数错误！1');
			}
		}else{
			$this->error('参数错误！');
		}

	}
	
	public function edit($mid){
		
		$mid = intval($mid);
		$message = M('message')->where('mid='.$mid)->find();
		if($message){
			$this->assign('message',$message);
		}else{
			$this->error('参数错误！');
		}
		$this -> display();
	}
	
	public function update($mid=0){
		
		$mid = intval($mid);
		$mid = isset($_POST['mid'])?$_POST['mid']:false;
		$data['title'] = isset($_POST['title'])?$_POST['title']:false;
		$data['content'] = isset($_POST['content'])?$_POST['content']:false;
		$data['user'] = isset($_POST['user'])?$_POST['user']:false;
		$data['dateline'] = time();
		if($mid){
			M('message')->data($data)->where('mid='.$mid)->save();
			addlog('编辑留言，MID：'.$mid);
			$this->success('恭喜！留言编辑成功！');
		}else{
			$mid = M('message')->data($data)->add();
			if($mid){
				addlog('新增留言，MID：'.$mid);
				$this->success('恭喜！留言新增成功！');
			}else{
				$this->error('抱歉，未知错误！');
			}
			
		}
	}
}