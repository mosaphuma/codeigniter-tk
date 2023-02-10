<?php

namespace App\Controllers;
use App\Models\I_code;
use App\Models\I_expanse;
use App\Models\IT_pc;
class I_codectl extends BaseController
{
    // it_issue
    protected $request;

    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->session = session();
        $this->auth_model = new Auth;
        $this->it_issue_model = new I_code;
        $this->it_issued_model = new I_expanse;
        $this->it_pc_model= new IT_pc;
        $this->data = ['session' => $this->session,'request'=>$this->request];
    }

    
public function i_codef(){
    $this->data['page_title']="IT_ISSUE";
    $this->data['page'] =  !empty($this->request->getVar('page')) ? $this->request->getVar('page') : 1;
    $this->data['perPage'] =  10;
    if(!empty($this->request->getVar('search'))){
        $search = strtolower($this->request->getVar('search'));
        $this->it_issue_model->where("lower(i_code.`ICODE`) like '%{$search}%' or lower(i_code.`IDESC`) like '%{$search}%'");
    }
    $this->data['total'] =  $this->it_issue_model->countAllResults();
    if(!empty($this->request->getVar('search'))){
        $search = strtolower($this->request->getVar('search'));
        $this->it_issue_model->where("lower(i_code.`ICODE`) like '%{$search}%' or lower(i_code.`IDESC`) like '%{$search}%'");
    }
    $this->data['i_codef'] = $this->it_issue_model
                                ->select("i_code.*, i_code.ICODE,i_code.IDESC")
                               
                                ->paginate($this->data['perPage']);
    $this->data['total_res'] = is_array($this->data['i_codef'])? count($this->data['i_codef']) : 0;
    $this->data['pager'] = $this->it_issue_model->pager;
    return view('pages/i_code/list', $this->data);
}


public function icode_add(){
    if($this->request->getMethod() == 'post'){
        extract($this->request->getPost());
        $udata= [];
        $udata['ICODE'] = $code;
        $udata['IDESC'] = $name;
        $checkCode = $this->it_issue_model->where('ICODE',$code)->countAllResults();
        if($checkCode){
            $this->session->setFlashdata('error',"Code Already Taken.");
        }else{
            $save = $this->it_issue_model->save($udata);
            if($save){
                $this->session->setFlashdata('main_success',"ISSUE  has been updated successfully.");
                return redirect()->to('I_codectl/i_codef/');
            }else{
                $this->session->setFlashdata('error',"CODE  has failed to update.");
            }
        }
    }

    $this->data['page_title']="Add New CODe";
    return view('pages/i_code/add', $this->data);
}

public function icode_edit($id=''){
    $this->data['i_expansef'] = $this->it_issued_model->findAll();  //pass funtion it_issuef to edit pages

    if(empty($id))
    return redirect()->to('I_codectl/i_codef');
    if($this->request->getMethod() == 'post'){
        extract($this->request->getPost());
        $udata= [];
        $udata['ICODE'] = $code;
        $udata['IDESC'] = $name;

   
$currentRecord = $this->it_issue_model->where('ID', $id)->get()->getRowArray();
$currentValue = $currentRecord['ICODE'];
if ($currentValue != $code) {
$relatedRecords = $this->it_issued_model->where('ICODE', $currentValue)->countAllResults();

//$relatedRecords = $this->it_issued_model->where('ISSUECODE', $code)->countAllResults();
if ($relatedRecords) {
    $this->session->setFlashdata('error', "Record cannot be updated because it is related to other records in the related_model table.");
    }  else {
    //$update = $this->it_issue_model->where('id', $id)->set($udata)->update();
    $checkCode = $this->it_issue_model->where('ICODE',$code)->where("ID!= '{$id}'")->countAllResults();
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
    return view('pages/i_code/edit', $this->data);
}

public function icode_delete($id=''){
    
    if(empty($id)){
            $this->session->setFlashdata('main_error',"ISSUE  Deletion failed due to unknown ID.");
            return redirect()->to('I_codectl/i_codef');
        }
    

$currentRecord = $this->it_issue_model->where('ID', $id)->get()->getRowArray();
$currentValue = $currentRecord['ICODE'];
//if ($currentValue != $code) {
    $relatedRecords = $this->it_issued_model->where('ICODE', $currentValue)->countAllResults();

//$relatedRecords = $this->it_issued_model->where('ISSUECODE', $code)->countAllResults();
if ($relatedRecords > 0) {
    $this->session->setFlashdata('error', "Record cannot be delete because it is related to other records in the related_model table.");
    return redirect()->to('I_codectl/i_codef');    
} 
    else{

    $delete = $this->it_issue_model->where('ID', $id)->delete();
    if($delete){
        $this->session->setFlashdata('main_success',"issue  has been deleted successfully.");
    }else{
        $this->session->setFlashdata('main_error',"issue Deletion failed due to unknown ID.");
    }
    return redirect()->to('I_codectl/i_codef');
}

}
}

