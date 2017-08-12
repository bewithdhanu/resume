<?php

class User_model extends CI_Model {

    function login($email,$password){
        $res=$this->db->where(array("email"=>$email))->where_in("status",array('A','Y'))->get("tbl_users");
        if($res->num_rows()>0){
            foreach($res->result() as $r){
                if($this->encryption->decrypt($r->password)==$password){
                    return $r;
                }else{
                    return false;
                }
            }
        }else{
            return false;
        }
    }
    function register($data){
        if($this->db->insert("tbl_users",$data)){
            $id=$this->db->insert_id();
            return $this->db->where("id",$id)->get("tbl_users")->row();
        }else{
            return false;
        }
    }
    function activate($data){
        $user=$this->db->where("id",$this->db->insert_id())->get("tbl_users")->row();
        if($user->activation_code==$data[1]){
            if($this->db->update("tbl_users",array("status"=>'Y'))->where(array("id"=>$data[0]))){
                return $user;
            }else return false;
        }else return false;
    }
    function is_record_exists($val,$col,$tab){
        if($this->db->where($col,$val)->get($tab)->num_rows()>0){
            return true;
        }else return false;
    }
}