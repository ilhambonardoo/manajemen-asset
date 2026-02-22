<?php

namespace App\Controllers;

use App\Models\UserModel;

class Users extends BaseController {
	protected $userModel;
	protected $db;

	public function __construct() {
		$this->userModel = new UserModel();
		$this->db = \Config\Database::connect();
	}

	public function index() {
		$users = $this->db
			->table('users')
			->select('users.*, roles.role_name')
			->join('roles', 'roles.id = users.role_id', 'left')
			->get()
			->getResultArray();

		$data = [
			'title' => 'Daftar Pengguna',
			'users' => $users,
		];

		return view('users/index', $data);
	}

	public function create() {
		$roles = $this->db->table('roles')->get()->getResultArray();
		$data = [
			'title' => 'Tambah Pengguna',
			'roles' => $roles,
		];

		return view('users/create', $data);
	}

	public function store() {
		if (
			!$this->validate([
				'username' => 'required|min_length[3]|is_unique[users.username]',
				'email' => 'required|valid_email|is_unique[users.email]',
				'password' => 'required|min_length[8]',
				'confpassword' => 'matches[password]',
			])
		) {
			return redirect()
				->back()
				->withInput()
				->with('errors', $this->validator->getErrors());
		}

		$this->userModel->save([
			'username' => $this->request->getPost('username'),
			'email' => $this->request->getPost('email'),
			'password' => password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT),
			'nama_divisi' => $this->request->getPost('nama_divisi'),
			'jabatan' => $this->request->getPost('jabatan'),
			'role_id' => $this->request->getPost('role_id'),
		]);

		session()->setFlashdata('pesan', 'Pengguna berhasil dibuat!');
		return redirect()->to('admin/users/');
	}

	public function edit($id) {
		$user = $this->userModel->find($id);

		if (!$user) {
			session()->setFlashdata('error', 'Data pengguna tidak ditemukan!');
			return redirect()->to(base_url('admin/users'));
		}

		$roles = $this->db->table('roles')->get()->getResultArray();

		$data = [
			'title' => 'Edit Pengguna',
			'user' => $user,
			'roles' => $roles,
		];

		return view('users/edit', $data);
	}

	public function update($id) {
		$userLama = $this->userModel->find($id);

		$username = $this->request->getPost('username');
		$email = $this->request->getPost('email');
		$password = $this->request->getPost('password');

		$updateData = [
			'nama_divisi' => $this->request->getPost('nama_divisi'),
			'jabatan' => $this->request->getPost('jabatan'),
			'role_id' => $this->request->getPost('role_id'),
		];

		if ($username != $userLama['username']) {
			$updateData['username'] = $username;
		}

		if ($email != $userLama['email']) {
			$updateData['email'] = $email;
		}

		if (!empty($password)) {
			$updateData['password'] = password_hash($password, PASSWORD_DEFAULT);
		}

		$this->userModel->update($id, $updateData);

		session()->setFlashdata('pesan', 'Data pengguna berhasil diperbarui!');
		return redirect()->to(base_url('admin/users'));
	}

	public function delete($id) {
		if ($id == session()->get('user_id')) {
			session()->setFlashdata('error', 'Anda tidak dapat menghapus akun yang sedang Anda gunakan!');
			return redirect()->to(base_url('admin/users'));
		}

		$this->userModel->delete($id);
		session()->setFlashdata('pesan', 'Data pengguna berhasil dihapus!');
		return redirect()->to(base_url('admin/users'));
	}
}
