<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once FCPATH . 'vendor/autoload.php';

/**
 * @property CI_Input $input
 * @property CI_Session $session
 * @property User_model $User_model
 */
class Login extends CI_Controller
{
    private \Google_Client $googleClient;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library(['session']);
        $this->load->helper(['form', 'url']);

        $this->googleClient = new \Google_Client();
        $this->googleClient->setClientId('240737528000-12u8bpcus6v5fbo5258dfole60v5ij7s.apps.googleusercontent.com');
        $this->googleClient->setClientSecret('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');
        $this->googleClient->setRedirectUri(base_url('login/google_callback'));
        $this->googleClient->addScope('email');
        $this->googleClient->addScope('profile');
        $this->googleClient->setPrompt('select_account consent');
    }

    public function index()
    {
        $this->load->view('login', ['title' => 'Login Page']);
    }

    public function authenticate()
    {
        $email = $this->input->post('email', true);
        $password = $this->input->post('password', true);
        $user = $this->User_model->get_user_by_email($email);

        if ($user && password_verify($password, $user->password)) {
            $this->set_user_session($user);
            $this->session->set_flashdata('toastr_success', 'Login successful!');
            redirect('dashboard/user');
        } else {
            $this->session->set_flashdata('error', 'Invalid email or password');
            redirect('login');
        }
    }

    public function google_login()
    {
        redirect($this->googleClient->createAuthUrl());
    }

    public function google_callback()
    {
        $code = $this->input->get('code', true);

        if ($code) {
            $token = $this->googleClient->fetchAccessTokenWithAuthCode($code);

            if (!isset($token['error'])) {
                $this->googleClient->setAccessToken($token);
                $oauth = new \Google_Service_Oauth2($this->googleClient);
                $userData = $oauth->userinfo->get();

                $user = $this->User_model->get_user_by_email($userData->email);
                if (!$user) {
                    $insertData = [
                        'name' => $userData->name,
                        'email' => $userData->email,
                        'password' => password_hash(uniqid(), PASSWORD_BCRYPT)
                    ];
                    $user_id = $this->User_model->insert_user($insertData);
                    $user = $this->User_model->get_user_by_id($user_id);
                }

                $this->set_user_session($user);
                redirect('dashboard/user');
            }
        }

        $this->session->set_flashdata('error', 'Google login failed!');
        redirect('login');
    }

    public function truecaller_login()
    {
        $partnerKey = ''; 
        $redirectUri = urlencode('https://reprint-incl-amplifier-themselves.trycloudflare.com/login/truecaller_callback');
        $requestNonce = bin2hex(random_bytes(16));

        $truecallerUrl = "https://api.truecaller.com/v1/verify?partnerKey={$partnerKey}&requestNonce={$requestNonce}&redirectUri={$redirectUri}";
        redirect($truecallerUrl);
    }

    public function truecaller_callback()
    {
        $response = $this->input->get(null, true); 

        $phone = $response['phoneNumber'] ?? null;

        if ($phone) {
            $user = $this->User_model->get_user_by_phone($phone);

            if (!$user) {
                $insertData = [
                    'name' => $response['firstName'] ?? 'Unknown',
                    'email' => $response['email'] ?? null,
                    'contact_number' => $phone,
                    'password' => password_hash(uniqid(), PASSWORD_BCRYPT)
                ];
                $user_id = $this->User_model->insert_user($insertData);
                $user = $this->User_model->get_user_by_id($user_id);
            }

            $this->set_user_session($user);
            redirect('dashboard/user');
        } else {
            $this->session->set_flashdata('error', 'Truecaller login failed!');
            redirect('login');
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }

    private function set_user_session($user)
    {
        $this->session->set_userdata([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'user_phone' => $user->contact_number ?? null
        ]);
    }
}
