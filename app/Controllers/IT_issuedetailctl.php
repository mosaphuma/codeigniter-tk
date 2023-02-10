<?php

namespace App\Controllers;
use App\Models\IT_issuedetail;
use App\Models\IT_ISSUE;
class IT_issuedetailctl extends BaseController
{
    // it_issue
    protected $request;

    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->session = session();
        $this->auth_model = new Auth;
        $this->it_issued_model = new IT_issuedetail;
        $this->it_issue_model = new IT_issue;
        $this->data = ['session' => $this->session,'request'=>$this->request];
    }

    
    
    public function it_issuedf(){
        $this->data['page_title']="IT_ISSUE";
        $this->data['page'] =  !empty($this->request->getVar('page')) ? $this->request->getVar('page') : 1;
        $this->data['perPage'] =  10;
        if(!empty($this->request->getVar('search'))){
            $search = strtolower($this->request->getVar('search'));
            $this->it_issued_model->where("lower(it_issuedetail.`ISSUECODE`) like '%{$search}%' or lower(it_issuedetail.`ISSUEDATE`) like '%{$search}%' or lower(it_issuedetail.`ISSUEDETAIL`) like '%{$search}%'");
        }
        $this->data['total'] =  $this->it_issued_model->countAllResults();
        if(!empty($this->request->getVar('search'))){
            $search = strtolower($this->request->getVar('search'));
            $this->it_issued_model->where("lower(it_issuedetail.`ISSUECODE`) like '%{$search}%' or lower(it_issuedetail.`ISSUEDATE`) like '%{$search}%'or lower(it_issuedetail.`ISSUEDETAIL`) like '%{$search}%'");
        }
        $this->data['it_issuedf'] = $this->it_issued_model
                                    ->select("it_issuedetail.*,it_issuedetail.ISSUEDETAIL")
                                    ->join('it_issue'," it_issue.ISSUECODE = it_issuedetail.ISSUECODE ",'inner')
                                    ->paginate($this->data['perPage']);
        $this->data['total_res'] = is_array($this->data['it_issuedf'])? count($this->data['it_issuedf']) : 0;
        $this->data['pager'] = $this->it_issued_model->pager;
        return view('pages/it_issuedetail/list', $this->data);
    }

    public function issued_add(){
        $this->data['it_issuef'] = $this->it_issue_model->findAll();
        //$this->data['designations'] = $this->desg_model->findAll();
        if($this->request->getMethod() == 'post'){
            extract($this->request->getPost());
            $udata= [];
            $udata['ISSUECODE'] = $code;
            $udata['ISSUEDATE'] = $issuedate;
            $udata['ISSUEDETAIL'] = $issuedetail;
            $udata['ISSUEFOR'] = $issuefor;
            $udata['ISSUEWHERE'] = $issuewhere;
            $udata['ISSUEHOW'] = $issuehow;
            $udata['ISSUEENDATE'] = $issueendate;
           
            $checkCode = $this->it_issued_model->where('ISSUECODE',$code)->countAllResults();
            //if($checkCode){
            //    $this->session->setFlashdata('error',"ISSUED Code Already Taken.");
           // }else{
                $save = $this->it_issued_model->save($udata);
                if($save){
                    $id = $this->it_issued_model->insertID();
                    $this->session->setFlashdata('main_success',"ISSUED Details has been updated successfully.");
                    return redirect()->to('/IT_issuedetailctl/it_issuedf');
                }else{
                    $this->session->setFlashdata('error',"ISSUE Details has failed to update.");
                }
            }
        //}

        $this->data['page_title']="Add New issue";
        return view('pages/it_issuedetail/add', $this->data);
    }

public function issued_edit($id=''){
    $this->data['it_issuef'] = $this->it_issue_model->findAll();  //pass funtion it_issuef to edit pages
    if(empty($id))
    return redirect()->to('IT_issuedetailctl/it_issuedf');
    if($this->request->getMethod() == 'post'){
        extract($this->request->getPost());
        $udata= [];
        $udata['ISSUECODE'] = $code;  //this is the id of select
        $udata['ISSUEDATE'] = $issuedate;
        $udata['ISSUEDETAIL'] = $name;
        $udata['ISSUEFOR'] = $issuefor;
        $udata['ISSUEWHERE'] = $issuewhere;
        $udata['ISSUEHOW'] = $issuehow;
        $udata['ISSUEENDATE'] = $issueendate;

        $checkCode = $this->it_issued_model->where('ISSUECODE',$code)->where("ID!= '{$id}'")->countAllResults();
        //if($checkCode){
        //    $this->session->setFlashdata('error',"country Code Already Taken.");
        //}else{
            $update = $this->it_issued_model->where('ID',$id)->set($udata)->update();
            if($update){
                $this->session->setFlashdata('success',"Country Details has been updated successfully.");
                return redirect()->to('IT_issuedetailctl/issued_edit/'.$id);
            }else{
                $this->session->setFlashdata('error',"ISSUED Details has failed to update.");
            }
       // }
    }

    $this->data['page_title']="Edit Country";
    $this->data['countrys1'] = $this->it_issued_model->where("ID ='{$id}'")->first();
    return view('pages/it_issuedetail/edit', $this->data);
}

public function issued_delete($id=''){
    if(empty($id)){
            $this->session->setFlashdata('main_error',"Country Deletion failed due to unknown ID.");
            return redirect()->to('IT_issuedetailctl/it_issuedf');
    }
    $delete = $this->it_issued_model->where('ID', $id)->delete();
    if($delete){
        $this->session->setFlashdata('main_success',"Country has been deleted successfully.");
    }else{
        $this->session->setFlashdata('main_error',"Countrys Deletion failed due to unknown ID.");
    }
    return redirect()->to('IT_issuedetailctl/it_issuedf');
}

}
