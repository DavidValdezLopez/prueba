<?php if ( ! defined('BASEPATH')) exit('No se permite el acceso directo al script');
class Login extends CI_Controller{

	public function __construct(){
        parent::__construct();

        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('blog_model');
        }
    //Se carga la vista login_view
	function login_view(){
		$this->load->view('login_view');
	}

	// se hace el check del tipo de usuario que se esta logeando user, admin, suadmin
	function login_check(){


		$this->form_validation->set_rules('user', 'user', 'required');
		$this->form_validation->set_rules('pass', 'pass', 'required');


		if($this->form_validation->run()==True){
			$user = htmlspecialchars($this->input->post('user'));
			$pass = htmlspecialchars($this->input->post('pass'));



			$data = $this->blog_model->logeous($user);		

			if($data){
				if ($this->bcrypt->check_password($pass, $data->pass))
				{
				    $user_data = array(
					'user' => $data->user,
					'name'=>$data->name,
					'type_user' => $data->type_user,
					'login' => true,
					'bann'=> $data->bann
					);
            	$this->session->set_userdata($user_data);
		         $this->session->set_flashdata('bien','Bienvenido.'.$user_data['name']); 

            	echo "<script language='javascript'> parent.location.reload(); </script>";

				}else{
		         	$this->session->set_flashdata('passfail','Contraseña equivocada'); 
 					redirect('login/login_view');


				}
					            	
            	//redirect('blog');
			}else{
		         $this->session->set_flashdata('usfail','Usuario incorrecto'); 
				redirect('login/login_view');
			
			}
		}else{
	         $this->session->set_flashdata('usfo','Completa los campos'); 
			redirect('login/login_view');

		}



		
		

	}
}