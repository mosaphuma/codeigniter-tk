<?php

namespace App\Controllers;
use App\Models\IT_issue;
use App\Models\IT_issuedetail;
use App\Models\IT_pc;
class IT_issuectl extends BaseController
{
    // it_issue
    protected $request;

    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->session = session();
        $this->auth_model = new Auth;
        $this->it_issue_model = new IT_issue;
        $this->it_issued_model = new IT_issuedetail;
        $this->it_pc_model= new IT_pc;
        $this->data = ['session' => $this->session,'request'=>$this->request];
    }

    
public function it_issuef(){
    $this->data['page_title']="IT_ISSUE";
    $this->data['page'] =  !empty($this->request->getVar('page')) ? $this->request->getVar('page') : 1;
    $this->data['perPage'] =  10;
    if(!empty($this->request->getVar('search'))){
        $search = strtolower($this->request->getVar('search'));
        $this->it_issue_model->where("lower(it_issue.`ISSUECODE`) like '%{$search}%' or lower(it_issue.`ISSUEDESC`) like '%{$search}%'");
    }
    $this->data['total'] =  $this->it_issue_model->countAllResults();
    if(!empty($this->request->getVar('search'))){
        $search = strtolower($this->request->getVar('search'));
        $this->it_issue_model->where("lower(it_issue.`ISSUECODE`) like '%{$search}%' or lower(it_issue.`ISSUEDESC`) like '%{$search}%'");
    }
    $this->data['it_issuef'] = $this->it_issue_model
                                ->select("it_issue.*, it_issue.ISSUECODE,it_issue.ISSUEDESC")
                               
                                ->paginate($this->data['perPage']);
    $this->data['total_res'] = is_array($this->data['it_issuef'])? count($this->data['it_issuef']) : 0;
    $this->data['pager'] = $this->it_issue_model->pager;
    return view('pages/it_issue/list', $this->data);
}


public function issue_add(){
    if($this->request->getMethod() == 'post'){
        extract($this->request->getPost());
        $udata= [];
        $udata['ISSUECODE'] = $code;
        $udata['ISSUEDESC'] = $name;
        $checkCode = $this->it_issue_model->where('ISSUECODE',$code)->countAllResults();
        if($checkCode){
            $this->session->setFlashdata('error',"ISSUE Code Already Taken.");
        }else{
            $save = $this->it_issue_model->save($udata);
            if($save){
                $this->session->setFlashdata('main_success',"ISSUE  has been updated successfully.");
                return redirect()->to('IT_issuectl/it_issuef/');
            }else{
                $this->session->setFlashdata('error',"ISSUE  has failed to update.");
            }
        }
    }

    $this->data['page_title']="Add New Issue";
    return view('pages/it_issue/add', $this->data);
}

public function issue_edit($id=''){
    $this->data['it_issuedf'] = $this->it_issued_model->findAll();  //pass funtion it_issuef to edit pages

    if(empty($id))
    return redirect()->to('IT_issuectl/it_issuef');
    if($this->request->getMethod() == 'post'){
        extract($this->request->getPost());
        $udata= [];
        $udata['ISSUECODE'] = $code;
        $udata['ISSUEDESC'] = $name;

   
$currentRecord = $this->it_issue_model->where('id', $id)->get()->getRowArray();
$currentValue = $currentRecord['ISSUECODE'];
if ($currentValue != $code) {
$relatedRecords = $this->it_issued_model->where('ISSUECODE', $currentValue)->countAllResults();

//$relatedRecords = $this->it_issued_model->where('ISSUECODE', $code)->countAllResults();
if ($relatedRecords) {
    $this->session->setFlashdata('error', "Record cannot be updated because it is related to other records in the related_model table.");
    } else{
    $relatedRecords2 = $this->it_pc_model->where('ISSUECODE', $currentValue)->countAllResults();
    if($relatedRecords2){
    $this->session->setFlashdata('error',"Record cannot be update beacuse it is relate to to other records.");

    } else {
    //$update = $this->it_issue_model->where('id', $id)->set($udata)->update();
    $checkCode = $this->it_issue_model->where('ISSUECODE',$code)->where("ID!= '{$id}'")->countAllResults();
    if($checkCode){
        $this->session->setFlashdata('error',"Issue Code Already Taken.");
    }else{
        $update = $this->it_issue_model->where('ID',$id)->set($udata)->update();  
    if ($update) {
        $this->session->setFlashdata('success', "Record has been updated successfully.");
    } else {
        $this->session->setFlashdata('error', "Record update failed.");
    }
}
}
}
}
}
/*
//for related record in table it_pc
if ($relatedRecords2) {
    $this->session->setFlashdata('error', "Record cannot be updated because it is related to other records in the related_model table.");
} else {
    //$update = $this->it_issue_model->where('id', $id)->set($udata)->update();
    $checkCode = $this->it_issue_model->where('ISSUECODE',$code)->where("ID!= '{$id}'")->countAllResults();
    if($checkCode){
        $this->session->setFlashdata('error',"Issue Code Already Taken.");
    }else{
        $update = $this->it_issue_model->where('ID',$id)->set($udata)->update();  
    if ($update) {
        $this->session->setFlashdata('success', "Record has been updated successfully.");
    } else {
        $this->session->setFlashdata('error', "Record update failed.");
    }
}
}
*/

/*

        $checkCode = $this->it_issue_model->where('ISSUECODE',$code)->where("ID!= '{$id}'")->countAllResults();
        if($checkCode){
            $this->session->setFlashdata('error',"Issue Code Already Taken.");
        }else{
            $update = $this->it_issue_model->where('ID',$id)->set($udata)->update();
            if($update){
                $this->session->setFlashdata('success',"ISSUE Details has been updated successfully.");
                return redirect()->to('IT_issuectl/issue_edit/'.$id);
            }else{
                $this->session->setFlashdata('error',"ISSUE Details has failed to update.");
            }
       
        }
    */
   

    $this->data['page_title']="Edit Country";
    $this->data['countrys1'] = $this->it_issue_model->where("id ='{$id}'")->first();
    return view('pages/it_issue/edit', $this->data);
}

public function issue_delete($id=''){
    
    if(empty($id)){
            $this->session->setFlashdata('main_error',"ISSUE  Deletion failed due to unknown ID.");
            return redirect()->to('IT_issuectl/it_issuef');
        }
    

$currentRecord = $this->it_issue_model->where('ID', $id)->get()->getRowArray();
$currentValue = $currentRecord['ISSUECODE'];
//if ($currentValue != $code) {
    $relatedRecords = $this->it_issued_model->where('ISSUECODE', $currentValue)->countAllResults();

//$relatedRecords = $this->it_issued_model->where('ISSUECODE', $code)->countAllResults();
if ($relatedRecords > 0) {
    $this->session->setFlashdata('error', "Record cannot be delete because it is related to other records in the related_model table.");
    return redirect()->to('IT_issuectl/it_issuef');    
} else{
    $relatedRecords2 = $this->it_pc_model->where('ISSUECODE', $currentValue)->countAllResults();
    if($relatedRecords2 > 0 ){
    $this->session->setFlashdata('error',"Record cannot be delete  beacuse it is relate to to other records.");
    return redirect()->to('IT_issuectl/it_issuef');    
    
}
    else{

    $delete = $this->it_issue_model->where('ID', $id)->delete();
    if($delete){
        $this->session->setFlashdata('main_success',"issue  has been deleted successfully.");
    }else{
        $this->session->setFlashdata('main_error',"issue Deletion failed due to unknown ID.");
    }
    return redirect()->to('IT_issuectl/it_issuef');
}
}
}
}

