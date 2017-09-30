<?php
namespace app\Admin\controller;
use think\Controller;
use think\Db;
use app\admin\model\Article as ArticleModel;
class Article extends Controller
{
	public function Article()
	{	
		return $this -> fetch();
	}



	public function add()
	{
		if (request() -> isPost()) {
			$data=[
				'id' => input('id'),
				'title' => input('title'),
				'author' => input('author'),
				'keywords' => input('keywords'),
				'content' => input('content'),
				'pic' => input('pic'),
				'state' => input('state'),
				'cateid' => input('cateid'),
			];
			$validate = \think\Loader::validate('Article');
			if (!$validate -> scene('add') -> check($data)) {
				$this -> error($validate -> getError());
				die;
			}
			if (Db::name('Article')->insert($data)) {
				return $this -> success('添加文章成功','lst');
			}else{
				return $this -> error('添加文章失败');
			}
			return;
		}
		return $this -> fetch();
	}




	public function lst()
	{	
		$list = ArticleModel::paginate(3);
		$this -> assign('list',$list);
		return $this -> fetch();
	}


	public function edit()
	{	
		$id = input('id');
		$Articles = db('Article') -> find($id);
		if (request() -> isPost()) {
			$data = [
				'title' => input('title'),
				'author' => input('author'),
				'keywords' => input('keywords'),
				'content' => input('content'),
				'pic' => input('pic'),
				'state' => input('state'),
				'cateid' => input('cateid'),
				'desc' => input('desc'),
			];

			$validate = \think\Loader::validate('Article');
			if (!$validate -> scene('edit') -> check($data)) {
				$this -> error($validate -> getError());
				die;
			}
			if (Db::name('Article') -> update($data)) {
				return $this -> success('修改文章信息成功！','lst');
			}else{
				return $this -> error('修改文章信息失败！');
			}
		}
        $this -> assign('Articles',$Articles);
		return $this -> fetch();
	}

 
	public function del()
	{
		$id = input('id');
		if ($id != 1) {
			if (Db::name('Article') -> delete(input('id'))) {
				return $this -> success('删除文章成功！','lst');
			}else{
				return $this -> error('删除文章失败！');
			}
		}else{
			return $this -> error('初始化文章不能删除！');
		}
	}
}