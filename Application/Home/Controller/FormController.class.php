<?php
namespace Home\Controller;
use Think\Controller;
class FormController extends Controller{
    public function insert(){
        $Form   =   D('Form');
        if($Form->create()) {
            $result =   $Form->add();
            if($result) {
                $this->success('数据添加成功！');
            }else{
                $this->error('数据添加错误！');
            }
        }else{
            $this->error($Form->getError());
        }
    }
    public function read($id=1){
    	$form = M('Form');
    	$data = $form->where("id=$id")->getField('create_time');
    	if($data){
    		$this->assign('data',$data);
    	}else{
    		$this->error('数据错误');
    	}
    	$this->display();
    }
    public function edit($id=1){
    	$form = M('form');
    	$this->assign('vo',$form->find($id));
    	$this->display();
    }
    public function update(){
    	$form = M('form');
    	if($form->create()){
    		$result = $form->save();
    		if($result){
    			$this->success('数据更新成功');
    		}else{
    			$this->error('数据更新失败');
    		}
    	}else{
    		$this->error($form->getError());
    	}
    }
    public function dete($id=0){
    	$form = M('form');
    	$form->delete($id);
    	$this->success('删除成功');
    	//$this->display();
    	//$form->where('id=$id')->detele();
    }
 }