<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Dashboard_model');
    }


   public function index()
{
    $data['title'] = 'Dashboard';


    /*
    |--------------------------------------------------------------------------
    | STATISTIK SPJ
    |--------------------------------------------------------------------------
    */

    $data['spj_kebutuhan'] =
        $this->Dashboard_model
            ->total_spj_kebutuhan();


    $data['barang'] =
        $this->Dashboard_model
            ->total_detail_barang();


    $data['spj_pemeriksaan'] =
        $this->Dashboard_model
            ->total_spj_pemeriksaan();


    $data['spj_internal'] =
        $this->Dashboard_model
            ->total_spj_internal();


    /*
    |--------------------------------------------------------------------------
    | VIEW
    |--------------------------------------------------------------------------
    */

    $this->load->view(
        'layouts/header',
        $data
    );

    $this->load->view(
        'layouts/sidebar'
    );

    $this->load->view(
        'layouts/topbar'
    );

    $this->load->view(
        'dashboard',
        $data
    );

    $this->load->view(
        'layouts/footer'
    );
}
}