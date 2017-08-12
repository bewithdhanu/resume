<?php

class Settemplate
{

    public function dashboard($content, $data = array("page_title"=>""),$boolean=FALSE)
    {
        $ci = &get_instance();
        //$ci->load->view("header", $data,$boolean);
        $ci->load->view($content, $data,$boolean);
        //$ci->load->view("footer", $data,$boolean);
    }
    public function user($content, $data = array("page_title"=>""),$boolean=FALSE)
    {
        $ci = &get_instance();
        $ci->load->view("user/header", $data,$boolean);
        $ci->load->view("user/".$content, $data,$boolean);
        $ci->load->view("user/footer", $data,$boolean);
    }
    public function mail($content, $data = array("page_title"=>""),$boolean=FALSE)
    {
        $ci = &get_instance();
        //$ci->load->view("mails/header", $data,$boolean);
        $ci->load->view("mails/".$content, $data,$boolean);
        //$ci->load->view("mails/footer", $data,$boolean);
    }
}

?>