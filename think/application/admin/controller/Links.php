<?php
namespace app\Admin\controller;
use think\Controller;
use think\Db;
use app\admin\model\Links as LinksModel;
class Links extends Controller
{
	public function Links()
	{	
		return $this -> fetch();
	}



	public function add()
	{
		if (request() -> isPost()) {
			$data=[
				'title' => input('title'),
				'url' => input('url'),
			];
			$validate = \think\Loader::validate('Links');
			if (!$validate -> scene('add') -> check($data)) {
				$this -> error($validate -> getError());
				die;
			}
			if (Db::name('Links')->insert($data)) {
				return $this -> success('添加链接成功','lst');
			}else{
				return $this -> error('添加链接失败');
			}
			return;
		}
		return $this -> fetch();
	}




	public function lst()
	{	
		$list = LinksModel::paginate(3);
		$this -> assign('list',$list);
		return $this -> fetch();
	}


	public function edit()
	{	
		$id = input('id');
		$linkss = db('Links') -> find($id);
		if (request() -> isPost()) {
			$data = [
				'title' => input('title'),
				'id' => input('id'),
				'url' => input('url'),
				'desc' => input('desc'),
			];

			$validate = \think\Loader::validate('Links');
			if (!$validate -> scene('edit') -> check($data)) {
				$this -> error($validate -> getError());
				die;
			}
			if (Db::name('Links') -> update($data)) {
				return $this -> success('修改链接信息成功！','lst');
			}else{
				return $this -> error('修改链接信息失败！');
			}
		}
        $this -> assign('linkss',$linkss);
		return $this -> fetch();
	}

 
	public function del()
	{
		$id = input('id');
		if ($id != 1) {
			if (Db::name('Links') -> delete(input('id'))) {
				return $this -> success('删除链接成功！','lst');
			}else{
				return $this -> error('删除链接失败！');
			}
		}else{
			return $this -> error('初始化链接不能删除！');
		}
	}
}