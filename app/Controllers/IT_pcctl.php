<?php

namespace App\Controllers;
use App\Models\IT_pc;
use App\Models\IT_issue;
class IT_pcctl extends BaseController
{
    // it_PC
    protected $request;

    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->session = session();
        $this->auth_model = new Auth;
        $this->it_pc_model = new IT_pc;
        $this->it_issue_model = new IT_issue;
        $this->data = ['session' => $this->session,'request'=>$this->request];
    }


public function it_pcf(){
    $this->data['page_title']="IT_PC";
    $this->data['page'] =  !empty($this->request->getVar('page')) ? $this->request->getVar('page') : 1;
    $this->data['perPage'] =  10;
    if(!empty($this->request->getVar('search'))){
        $search = strtolower($this->request->getVar('search'));
        $this->it_pc_model->where("lower(it_pc.`PCCODE`) like '%{$search}%' or lower(it_pc.`PCIP`) like '%{$search}%'");
    }
    $this->data['total'] =  $this->it_pc_model->countAllResults();
    if(!empty($this->request->getVar('search'))){
        $search = strtolower($this->request->getVar('search'));
        $this->it_pc_model->where("lower(it_pc.`PCCODE`) like '%{$search}%' or lower(it_pc.`PCIP`) like '%{$search}%'");
    }
    $this->data['it_pcf'] = $this->it_pc_model
                                ->select("it_pc.*, it_pc.PCCODE,it_pc.PCIP")
                                ->join('it_issue'," it_issue.ISSUECODE = it_pc.ISSUECODE ",'inner')
                                ->paginate($this->data['perPage']);
    $this->data['total_res'] = is_array($this->data['it_pcf'])? count($this->data['it_pcf']) : 0;
    $this->data['pager'] = $this->it_pc_model->pager;
    return view('pages/it_pc/list', $this->data);
}


public function pc_add(){
    $this->data['it_issuef'] = $this->it_issue_model->findAll();
    if($this->request->getMethod() == 'post'){
        extract($this->request->getPost());
        $udata= [];
        $udata['ISSUECODE']=$issuecode;
        $udata['PCCODE'] = $code;
        $udata['PCIP'] = $name;
       // $checkCode = $this->it_pc_model->where('PCCODE',$code)->countAllResults();
        //if($checkCode){
         //   $this->session->setFlashdata('error',"PC Code Already Taken.");
        //}else{
            $save = $this->it_pc_model->save($udata);
            if($save){
                $this->session->setFlashdata('main_success',"PC Details has been updated successfully.");
                return redirect()->to('IT_pcctl/it_pcf/');
            }else{
                $this->session->setFlashdata('error',"PC Details has failed to update.");
            }
        //}
    }

    $this->data['page_title']="Add New PC";
    return view('pages/it_pc/add', $this->data);
}
public function pc_edit($id=''){
    $this->data['it_issuef'] = $this->it_issue_model->findAll();  //pass funtion it_issuef to edit pages

    if(empty($id))
    return redirect()->to('IT_pcctl/it_pcf');
    if($this->request->getMethod() == 'post'){
        extract($this->request->getPost());
        $udata= [];
        $udata['ISSUECODE']=$issuecode;
        $udata['PCCODE'] = $code;
        $udata['PCIP'] = $name;

      //  $checkCode = $this->it_pc_model->where('PCCODE',$code)->where("ID!= '{$id}'")->countAllResults();
        //if($checkCode){
        //    $this->session->setFlashdata('error',"PC Code Already Taken.");
        //}else{
            $update = $this->it_pc_model->where('ID',$id)->set($udata)->update();
            if($update){
                $this->session->setFlashdata('success',"PC Details has been updated successfully.");
                return redirect()->to('IT_pcctl/pc_edit/'.$id);
            }else{
                $this->session->setFlashdata('error',"pc Details has failed to update.");
            }
        //}
    }

    $this->data['page_title']="Edit PC";
    $this->data['countrys1'] = $this->it_pc_model->where("ID ='{$id}'")->first();
    return view('pages/it_pc/edit', $this->data);
}

public function pc_delete($id=''){
    if(empty($id)){
            $this->session->setFlashdata('main_error',"ISSUE  Deletion failed due to unknown ID.");
            return redirect()->to('IT_issuectl/it_issuef');
    }
    $delete = $this->it_pc_model->where('ID', $id)->delete();
    if($delete){
        $this->session->setFlashdata('main_success',"Country has been deleted successfully.");
    }else{
        $this->session->setFlashdata('main_error',"Countrys Deletion failed due to unknown ID.");
    }
    return redirect()->to('IT_pctl/it_pcf');
}
}
