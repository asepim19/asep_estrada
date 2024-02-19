<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Karyawan extends CI_Controller {
    
    protected $api_base_url = 'http://localhost:3000/';

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
    }

    public function index() {
        try {
            $api_url = $this->api_base_url . "karyawan";
            $response = $this->makeRequest('GET', $api_url);

            if ($response['status'] === 200) {
                $data['karyawan_list'] = json_decode($response['body'], true);
                $this->load->view('karyawan/index', $data);
            } else {
                echo 'Error fetching data.';
            }
        } catch (Exception $e) {
            echo 'Exception: ' . $e->getMessage();
        }
    }

    public function tambah() {
        $this->load->view('karyawan/tambah');
    }

    public function simpan() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = array(
                'nama' => $this->input->post('nama'),
                'alamat' => $this->input->post('alamat'),
                'tgllahir' => $this->input->post('tgllahir'),
                'divisi' => $this->input->post('divisi'),
                'status' => $this->input->post('status'),
            );

            $api_url = $this->api_base_url . 'karyawan';
            $result = $this->sendDataToApi($api_url, $data);

            if ($result) {
                redirect('karyawan');
            } else {
                echo 'Error adding data.';
            }
        } else {
            redirect('karyawan/tambah');
        }
    }

    public function edit($nik) {
        try {
            $api_url = $this->api_base_url . 'karyawan/' . $nik;
            $response = $this->makeRequest('GET', $api_url);

            if ($response['status'] === 200) {
                $data['karyawan'] = json_decode($response['body'], true);
                $this->load->view('karyawan/edit', $data);
            } else {
                echo 'Error fetching data.';
            }
        } catch (Exception $e) {
            echo 'Exception: ' . $e->getMessage();
        }
    }

    public function update($nik) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = array(
                'nama' => $this->input->post('nama'),
                'alamat' => $this->input->post('alamat'),
                'tgllahir' => $this->input->post('tgllahir'),
                'divisi' => $this->input->post('divisi'),
                'status' => $this->input->post('status'),
            );

            $api_url = $this->api_base_url . 'karyawan/' . $nik;
            $result = $this->sendDataToApi($api_url, $data, 'PUT');

            if ($result) {
                redirect('karyawan');
            } else {
                echo 'Error updating data.';
            }
        } else {
            redirect('karyawan/edit/' . $nik);
        }
    }

    public function delete($nik) {
        try {
            $api_url = $this->api_base_url . 'karyawan/' . $nik;
            $response = $this->makeRequest('GET', $api_url);

            if ($response['status'] === 200) {
                $data['karyawan'] = json_decode($response['body'], true);
                $this->load->view('karyawan/delete_confirmation', $data);
            } else {
                echo 'Error fetching data.';
            }
        } catch (Exception $e) {
            echo 'Exception: ' . $e->getMessage();
        }
    }

    public function do_delete($nik) {
        $api_url = $this->api_base_url . 'karyawan/' . $nik;
        $result = $this->sendDataToApi($api_url, array(), 'DELETE');

        if ($result) {
            redirect('karyawan');
        } else {
            echo 'Error deleting data.';
        }
    }

    private function makeRequest($method, $url, $data = array()) {
        try {
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

            if ($method === 'POST' || $method === 'PUT') {
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            }

            $headers = array();
            $headers[] = 'Content-Type: application/x-www-form-urlencoded';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);

            if (curl_errno($ch)) {
                throw new Exception(curl_error($ch));
            }

            $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            curl_close($ch);

            return array('status' => $httpStatus, 'body' => $result);
        } catch (Exception $e) {
            throw $e;
        }
    }

    private function sendDataToApi($url, $data, $method = 'POST') {
        try {
            $response = $this->makeRequest($method, $url, $data);

            return $response['status'] === 200;
        } catch (Exception $e) {
            echo 'Exception: ' . $e->getMessage();
            return false;
        }
    }
}