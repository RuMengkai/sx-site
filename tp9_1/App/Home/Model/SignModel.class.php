<?php
/*
 * @thinkphp3.2.2  auth认证   php5.3以上
 * @Created on 2015/08/18
 *
 */

namespace Home\Model;
use Think\Model\RelationModel;

class SignModel extends RelationModel {
	
	protected $tableName='sign_list';
	
	protected $_link = array(
     	'Sign_user'  =>  array(
			'mapping_type' => self::BELONGS_TO,
			'foreign_key'=>'zuid',
			'mapping_fields'=>'id,xingming,author',
			'as_fields'=>'id:qid,xingming,author'
		),         
    );
}

