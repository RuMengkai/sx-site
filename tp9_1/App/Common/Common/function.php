<?php
/**
*
* 版权所有：恰维网络<qwadmin.qiawei.com>
* 作    者：寒川<hanchuan@qiawei.com>
* 日    期：2015-09-17
* 版    本：1.0.0
* 功能说明：模块公共文件。
*
**/


function UpImage($callBack="image",$width=100,$height=100,$image=""){
    echo '<iframe scrolling="no" frameborder="0" border="0" onload="this.height=this.contentWindow.document.body.scrollHeight;this.width=this.contentWindow.document.body.scrollWidth;" width='.$width.' height="'.$height.'"  src="'.U('Upload/uploadpic').'?Width='.$width.'&Height='.$height.'&BackCall='.$callBack.'&Img='.$image.'"></iframe>
         <input type="hidden" name="'.$callBack.'" id="'.$callBack.'">';
}
function BatchImage($callBack="image",$height=300,$image=""){
    echo '<iframe scrolling="no" frameborder="0" border="0" onload="this.height=this.contentWindow.document.body.scrollHeight;this.width=this.contentWindow.document.body.scrollWidth;" src="'.U('Upload/batchpic').'?BackCall='.$callBack.'&Img='.$image.'"></iframe>
		<input type="hidden" name="'.$callBack.'" id="'.$callBack.'">';
}


/*
 * 函数：网站配置获取函数
 * @param  string $k      可选，配置名称
 * @return array          用户数据
*/
function setting($k=''){
	if($k==''){
        $setting =M('setting')->field('k,v')->select();
		foreach($setting as $k=>$v){
			$config[$v['k']] = $v['v'];
		}
		return $config;
	}else{
		$model = M('setting');
		$result=$model->where("k='{$k}'")->find(); 
		return $result['v'];
	}
}

/**
 * 函数：格式化字节大小
 * @param  number $size      字节数
 * @param  string $delimiter 数字和单位分隔符
 * @return string            格式化后的带单位的大小
 */
function format_bytes($size, $delimiter = '') {
	$units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
	for ($i = 0; $size >= 1024 && $i < 5; $i++) $size /= 1024;
	return round($size, 2) . $delimiter . $units[$i];
}

/**
 * 函数：加密
 * @param string            密码
 * @return string           加密后的密码
 */
function password($password){
	/*
	*后续整强有力的加密函数
	*/
	return md5('Q'.$password.'W');

}

/**
 * 随机字符
 * @param number $length 长度
 * @param string $type 类型
 * @param number $convert 转换大小写
 * @return string
 */
function random($length=6, $type='string', $convert=0){
    $config = array(
        'number'=>'1234567890',
        'letter'=>'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
        'string'=>'abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789',
        'all'=>'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'
    );
    
    if(!isset($config[$type])) $type = 'string';
    $string = $config[$type];
    
    $code = '';
    $strlen = strlen($string) -1;
    for($i = 0; $i < $length; $i++){
        $code .= $string{mt_rand(0, $strlen)};
    }
    if(!empty($convert)){
        $code = ($convert > 0)? strtoupper($code) : strtolower($code);
    }
    return $code;
}

// 微信相关
function curlGet($url,$method='get',$data=''){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $temp = curl_exec($ch);
    return $temp;
}
//获取授权信息
function getBaseInfo($re){
	$appID = C('appID');
	$appSecret = C('appSecret');
	$redirect_uri = 'http://51xy8.com/tp9_1/index.php/Home/binding/binding.html';
	$scope = 'snsapi_userinfo'; // 需要授权
	// 1、获取code
	$url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $appID . '&redirect_uri=' . urlencode ( $redirect_uri ) . '&response_type=code&scope=' . $scope . '&state=1#wechat_redirect';
	header ( "Location:" . $url );
}
// 获取用户信息
function getUserInfo($code) {
	$appID = C('appID');
	$appSecret = C('appSecret');
	//获取token
	$get_token_url = curlGet('https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $appID . '&secret=' . $appSecret . '&code=' . $code . '&grant_type=authorization_code');
	$json_obj = json_decode ( $get_token_url, true );
	$access_token = $json_obj ['access_token'];
	$openid = $json_obj ['openid'];
	// ---------------------------------------------获取详细信息
	$get_user_info_url = curlGet('https://api.weixin.qq.com/sns/userinfo?access_token=' . $access_token . '&openid=' . $openid . '&lang=zh_CN');
	$user_obj = json_decode ( $get_user_info_url, true );
	return $user_obj;
}

//获取access_token
function access_token($appid,$secret){
	$appid = C('appID');
	$secret = C('appSecret');
	$result =array();
	$gateway = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$secret;
	$result = file_get_contents($gateway);
	$data = json_decode($result,true);
	$access_token_url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$data['access_token'];
	return $access_token_url;
}
//通知创业课程报名模板消息
function sendTemplateMsg($openid,$name,$title,$address,$dateline,$id) {
	//1、获取access_token
	$access_id=access_token();
	//2、组装数组
   	$array=array(
   		//接收者的openid
   		"touser"=>$openid,
        "template_id"=>"a5nK0Cc22mwAZw5uVhomL_ISTMFQsUuzT70F5zPBJnU",
        "url"=>"http://51xy8.com/tp9_1/index.php/Home/mobile/view.html?id=".$id."&classes_id=2",    
        "data"=>array(
         			"first"=>array (
                       "value"=>"报名审核通过",
                       "color"=>"#173177"
                  	 ),
                   "empName"=>array (
                       "value"=>$name,
                       "color"=>"#173177"
                   ),
                   "class"=>array (
                       "value"=>$title,
                       "color"=>"#173177"
                   ),
                   "time"=>array (
                       "value"=>date('Y-m-d H:i:s',$dateline),
                       "color"=>"#173177"
                   ),
                   "add"=>array (
                       "value"=>$address,
                       "color"=>"#173177"
                   ),
                   "remark"=>array (
                       "value"=>"来时带上笔记本",
                       "color"=>"#173177"
                   ),
           ),
   );
	//3、数组->json格式。
	//var_dump($array);
	$post_json=json_encode($array);
	//4、调用curl
	$res=curlGet($access_id,'post',$post_json);
}