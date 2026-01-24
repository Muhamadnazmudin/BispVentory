<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Kategori_model');
    }

    public function index()
    {
        $data['title'] = 'Kategori Barang';
        $data['kategori'] = $this->Kategori_model->get_all();

        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('kategori/index', $data);
        $this->load->view('layouts/footer');
    }

    public function tambah()
    {
        if ($this->input->post()) {
            $this->Kategori_model->insert([
    'kodering'       => $this->input->post('kodering'),
    'nama_kodering'  => $this->input->post('nama_kodering'),
    'nama_kategori'  => $this->input->post('nama_kategori'),
    'keterangan'     => $this->input->post('keterangan')
]);

            $this->session->set_flashdata('success','Data berhasil disimpan');
            redirect('kategori');
        }

        $data['title'] = 'Tambah Kategori';
        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('kategori/form', $data);
        $this->load->view('layouts/footer');
    }

    public function edit($id)
    {
        if ($this->input->post()) {
            $this->Kategori_model->update($id, [
    'kodering'       => $this->input->post('kodering'),
    'nama_kodering'  => $this->input->post('nama_kodering'),
    'nama_kategori'  => $this->input->post('nama_kategori'),
    'keterangan'     => $this->input->post('keterangan')
]);

            $this->session->set_flashdata('success','Data berhasil diupdate');
            redirect('kategori');
        }

        $data['title'] = 'Edit Kategori';
        $data['row']   = $this->Kategori_model->get_by_id($id);

        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('kategori/form', $data);
        $this->load->view('layouts/footer');
    }

    public function hapus($id)
    {
        $this->Kategori_model->delete($id);
        $this->session->set_flashdata('success','Data berhasil dihapus');
        redirect('kategori');
    }
    public function import_excel()
{
    if (!isset($_FILES['file']['name'])) {
        redirect('kategori');
    }

    require_once APPPATH.'third_party/PhpSpreadsheet/vendor/autoload.php';

    $filePath = $_FILES['file']['tmp_name'];

    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath);
    $sheetData   = $spreadsheet->getActiveSheet()->toArray();

    // hapus header
    unset($sheetData[0]);

    $dataInsert = [];

    foreach ($sheetData as $row) {
        if (empty($row[0]) || empty($row[2])) continue;

        $dataInsert[] = [
            'kodering'       => trim($row[0]),
            'nama_kodering'  => trim($row[1]),
            'nama_kategori'  => trim($row[2]),
            'keterangan'     => trim($row[3])
        ];
    }

    if (!empty($dataInsert)) {
        $this->Kategori_model->insert_batch($dataInsert);
    }

    $this->session->set_flashdata(
        'success',
        'Import kategori berhasil ('.count($dataInsert).' data)'
    );

    redirect('kategori');
}
public function download_template()
{
    $file = FCPATH . 'assets/template/template_kategori.xlsx';

    if (!file_exists($file)) {
        show_404();
    }

    header('Content-Description: File Transfer');
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="template_import_kategori.xlsx"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));

    readfile($file);
    exit;
}

}
