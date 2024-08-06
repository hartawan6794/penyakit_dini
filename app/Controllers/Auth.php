<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends Controller
{

    public function index()
    {
        return view('login');
    }
    public function login()
    {
        $response = [];


        if ($this->request->getMethod() == 'POST') {
            // Validasi input
            $rules = [
                'username' => 'required|min_length[3]|max_length[50]',
                'password' => 'required|min_length[6]|max_length[255]'
            ];


            if (!$this->validate($rules)) {
                $response['status'] = 'error';
                $response['messages'] = $this->validator->getErrors();
            } else {
                $model = new UserModel();
                $username = $this->request->getVar('username');
                $password = $this->request->getVar('password');

                $user = $model->where('username', $username)->first();

                if ($user && password_verify($password, $user->password)) {

                    if ($user->status == 9) {

                        $response['status'] = 'error';
                        $response['messages'] = 'User anda tidak aktif';
                    } else {

                        $this->setSession($user);

                        // Jika "Remember Me" dicentang, buat cookie
                        if ($this->request->getPost('remember_me')) {
                            $this->createRememberMeToken($user->id_user);
                        }

                        $response['status'] = 'success';
                    }
                } else {
                    $response['status'] = 'error';
                    $response['messages'] = 'Username atau Password salah';
                }
            }
        }

        return $this->response->setJSON($response);
    }

    private function createRememberMeToken($userId)
    {
        $token = bin2hex(random_bytes(16));
        $cookie = [
            'name'   => 'remember_me',
            'value'  => $token,
            'expire' => 3600 * 24 * 30, // 30 hari
            'path'   => '/',
        ];

        $this->response->setCookie($cookie);

        // var_dump($token);die;
        $userModel = new UserModel();
        $userModel->update($userId, ['remember_token' => $token]);
    }
    private function setSession($user)
    {
        // Simpan session user
        session()->set([
            'user_id' => $user->id_user,
            'username' => $user->username,
            'nama' => $user->nama,
            'id_role' => $user->id_role,
            'img_user' => $user->img_user,
            'logged_in' => true
        ]);
        return true;
    }

    public function logout()
    {
        $session = session();
        $data['message'] = 'Anda berhasil logout';
        $session->destroy();
        // Redirect ke halaman awal
        return view('login', $data);
    }
}
