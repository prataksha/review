<?php
ini_set('display_errors', '1');
class Reviewmodel extends CI_Model
{
    var $gallery_path; // for uploading images
    var $gallery_path_url; // for displaying images
    
    function __construct()
    {
        parent::__construct();
	$this->load->database();
        $this->load->helper('path');
        
        $this->gallery_path = set_realpath(APPPATH.'../images');
        $this->gallery_path_url = base_url().'images/';
    }
    
    function get_contents($ID = FALSE) {
        if ($ID){
            //$query = $this->db->get('user');
            //echo $ID;
            $query = $this->db->query('SELECT content_id, title FROM content WHERE content_id =' . $ID );
            return $query->result_array();
//            $cont_id = $query->content_id;
//            $title = $query->title;
//            $image = $query->image;
//            return $cont_id $image $title;
	}else{
            $query = $this->db->query('SELECT content_id, title FROM content ORDER BY content_id DESC');
            return $query->result_array();
        }
    }
    
    function get_reviews() {
        $query = $this->db->query('SELECT content_id, name, review FROM user ORDER BY user_id DESC');
        return $query->result_array();
        //return $query;
    }
    
    function getImages(){
        //$data = '';
//        $Q = $this->db->query('SELECT title FROM content WHERE content_id=' . $Id);
//        
//            $data = $Q->result_array();           // print_r($data);
//            foreach ($data as $value) {
//                echo $value['title'];
//            }
            
        //return $data;
        
        $files = scandir($this->gallery_path);
        $files = array_diff($files, array('.','..'));
        
        $images = array();
        
        foreach ($files as $file){
            $content_id;
            $query = $this->db->query("SELECT content_id FROM content WHERE image_name = '$file'");

            foreach ($query->result() as $row) {
                $content_id = $row->content_id;
            }
            $images [] = array (
                'content_id' => $content_id,
                $content_id => $this->gallery_path_url . $file
            );
        }
        return $images;
    }
    
    function do_upload(){
        $name;
        $config = array(
            'allowed_types' => 'jpg|jpeg|png',
            'upload_path' => $this->gallery_path,
            'max_size' => 2000
        );
        
        $this->load->library('upload', $config);
        //print_r($config); 
        //$this->upload->do_upload();
        //echo $config['upload_path'];
        if (!$this->upload->do_upload()) {
            $error = array('error' => $this->upload->display_errors());
          
            //$this->load->view('uploader', $error);
        }else{
            $s = $this->upload->data();
            //print_r($s);
            $content_title =  $this->input->post('title');
            $image_name = $s['file_name'];
            
            $data = array(
                'title' => $content_title,
                'image_name' => $image_name
            );
            $this->db->insert('content', $data); 
        
        }
    }
    
    function do_review_upload(){
        $content_id = $this->input->post('content_id');
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $text = $this->input->post('text');
        
        
        $data = array(
            'content_id' => $content_id,
            'name' => $name,
            'email' => $email,
            'review' => $text
        );
        
        $this->db->insert('user', $data); 
    }
    
    function login($username, $password) {
        $this->db->select('admin_id, name, password');
        $this->db->from('admin');
        $this->db->where('name', $username);
        $this->db->where('password', MD5($password));
        $this->db->limit(1);

        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }
    
    function singleContentReviews($content_id) {
        //asdf
    }
}