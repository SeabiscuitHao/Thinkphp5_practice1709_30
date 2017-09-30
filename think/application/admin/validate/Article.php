<?php
namespace app\admin\validate;
use think\Db;
use think\Validate;
class Article extends Validate
{
	// protected $rule = [
 //      'title' => 'require|max:25',
 //      'url' => 'require'
	//  	];
 // 	protected $message = [
 //      'title.require' => '链接名称必须填写',	
 //      'title.max' => '链接长度不能超过25',
 //      'url.require' => '链接地址必须填写',
	//  	];
	// protected $scene = [
 //      'add' => ['title','url'],//指定场景条件：'add' => ['title' => 'require','password'],
 //      'edit' => ['title','url'],
	// 	];
}