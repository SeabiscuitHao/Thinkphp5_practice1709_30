<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use app\admin\model\Admin as AdminModel;
class Admin extends Controller
{
	public function admin()
	{	
		return $this -> fetch();
	}


	public function add()
	{
		if (request() -> isPost()) {
			$data=[
				'username' => input('username'),
				'password' => input('password'),
			];
			$validate = \think\Loader::validate('Admin');
			if (!$validate -> scene('add') -> check($data)) {
				$this -> error($validate -> getError());
				die;
			}
			if (Db::name('admin')->insert($data)) {
				return $this -> success('添加管理员成功','lst');
			}else{
				return $this -> error('添加管理员失败');
			}
			return;
		}
		return $this -> fetch();
	}




	public function lst()
	{	
		$list = AdminModel::paginate(3);
		$this -> assign('list',$list);
		return $this -> fetch();
	}


	public function edit()
	{	
		$id = input('id');
		$admins = db('admin') -> find($id);
		if (request() -> isPost()) {
			$data = [
				'username' => input('username'),
				'id' => input('id'),
			];
			if (input('password')) {
				$data['password'] = input('password');
			}else{
				$data['password'] = $admins('password');
			}
			$validate = \think\Loader::validate('Admin');
			if (!$validate -> scene('edit') -> check($data)) {
				$this -> error($validate -> getError());
				die;
			}
			if (Db::name('admin') -> update($data)) {
				return $this -> success('修改管理员信息成功！','lst');
			}else{
				return $this -> error('修改管理员信息失败！');
			}
		}
        $this -> assign('admins',$admins);
		return $this -> fetch();
	}

 
	public function del()
	{
		$id = input('id');
		if ($id != 1) {
			if (Db::name('admin') -> delete(input('id'))) {
				return $this -> success('删除管理员成功！','lst');
			}else{
				return $this -> error('删除管理员失败！');
			}
		}else{
			return $this -> error('初始化管理员不能删除！');
		}
	}
}