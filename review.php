<?php
ini_set('display_errors', '1');
class Review extends CI_Controller
{
    
    function __construct(){
	parent::__construct();
	$this->load->model('reviewmodel');
        //$this->load->library();
    }
    function index($ID = FALSE){
        $counter = 0;
        $temp = array();
        $temp['display'] = true; //display the link for individual titles
        if($ID){
            
            $temp['display'] = false; //donot display the link for individual titles
            $temp['content'] = $this->reviewmodel->get_contents($ID);
        }else {
            //$temp['display'] = false;
            $temp['content'] = $this->reviewmodel->get_contents(); //this for view
        }
        $store = $this->reviewmodel->get_contents(); //this is for to get users review
        $data = array(); 
        $tempo = array();
        //foreach ($store as $row){ //loop for getting related reviews with title
            $temp['reviews'] = $this->reviewmodel->get_reviews();
            //$tempa = mysql_result($tempo, 0, "author");
            $counter++;
        //}
        
//        foreach ($store as $row){
//            $data[] = $row['content_id'];
////            if ($row['image'] == null){
////                echo "damn";
////            }
//        }
       
        $temp['counter'] = $counter;
        //$temp['content_id'] = $data;
        
        $temp['images'] = $this->reviewmodel->getImages();
        
        
        
        //$store1 = $this->reviewmodel->get_reviews($data[0],$data[1]);
        $this->load->view('home1', $temp);
        //$this->load->view('home');
        
    }
//    function displayimage($id = FALSE){ 
//        
//        if ($id) {
//            $image = $this->reviewmodel->getImage($id);
////            header("Content-type: image/jpeg");
//            echo $image;
//        }   
//    } 
//    
    function login(){
        $this->load->helper(array('form'));
        $this->load->view('admin_login');
    }


//    function admin(){
//        $this->load->view('uploader');
//    }
    
    function uploadIt(){
        
        if ($this->input->post('upload')){
            $this->reviewmodel->do_upload();
        }
//        $title = $this->input->post('title');
//        if ($this->input->post('upload')){
//            $this->reviewmodel->do_upload($title); 
//            //$this->load->view('welcome');
//        }
        //$this->load->view('uploader');
        redirect('index.php/sessioncreate', 'refresh');
      
        
    }
    
    function reviewupload($x) {
        $this->reviewmodel->do_review_upload();
        
        redirect('index.php/review/index/'.$x, 'refresh');
        
    }

    function detail_reviews($content_id){
        $result['data'] = $this->reviewmodel->singleContentReviews($content_id);
        
        $this->load->view('reviewdetail', $result);
    }
    
}
