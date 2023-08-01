<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Models\User;

class AuthController extends BaseController
{
    public function login()
    {
        helper(['form']);
        session()->setFlashdata('target_url', session()->getFlashdata('target_url'));
        return view('frontend/auth/login');
    }

    public function register()
    {
        helper(['form']);
        return view('frontend/auth/register');
    }

    public function postLogin(){
        helper(['form']);
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $target_url = $this->request->getPost('target_url');
        $userModel = new User();
        $session = session();


        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required|min_length[6]',
        ];

        if(!$this->validate($rules)){
            $session->setFlashdata('error', $this->validator->listErrors());
            return redirect()->to(base_url('/'))->withInput();
        }

        $user = $userModel->where('email', $email)->first();

        if($user){
            if(password_verify($password, $user['password'])){
                $session->set('auth', $user);
                return redirect()->to(base_url($target_url));
            }else{
                $session->setFlashdata('error', 'Password invalid');
                return redirect()->to(base_url('/'))->withInput();
            }
        }else{
            $session->setFlashdata('error', 'Email invalid');
            return redirect()->to(base_url('/'))->withInput();
        }
    }

    public function postRegister(){
        helper(['form']);
        $name = $this->request->getPost('name');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $password_confirmation = $this->request->getPost('password_confirmation');
        $userModel = new User();
        $session = session();

        $rules = [
            'name' => 'required',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]',
            'password_confirmation' => 'required|min_length[8]',
        ];

        if(!$this->validate($rules)){
            $session->setFlashdata('error', $this->validator->listErrors());
            return redirect()->to(base_url('register'))->withInput();
        }

            if($password == $password_confirmation){
                $userModel->insert([
                    'name' => $name,
                    'email' => $email,
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
                $session->setFlashdata('success', 'Register success');
                $user = $userModel->where('email', $email)->first();
                $session->set('auth', $user);
                return redirect()->to(base_url('/manage-url'));
            }else{
                $session->setFlashdata('error', 'Password confirmation invalid');
                return redirect()->to(base_url('/register'));
            }
    }

    public function logout(){
        $session = session();
        $session->destroy();
        return redirect()->to(base_url('/'));
    }
}
