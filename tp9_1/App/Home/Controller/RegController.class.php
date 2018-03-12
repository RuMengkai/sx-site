<?php
/*
 * @thinkphp3.2.2  auth认证
 * @wamp2.1a  php5.3.3  mysql5.5.8
 * @Created on 2015/08/18
 * @Author  夏日不热    757891022@qq.com
 *
 */

namespace Home\Controller;
use Common\Controller\BaseController;
use Think\Auth;

//不验证的控制器
class RegController extends BaseController {
	
	// 微信发送验证码
	public function sms_code(){
		$uid = "lovenr";
		$pwd = md5('xinglei0351');
		$user = I('user');
		$password = I('password');
		$message = '【优企点将】您的注册验证码为'.$_SESSION['T']['Creg']['verify_code'];
		if($user && $password){
			$gateway = "http://api.smsbao.com/sms?u=".$uid."&p=".$pwd."&m=".$user."&c=".$message;
			$result = file_get_contents($gateway);
			$this->ajaxReturn(1);
		}else{
			$this->ajaxReturn(0);	
    	}

		//return $result;
	}
	
	
	// 注册用户
	public function reg(){
		 if(IS_POST){
			$verify = isset($_POST['verify'])?trim($_POST['verify']):'';
			/*if (!$this->check_verify($verify,'reg')) {
				$this -> error('验证码错误！',U("login/reg"));
			}*/
			$m = M('Member');
			$where['user'] = I('user');
			$result = $m->where($where)->find();
			if(!empty($result)){
				$this->error('请勿重复注册',U('login/reg'));
			}
			//
			$data['user'] = I('user');	//用户ID
			$data['password'] = password(I('password'));
			$data['phone'] = I('user');
			$data['t'] = time();
			$result['uid'] = $m->add($data);   
			
			$result['group_id'] = I('group_id');	//用户组ID
	
			session('user',I('user'));	//管理员账号写入缓存 
			session('uid',$result['uid']);	
			
			if($result['uid']){
    			$m = M('Auth_group_access');
    			//分配用户组
    			if($m->add($result)){
    				$this->success('注册成功,请重新登录！',U('Index/Index'));
    			}else{
    				$this->error('注册失败,稍后再试！',U('login/reg'));
    			}
    		}else{
    			$this->success('注册成功,请重新登录！',U('Index/Index'));
    		}
			//var_dump($result);
    	}else{
    		$m = M('Auth_group');
    		$data = $m->field('id,title')->select();
    		$this->assign('data',$data);
    		$this->display("login/reg");
			//print_r($_SESSION['T']['Creg']['verify_code']);
    	}
	}
    
   public function verify() {
		$config = array(
		'fontSize' => 14, // 验证码字体大小
		'length' => 4, // 验证码位数
		'useNoise' => false, // 关闭验证码杂点
		'imageW'=>100,
		'imageH'=>30,
		'codeSet'=>'19023',
		'useCurve'=> false,	// 是否画混淆曲线 false | true
		);
		$verify = new \Think\Verify($config);
		$verify -> entry('reg');
	}
	
	function check_verify($code, $id = '') {
		$verify = new \Think\Verify();
		return $verify -> check($code, $id);
	}
}