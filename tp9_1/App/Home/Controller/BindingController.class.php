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

class BindingController extends Controller {
	//初始化
	
	public function _initialize(){
		//设置加载变量
		C(setting());
	}
	// 微信绑定入口
    public function index(){
    	//获取授权
		getBaseInfo();
		//获取access_tonke
    }
    //绑定页面
    public function binding(){
    	$code = $_GET ["code"];
    	//获取用户微信信息  发布时取消注释
    	//$user_info=getUserInfo($code);
    	$this->assign('user_info',$user_info);
    	//检查是否已经绑定，
    	$Model = M('student');
    	$where ['openid'] = $user_info['openid'];
    	
    	//将openid存入cookie中。
    	cookie('sx_openid',$user_info['openid']);
    	cookie('sx_headimgurl',$user_info['headimgurl']);
    	if(count($Model->where($where)->select())===0){
    		$this -> display();
    	}else{
    		//直接跳转页面
            $this->redirect("Binding/bindingsuccess");
    	}
    }
    //重新绑定页面
    public function rebinding(){
    	//获取用户微信信息
    	$user_info['openid']=cookie('sx_openid');
    	$user_info['headimgurl']=cookie('sx_headimgurl');
    	$this->assign('user_info',$user_info);
    	$this -> display();
    }
    
    //点击绑定之后跳转页面
    public function binding_add(){
    	$Model = M('student');
		$data['openid'] = isset($_POST['openid'])?$_POST['openid']:false;
		$data['headimgurl'] = isset($_POST['headimgurl'])?$_POST['headimgurl']:false;
		$data['phone'] = isset($_POST['tels'])?$_POST['tels']:false;
		$data['email'] = isset($_POST['email'])?$_POST['email']:false;
		$data['time'] = time();
		$where ['stunumber'] = $_POST['stunumber'];
		if(count($Model->where($where)->select())==0){
			$this->error('不存在此学号，绑定失败！。',U('binding/index'));
		}else{
			$Model->where($where)->save($data);
			
			$this->success('绑定成功！',U('Binding/bindingsuccess'));
		}
    }
 	/*public function send(){
    	getBaseInfo1();
    }*/
    public function sendTempMsg(){
    	sendTemplateMsg();
    }
    // 绑定成功页面
    public function bindingsuccess(){
    	$this -> display();
    }
}