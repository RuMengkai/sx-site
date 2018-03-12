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
use Home\Controller\ComController;

class SignController extends ComController {
	// 报名学生名单信息列表
	public function looks(){
		$user=$this->USER['user'];
		$uid = $this->USER['uid'];
		$desc = $this->USER['desc'];
		$fid = $this->USER['fid'];
		if ($fid==16) {
			$uid=16;
		}
		$classid = I('id');
		$p = isset($_GET['p'])?intval($_GET['p']):'1';
		$field = isset($_GET['field'])?$_GET['field']:'';
		$keyword = isset($_GET['keyword'])?htmlentities($_GET['keyword']):'';
		$where = 'classid='.$classid.' AND uid='.$uid;
		
		$prefix = C('DB_PREFIX');
		if($keyword <>''){
			if($field=='xingming'){
				$where = "{$prefix}sign.xingming LIKE '%$keyword%' AND uid='$uid' AND classid='$classid'";
			}
			if($field=='tels'){
				$where = "{$prefix}sign.tels LIKE '%$keyword%' AND uid='$uid' AND classid='$classid'";
			}
		}
		
		$m = M('Sign');
		$pagesize = 15;#每页数量
		$offset = $pagesize*($p-1);//计算记录偏移量
		$count = $m->where($where)->count();
		
		$list  = $m->where($where)->order('dateline asc')->limit($offset.','.$pagesize)->select();
		$list = $this->getMenu($list);
		//筛选每个学院
		if ($user=="sxujob"||$user=="sxucypx") {
		}else{
			$list2=[];
			for ($i=0; $i < count($list); $i++) {
				if ($list[$i]["college"]==$desc) {
					array_push($list2,$list[$i]);
				}
			}
			$list=$list2;
		}
		$page	=	new \Think\Page($count,$pagesize); 
		$page = $page->show();
        $this->assign('uid',$uid);
        $this->assign('classid',$classid);		
        $this->assign('list',$list);
		$this->assign('page',$page);	
		$this -> display();
    }
	
	// 活动信息列表
    public function signList(){
		
		$uid = $this->USER['uid'];
		$user=$this->USER['user'];
		$fid = $this->USER['fid'];
		if ($fid==16) {
			$uid=16;
		}
		$p = isset($_GET['p'])?intval($_GET['p']):'1';
		$field = isset($_GET['field'])?$_GET['field']:'';
		$keyword = isset($_GET['keyword'])?htmlentities($_GET['keyword']):'';
		$where = 'uid='.$uid;
		
		$prefix = C('DB_PREFIX');
		if($keyword <>''){
			if($field=='title'){
				$where = "{$prefix}sign_list.title LIKE '%$keyword%' AND uid='$uid'";
			}
		}
		
		$m = M('Sign_list');
		$pagesize = 15;#每页数量
		$offset = $pagesize*($p-1);//计算记录偏移量
		$count = $m->count();
		
		$list  = $m->where($where)->order('ding,id DESC')->limit($offset.','.$pagesize)->select();
		$list = $this->getMenu($list);
		
		$page	=	new \Think\Page($count,$pagesize); 
		$page = $page->show();
		
        $this->assign('list',$list);
        $this->assign('username',$user);
		$this->assign('page',$page);	
		$this -> display();
    }
	
	// 编辑活动
	public function sedit(){
		
		if(IS_POST){
			$m = M('Sign_list');
			
			$where['id'] = I('id');
			$where['uid'] = I('uid');
			$data['zuid'] = isset($_POST['zuid'])?intval($_POST['zuid']):0;
			$data['title'] = isset($_POST['title'])?$_POST['title']:false;
			$data['content'] = isset($_POST['content'])?$_POST['content']:false;
			$data['ktime'] = isset($_POST['ktime'])?strtotime($_POST['ktime']):0;
			$data['xdnum'] = isset($_POST['xdnum'])?intval($_POST['xdnum']):0;
			$data['address'] = isset($_POST['address'])?$_POST['address']:false;
			
			$result = $m->where($where)->save($data);
			if($result){
				$this->success('修改成功',U('Sign/sedit')."?id=".I('id'));
			}else{
				$this->error('没有要修改的内容',U('Sign/sedit')."?id=".I('id'));
			}
		}else{
			$where['id'] = I('id');
			$result = D('Sign')->relation(true)->where($where)->find();
			//dump($result);
			$this->assign('result',$result);
			// 查询所有的发起人
			$mf = M('Sign_user');
			$map['uid'] = $this->USER['uid'];
			$map['display'] = 1;
			$list = $mf->where($map)->select();
			$this->assign('list',$list);
			$this->display();	
		}
		
	}
		
	// 发布活动
	public function add(){
		if(IS_POST){
			
			$Model = M('Sign_list');
			$data['uid'] = isset($_POST['uid'])?intval($_POST['uid']):0;
			$data['type_id'] = isset($_POST['type_id'])?intval($_POST['type_id']):0;
			$data['zuid'] = isset($_POST['zuid'])?intval($_POST['zuid']):0;
			$data['title'] = isset($_POST['title'])?$_POST['title']:false;
			$data['content'] = isset($_POST['content'])?$_POST['content']:false;
			$data['ktime'] = isset($_POST['ktime'])?strtotime($_POST['ktime']):0;
			$data['xdnum'] = isset($_POST['xdnum'])?intval($_POST['xdnum']):0;
			$data['address'] = isset($_POST['address'])?$_POST['address']:false;
			$data['dateline'] = time();
			
			if($Model->add($data)){
				$this->success('信息发布成功！',U('Sign/signList'));
			}else{
				$this->error('信息发布失败！');
			}
		}else{
			$m = M('Sign_user');
			$where['uid'] = $this->USER['uid'];
			$where['display'] = 1;
			$list = $m->where($where)->select();
			$this->assign('list',$list);
			$this -> display();
		}
    }
	//导出数据到excel
	public function output(){
		//获取变量信息
		$uid = $this->USER['uid'];//发布者
		$user=$this->USER['user'];
		$fid = $this->USER['fid'];
		if ($fid==16) {
			$uid=16;
		}
		$desc = $this->USER['desc'];
		$classid = I('id');//课程id
		
		$dir=dirname(_FILE_);//找到当前脚本所在路径
		vendor("PHPExcel.PHPExcel");
		$objPHPExcel=new\PHPExcel();//实例化PHPExcel类 等同于在桌面上新建一个excel表格
		$objSheet=$objPHPExcel->getActiveSheet();//获得当前活动sheet的操作对象
		//获取课程名称
		$where1['id']=$classid;
		$theme = M('sign_list')->where($where1)->field('title')->select();
		$th=$theme[0]['title'];

		$objSheet->setTitle($th."参报名单");//给当前活动sheet设置名称
		//获取导出信息列表
		$where = 'classid='.$classid.' AND uid='.$uid;
		$m = M('Sign');
		$array = $m->where($where)->field('stunumber,name,sex,identifier,grade,major,college,campus,xuewei,xuezhi,tels,display,dateline')->select();
		//筛选每个学院
		// echo $array;
		if ($user=="sxujob"||$user=="sxucypx") {
		}else{
			$array2=[];
			for ($i=0; $i < count($array); $i++) {
				if ($array[$i]["college"]==$desc) {
					array_push($array2,$array[$i]);
				}
			}
			$array=$array2;
		}
		//转换性别，日期格式
		foreach($array as $key1=>$v1){
			$array[$key1]['dateline']=date("Y-m-d h:i:s",$array[$key1][dateline]);
			$array[$key1]['sex']=$v1['sex']==1?'男':'女';
			$array[$key1]['display']=$v1['display']==1?'通过':'未通过';
		}
		//将数据封装成excel
		//设置宽
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(8);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(8);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(28);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(28);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(28);

		//设置首行
		$objPHPExcel->getActiveSheet()->setCellValue('A1',"学号"); 
		$objPHPExcel->getActiveSheet()->setCellValue('B1',"姓名"); 
		$objPHPExcel->getActiveSheet()->setCellValue('C1',"性别"); 
		$objPHPExcel->getActiveSheet()->setCellValue('D1',"身份证号"); 
		$objPHPExcel->getActiveSheet()->setCellValue('E1',"年级"); 
		$objPHPExcel->getActiveSheet()->setCellValue('F1',"专业"); 
		$objPHPExcel->getActiveSheet()->setCellValue('G1',"学院"); 
		$objPHPExcel->getActiveSheet()->setCellValue('H1',"校区"); 
		$objPHPExcel->getActiveSheet()->setCellValue('I1',"学位"); 
		$objPHPExcel->getActiveSheet()->setCellValue('J1',"学制"); 
		$objPHPExcel->getActiveSheet()->setCellValue('K1',"手机"); 
		$objPHPExcel->getActiveSheet()->setCellValue('L1',"报名时间");
		$objPHPExcel->getActiveSheet()->setCellValue('M1',"是否通过审核");
		//循环输出数据 
		for ($i = 2; $i <= count($array)+1; $i++) {
   			$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, " ".$array[$i-2]["stunumber"]);
   			$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $array[$i-2]["name"]);
   			$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $array[$i-2]["sex"]);
   			$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, " ".$array[$i-2]["identifier"]);
   			$objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $array[$i-2]["grade"]);
   			$objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $array[$i-2]["major"]);
   			$objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $array[$i-2]["college"]);
   			$objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $array[$i-2]["campus"]);
   			$objPHPExcel->getActiveSheet()->setCellValue('I'.$i, $array[$i-2]["xuewei"]);
   			$objPHPExcel->getActiveSheet()->setCellValue('J'.$i, $array[$i-2]["xuezhi"]);
   			$objPHPExcel->getActiveSheet()->setCellValue('K'.$i, " ".$array[$i-2]["tels"]);
   			$objPHPExcel->getActiveSheet()->setCellValue('L'.$i, $array[$i-2]["dateline"]);
   			$objPHPExcel->getActiveSheet()->setCellValue('M'.$i, $array[$i-2]["display"]);
   		}

		//$objSheet->fromArray($array);//直接存放数组
		//$objPHPExcel->createSheet();
		$objWriter=\PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
		//生成表名
		$names=$th.date("Ymdhis",time());
		//下载excel
		ob_end_clean();//清除，避免出现乱码。
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$names.'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter->save('php://output');
		//$objWriter->save("Public/data/".$names.".xlsx");//保存到文件服务器data
//		$this->success('导出成功!','',3);
	}
	// 发起人
	public function faqi(){
		
		$uid = $this->USER['uid'];
		$classid = I('id');
		$p = isset($_GET['p'])?intval($_GET['p']):'1';
		$field = isset($_GET['field'])?$_GET['field']:'';
		$keyword = isset($_GET['keyword'])?htmlentities($_GET['keyword']):'';
		$where = 'uid='.$uid;
		
		$prefix = C('DB_PREFIX');
		if($keyword <>''){
			if($field=='xingming'){
				$where = "{$prefix}sign_user.xingming LIKE '%$keyword%' AND uid='$uid'";
			}
		}
		
		$m = M('Sign_user');
		$pagesize = 15;#每页数量
		$offset = $pagesize*($p-1);//计算记录偏移量
		$count = $m->where($where)->count();
		
		$list  = $m->where($where)->order('id DESC')->limit($offset.','.$pagesize)->select();
		$list = $this->getMenu($list);
		
		$page	=	new \Think\Page($count,$pagesize); 
		$page = $page->show();
		
        $this->assign('list',$list);
		$this->assign('page',$page);	
		$this -> display();
    }
	
	// 编辑发起人
	public function faqi_edit(){
		
		if(IS_POST){
			$m = M('Sign_user');
			
			$where['id'] = I('id');
			$where['uid'] = I('uid');
			
			$author = I('post.author','','strip_tags');
			$data['author'] = $author?$author:'';
			$data['xingming'] = isset($_POST['xingming'])?$_POST['xingming']:false;
			$data['contens'] = isset($_POST['contens'])?$_POST['contens']:false;
			$data['display'] = isset($_POST['display'])?intval($_POST['display']):0;
			$data['tel'] = isset($_POST['tel'])?trim($_POST['tel']):'';
			
			$result = $m->where($where)->save($data);
			if($result){
				$this->success('修改成功',U('Sign/faqi'));
			}else{
				$this->error('没有要修改的内容',U('Sign/faqi'));
			}
		}else{
			$m = M('Sign_user');
			$where['id'] = I('id');
			$result = $m->where($where)->find();
			$this->assign('result',$result);
			$this->display();	
		}
	}
	
	public function faqi_add(){
		
		$uid = $this->USER['uid'];
		if(IS_POST){
			$Model = M('Sign_user');
			$author = I('post.author','','strip_tags');
			$data['author'] = $author?$author:'';
			$data['uid'] = isset($_POST['uid'])?intval($_POST['uid']):0;
			$data['tel'] = isset($_POST['tel'])?intval($_POST['tel']):false;
			$data['xingming'] = isset($_POST['xingming'])?$_POST['xingming']:false;
			$data['contens'] = isset($_POST['contens'])?$_POST['contens']:false;
			$data['display'] = isset($_POST['display'])?intval($_POST['display']):0;
			$data['dateline'] = time();
			if($Model->add($data)){
				$this->success('信息发布成功！',U('Sign/faqi'));
			}else{
				$this->error('信息发布失败！');
			}
		}else{
			$this -> display();
		}
		
    }
	
	// 嘉宾管理
	public function jiabin(){
		if(IS_POST){
			
			$Model = M('Sign_list');
			$data['uid'] = isset($_POST['uid'])?intval($_POST['uid']):0;
			$data['title'] = isset($_POST['title'])?$_POST['title']:false;
			$data['content'] = isset($_POST['content'])?$_POST['content']:false;
			$data['ktime'] = isset($_POST['ktime'])?strtotime($_POST['ktime']):0;
			$data['xdnum'] = isset($_POST['xdnum'])?intval($_POST['xdnum']):0;
			$data['address'] = isset($_POST['address'])?$_POST['address']:false;
			$data['dateline'] = time();
			
			if($Model->add($data)){
				$this->success('信息发布成功！',U('Sign/signList'));
			}else{
				$this->error('信息发布失败！');
			}
		}else{
			$this -> display();
		}
    }
	
	// 置顶活动信息
	public function ding(){
		$did = I('did');
		$where['id'] = I('id');
		$m = M('Sign_list');
		if($did == 1){
			$data['ding'] = 1;
		}else{
			$data['ding'] = 2;
		}
		if($m->where($where)->save($data)){
			$this->ajaxReturn(1);
		}else{
			$this->ajaxReturn(0);
		}
	}
	
	// 删除活动信息
	public function del(){
		$where['id'] = I('id');
		$m = M('Sign_list');
		if($m->where($where)->delete()){
			$this->ajaxReturn(1);
		}else{
			$this->ajaxReturn(0);
		}
	}
	
	// 删除活动发起人
	public function del_fa(){
		$where['id'] = I('id');
		$m = M('Sign_user');
		if($m->where($where)->delete()){
			$this->ajaxReturn(1);
		}else{
			$this->ajaxReturn(0);
		}
	}
	// 审核报名信息
	public function audit(){
		$where['id'] = I('id');
		$m = M('Sign');
		$data['display'] = 1;
		if($m->where($where)->save($data)){
			$this->ajaxReturn(1);
		}else{
			$this->ajaxReturn(0);
		}
	}
	// 标记为已联系
	public function biaoji(){
		$where['id'] = I('id');
		$m = M('Sign');
		$data['display'] = 1;
		if($m->where($where)->save($data)){
			$this->ajaxReturn(1);
		}else{
			$this->ajaxReturn(0);
		}
	}
	
	//发送通知
	public function sendTempMsg(){
		//查询到openID
		$where['id'] = I('id');
		$list=M('Sign')->where($where)->select();
		$openid=$list[0]['openid'];
		$name=$list[0]['xingming'];
		//查询课程信息
		$wh['id']=$list[0]['classid'];
		$list2=M('sign_list')->where($wh)->select();
		$title=$list2[0]['title'];
		$address=$list2[0]['address'];
		$dateline=$list2[0]['dateline'];
		$id=$list2[0]['id'];
		//echo $id;
		if($list[0]['display']!=0){
			/*发送模板消息信息*/
			if(sendTemplateMsg($openid,$name,$title,$address,$dateline,$id)){
				$this->ajaxReturn(1);
			}
		}else{
				$this->ajaxReturn(0);
		}
    }
	
	
	// 发送链接操作
	public function fasong(){
		$id = I('id');
		$appID = C('appID');
		$appSecret = C('appSecret');
		$access_id = access_token($appID,$appSecret);
		$kxtime = date('m-d H:i:s', time());
		// 查询OPENID
		$where['uid'] = $this->USER['uid'];
		$result = M('Member')->where($where)->find();
		$openid = $result['openid'];
		if($openid){
			$json = '{
			"touser":"'.$openid.'",
			"template_id":"qfqIYu5EILC9JGInEnXgK1Sv8RpwsYxY2AkLCnrPWzw",
			"url":"http://192.168.31.174/tp9/index.php/Home/mobile/view.html?id='.$id.'",
			"topcolor":"#FF0000",
			"data":{
				"first": {
				"value":"========【链接预览】=======",
				"color":"#CC0000"
				},
				"keyword1":{
				"value":"系统管理员",
				"color":"#000000"
				},
				"keyword2":{
				"value":"'.$kxtime.'",
				"color":"#000000"
				},
				"remark":{
				"value":"========【点击预览】=======",
				"color":"#CC0000"
				}
			}
			}';
			$res = curlGet($access_id,'post',$json);
			// 微信推送消息结束
			$this->ajaxReturn(1);
		}else{
			$this->ajaxReturn(0);
		}
	}
	
	
}