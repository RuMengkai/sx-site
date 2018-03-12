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

class ScoreController extends ComController {
	
	//用户积分列表
	public function index($mid=0,$p=1){
		
		$p = isset($_GET['p'])?intval($_GET['p']):'1';
		$field = isset($_GET['field'])?$_GET['field']:'';
		$keyword = isset($_GET['keyword'])?htmlentities($_GET['keyword']):'';
		$order = isset($_GET['order'])?$_GET['order']:'DESC';
		$where = '';
		
		$prefix = C('DB_PREFIX');
		if($order == 'asc'){
			$order = "{$prefix}member.t asc";
		}elseif(($order == 'desc')){
			$order = "{$prefix}member.t desc";
		}else{
			$order = "{$prefix}member.uid asc";
		}
		if($keyword <>''){
			if($field=='user'){
				$where = "{$prefix}member.user LIKE '%$keyword%'";
			}
			if($field=='phone'){
				$where = "{$prefix}member.phone LIKE '%$keyword%'";
			}
			if($field=='qq'){
				$where = "{$prefix}member.qq LIKE '%$keyword%'";
			}
			if($field=='email'){
				$where = "{$prefix}member.email LIKE '%$keyword%'";
			}
		}
		
		$user = M('member');
		$pagesize = 15;#每页数量
		$offset = $pagesize*($p-1);//计算记录偏移量
		$count = $user->count();
		
		$list  = $user->field("{$prefix}member.*,{$prefix}auth_group.id as gid,{$prefix}auth_group.title")->order($order)->join("{$prefix}auth_group_access ON {$prefix}member.uid = {$prefix}auth_group_access.uid")->join("{$prefix}auth_group ON {$prefix}auth_group.id = {$prefix}auth_group_access.group_id")->where($where)->limit($offset.','.$pagesize)->select();
		
		//$user->getLastSql();
		$page	=	new \Think\Page($count,$pagesize); 
		$page = $page->show();
        $this->assign('list',$list);	
        $this->assign('page',$page);
		$group = M('auth_group')->field('id,title')->select();
		$this->assign('group',$group);
		$this -> display();
	}
	//积分设置列表
	public function set($id=0,$p=1){
		//intval整型转换
		$id = intval($id);
		$p = intval($p)>0?$p:1;
		
		$score = M('score');
		$pagesize = 20;#每页数量
		$offset = $pagesize*($p-1);//计算记录偏移量
		$prefix = C('DB_PREFIX');
		if($id){
			$where = "{$prefix}score.mid=$id";
		}else{
			$where = '';
		}
		$count = $score->where($where)->count();
		$list  = $score->field("{$prefix}score.*")->where($where)->order("{$prefix}score.id desc")->limit($offset.','.$pagesize)->select();
		
		$page	=	new \Think\Page($count,$pagesize); 
		$page = $page->show();
        $this->assign('list',$list);	
        $this->assign('page',$page);
		$this -> display();
	}
	//增加积分种类
	public function add(){
		$this -> display();
	}
	//删除积分类型
	public function del(){
		
		$ids = isset($_REQUEST['ids'])?$_REQUEST['ids']:false;
		if($ids){
			if(is_array($ids)){
				$ids = implode(',',$ids);
				$map['id']  = array('in',$ids);
			}else{
				$map = 'id='.$ids;
			}
			if(M('score')->where($map)->delete()){
				addlog('删除积分类型成功，AID：'.$ids);
				$this->success('恭喜，积分类型删除成功！');
			}else{
				$this->error('参数错误！');
			}
		}else{
			$this->error('参数错误！');
		}
		
	}

	//修改用户的积分
	public function edit(){
		
		$uid = isset($_GET['uid'])?intval($_GET['uid']):false;
		if($uid){	
			//$member = M('member')->where("uid='$uid'")->find();
			$prefix = C('DB_PREFIX');
			$user = M('member');
			$member  = $user->field("{$prefix}member.*,{$prefix}auth_group_access.group_id")->join("{$prefix}auth_group_access ON {$prefix}member.uid = {$prefix}auth_group_access.uid")->where("{$prefix}member.uid=$uid")->find();

		}else{
			$this->error('参数错误！');
		}
		
		$usergroup = M('auth_group')->field('id,title')->select();
		$this->assign('usergroup',$usergroup);

		$this->assign('member',$member);
		$this -> display();
		
	}
	//修改用户的积分
	public function update(){
		
		$uid = isset($_POST['uid'])?intval($_POST['uid']):false;
		$score = isset($_POST['score'])?intval($_POST['score']):false;
		$data['score'] =$score;
		if($uid){
			M('member')->data($data)->where("uid=$uid")->save();
			$this->success('操作成功！');
			//$this -> index();
		}else{
			$this->error('参数错误');
		}
	}
	//编辑积分类型
	public function edit_score($id){
		
		$id = intval($id);
		$score = M('score')->where('id='.$id)->find();
		if($score){
			$this->assign('score',$score);
		}else{
			$this->error('参数错误！');
		}
		$this -> display();
	}
	//增加/修改积分类型
	public function update_score($id=0){
		$id = intval($id);
		$data['name'] = isset($_POST['name'])?$_POST['name']:false;
		$data['desc'] = isset($_POST['desc'])?$_POST['desc']:false;
		$data['score'] = isset($_POST['score'])?$_POST['score']:false;
		$data['dateline'] = time();
		if($id){
			M('score')->data($data)->where('id='.$id)->save();
			addlog('编辑积分类型，MID：'.$mid);
			$this->success('恭喜！积分类型编辑成功！');
		}else{
			$mid = M('score')->data($data)->add();
			if($mid){
				addlog('新增积分类型，MID：'.$mid);
				$this->success('恭喜！积分类型新增成功！');
				
			}else{
				$this->error('抱歉，未知错误！');
			}
		}
	}
}