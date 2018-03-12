<?php
/**
*
* 版权所有：恰维网络<qwadmin.qiawei.com>
* 作    者：寒川<hanchuan@qiawei.com>
* 日    期：2016-09-20
* 版    本：1.0.0
* 功能说明：后台首页控制器。
*
**/

namespace Home\Controller;
use Think\Controller;


class MobileController extends Controller {
	//首页
    public function index(){
    	//将用户/发布者UID存入cookie
		cookie('sxu_uid',$_GET['uid']);
		$where['uid'] = $_GET['uid'];
		$list = M('Sign_list')->where($where)->order('ding,id DESC')->select();
		//日期格式化
		foreach($list as $key=>$value){
			$list[$key]['ktime'] = date("Y-m-d H:i",$list[$key]['ktime']);
		}
		$this->assign('list',$list);
		$this -> display();
	}
	//查看报名列表课程
	public function result(){
    	//将用户/发布者UID存入cookie
		cookie('sxu_uid',$_GET['uid']);
		$where['uid'] = $_GET['uid'];
		$list = M('Sign_list')->where($where)->order('ding,id DESC')->select();
		//日期格式化
		foreach($list as $key=>$value){
			$list[$key]['ktime'] = date("Y-m-d H:i",$list[$key]['ktime']);
		}
		$this->assign('list',$list);
		$this -> display();
	}
	//查看对应课程的报名成功的名单
	public function signPass(){
		$this->uid = cookie('sxu_uid');
		$classid=$_GET['id'];
//		echo $classid;
		$where2['classid'] = $classid;
		$where2['display'] = "1";
		$list = M('sign')->where($where2)->order('id DESC')->select();
		$count=count($list);
		if($list){
		   foreach($list as $key=>$value){
			$list[$key]['stunumber'] = substr_replace($value['stunumber'], '*****', 4, -3);
		   }
		}
		$this->assign('list',$list);
		$this->assign('count',$count);
		$this -> display();
	}
	
	// 活动内容
	public function view(){
		$this->uid = cookie('sxu_uid');
		$classid=$_GET['id'];
		cookie('sxu_classid',$classid);
		// 调用活动内容
		$where['id'] = $classid;
		$classInfo = M('Sign_list')->where($where)->find();
		$this->assign('classInfo',$classInfo);
		$this->assign('ktime',date("Y-m-d H:i",$classInfo['ktime']));
		//比较时间判断是否结束报名
		$time = time();
		$this->assign('time',date("YmdHi",$time));
		$this->assign('ktimes',date("YmdHi",$classInfo['ktime']));
		// 调用已报名列表
		$where2['classid'] = $classid;
		$list = M('sign')->where($where2)->order('id DESC')->select();
		if($list){
		   foreach($list as $key=>$value){
			$list[$key]['stunumber'] = substr_replace($value['stunumber'], '*****', 4, -3);
		   }
		}
		$this->assign('list',$list);
		$this -> display();
    }
	
	// 报名
	public function add(){
		//从cookie中获取classID和UID，学号；
		$this->id = cookie('sxu_classid');
		$uid = cookie('sxu_uid');
		//根据stunumber查询学生信息
		$where['stunumber']=cookie('sxu_stunumber');;
		if($where['stunumber']!=""){
			$list=M('student')->where($where)->select();
			$this->assign('list',$list);
		}
		if(IS_POST){
			$stunumber= isset($_POST['stunumber'])?$_POST['stunumber']:false;
			$tels = isset($_POST['tels'])?$_POST['tels']:false;
			$da['phone']=$tels;
			// echo $tels;
			// 这里存在一个bug,在创业报名板块，用户首次报名时会出现错误界面
			// exit();
			//校验数据库中是否存在此学号
			$where_n['stunumber']=$stunumber;
			if(count($list=M('student')->where($where_n)->select())==0){
				$this->error('不存在此学号，请重新输入。');
			}else{
				//增加手机号
				M('student')->where($where_n)->save($da);
				//首次报名，将学号存入cookie；
				cookie('sxu_stunumber',$stunumber);
			}
			//查询此学生信息
			$data['classid'] = cookie('sxu_classid');
			$data['uid'] = $uid;
			$data['stunumber'] = $list[0]['stunumber'];
			$data['name'] = $list[0]['name'];
			$data['sex'] = $list[0]['sex'];
			$data['identifier'] = $list[0]['identifier'];
			$data['tels'] = $list[0]['phone'];
			$data['grade'] = $list[0]['grade'];
			$data['major'] = $list[0]['major'];
			$data['college'] = $list[0]['college'];
			$data['xuezhi'] = $list[0]['xuezhi'];
			$data['campus'] = $list[0]['campus'];
			$data['display'] = 0;
			$data['dateline'] = time();
			//防止重复报名
			$w['classid']=$data['classid'];
			$w['stunumber']=$data['stunumber'];
			if(count(M('Sign')->where($w)->select())!=0){
				$this->error('不能重复报名。审核结果会在"报名查看"菜单中显示，请及时查看。');
			}
			//增加报名记录
			if(M('Sign')->add($data)){
				// 更新报名信息
				$M = M('Sign_list');
				$map['id'] = cookie('sxu_classid');
				$M->where($map)->setInc('ybnum');
				$this->success('报名成功！审核结果，结果会在"报名查看"菜单中显示，请及时查看。',U('Mobile/view')."?id=".cookie('sxu_classid'),5);
			}else{
				$this->error('报名失败！');
			}
		}else{
			$this -> display();
		}
	}
}