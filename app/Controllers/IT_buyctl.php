<?php

namespace App\Controllers;

use App\Models\IT_ISSUE;
use App\Models\IT_by;

class IT_buyctl extends BaseController
{
    // it_issue
    protected $request;

    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->session = session();
        $this->auth_model = new Auth;
        $this->it_issued_model = new IT_by;
        $this->it_issue_model = new IT_issue;
        $this->data = ['session' => $this->session,'request'=>$this->request];
    }

    
    
    public function it_buyf(){
        $this->data['page_title']="IT_ISSUE";
        $this->data['page'] =  !empty($this->request->getVar('page')) ? $this->request->getVar('page') : 1;
        $this->data['perPage'] =  10;
        if(!empty($this->request->getVar('search'))){
            $search = strtolower($this->request->getVar('search'));
            $this->it_issued_model->where("lower(it_buy.`ISSUECODE`) like '%{$search}%' or lower(it_buy.`BUYDATE`) like '%{$search}%' or lower(it_buy.`BUYDETAIL`) like '%{$search}%'");
        }
        $this->data['total'] =  $this->it_issued_model->countAllResults();
        if(!empty($this->request->getVar('search'))){
            $search = strtolower($this->request->getVar('search'));
            $this->it_issued_model->where("lower(it_buy.`ISSUECODE`) like '%{$search}%' or lower(it_buy.`BUYDATE`) like '%{$search}%' or lower(it_buy.`BUYDETAIL`) like '%{$search}%'");
        }
        $this->data['it_issuedf'] = $this->it_issued_model
                                    ->select("it_buy.*,it_buy.BUYDETAIL")
                                    ->join('it_issue'," it_issue.ISSUECODE = it_buy.ISSUECODE ",'inner')
                                    ->paginate($this->data['perPage']);
        $this->data['total_res'] = is_array($this->data['it_issuedf'])? count($this->data['it_issuedf']) : 0;
        $this->data['pager'] = $this->it_issued_model->pager;
        return view('pages/it_buy/list', $this->data);
    }

    public function buy_add(){
        $this->data['it_issuef'] = $this->it_issue_model->findAll();
        //$this->data['designations'] = $this->desg_model->findAll();
        if($this->request->getMethod() == 'post'){
            extract($this->request->getPost());
            $udata= [];
            $udata['ISSUECODE'] = $code;
            $udata['BUYDATE'] = $issuedate;
            $udata['BUYDETAIL'] = $issuedetail;
            $udata['BUYFOR'] = $issuefor;
            $udata['QTY'] = $issuewhere;
            $udata['UNITPRICE'] = $issuehow;
            $udata['BUYWARENTY'] = $issueendate;
           
            $checkCode = $this->it_issued_model->where('ISSUECODE',$code)->countAllResults();
            if (!is_numeric($issuewhere)) {
                session()->setFlashdata('error', 'QTY field should contain only numbers.');
                //return redirect()->to(base_url('your_form_url'));
                return redirect()->to('IT_buyctl/buy_add/');
              }

              if(!is_numeric($issuehow)){
                session()->setFlashdata('error','Unit Price should contain only numbers');
                return redirect()->to('IT_buyctl/buy_add/');
              }
            //if($checkCode){
            //    $this->session->setFlashdata('error',"ISSUED Code Already Taken.");
           else{
                $save = $this->it_issued_model->save($udata);
                if($save){
                    $id = $this->it_issued_model->insertID();
                    $this->session->setFlashdata('main_success',"BUY Details has been updated successfully.");
                    return redirect()->to('/IT_buyctl/it_buyf');
                }else{
                    $this->session->setFlashdata('error',"ISSUE Details has failed to ADD.");
                }
            }
        
        }

        $this->data['page_title']="Add New BUY";
        return view('pages/it_buy/add', $this->data);
    }

public function buy_edit($id=''){
    $this->data['it_issuef'] = $this->it_issue_model->findAll();  //pass funtion it_issuef to edit pages
    if(empty($id))
    return redirect()->to('IT_buyctl/it_buyf');
    if($this->request->getMethod() == 'post'){
        extract($this->request->getPost());
        $udata= [];
        $udata['ISSUECODE'] = $code;  //this is the id of select
        $udata['BUYDATE'] = $issuedate;
        $udata['BUYDETAIL'] = $name;
        $udata['BUYFOR'] = $issuefor;
        $udata['QTY'] = $issuewhere;
        $udata['UNITPRICE'] = $issuehow;
        $udata['BUYWARENTY'] = $issueendate;


// In your controller method
//$issuewhere = $this->request->getPost('issuewhere');



        $checkCode = $this->it_issued_model->where('ISSUECODE',$code)->where("ID!= '{$id}'")->countAllResults();
        //if($checkCode){
        //    $this->session->setFlashdata('error',"country Code Already Taken.");
        //}else{

            if (!is_numeric($issuewhere)) {
                session()->setFlashdata('error', 'QTY field should contain only numbers.');
                //return redirect()->to(base_url('your_form_url'));
                return redirect()->to('IT_buyctl/buy_edit/'.$id);
              }

              if(!is_numeric($issuehow)){
                session()->setFlashdata('error','Unit Price should contain only numbers');
              }
              else{   
            $update = $this->it_issued_model->where('ID',$id)->set($udata)->update();
            if($update){
                $this->session->setFlashdata('success',"BUY Details has been updated successfully.");
                return redirect()->to('IT_buyctl/buy_edit/'.$id);
            }else{
                $this->session->setFlashdata('error',"BUY Details has failed to update.");
            }
        }
    }


    $this->data['page_title']="Edit Country";
    $this->data['countrys1'] = $this->it_issued_model->where("ID ='{$id}'")->first();
    return view('pages/it_buy/edit', $this->data);
}

public function buy_delete($id=''){
    if(empty($id)){
            $this->session->setFlashdata('main_error',"BuyItem Deletion failed due to unknown ID.");
            return redirect()->to('IT_buyctl/it_buyf');
    }
    $delete = $this->it_issued_model->where('ID', $id)->delete();
    if($delete){
        $this->session->setFlashdata('main_success',"Buy item  has been deleted successfully.");
    }else{
        $this->session->setFlashdata('main_error',"buy item  Deletion failed due to unknown ID.");
    }
    return redirect()->to('IT_buyctl/it_buyf');
}

}
