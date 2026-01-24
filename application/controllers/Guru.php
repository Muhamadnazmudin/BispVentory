<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class Guru extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Guru_model');
    }

    public function index()
    {
        $data['title'] = 'Data Guru';
        $data['guru']  = $this->Guru_model->get_all();

        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('guru/index', $data);
        $this->load->view('layouts/footer');
    }

    public function tambah()
    {
        if ($this->input->post()) {
            $this->Guru_model->insert([
                'nama_guru' => $this->input->post('nama_guru'),
                'nip'       => $this->input->post('nip'),
                'jabatan'   => $this->input->post('jabatan')
            ]);
            $this->session->set_flashdata('success','Data guru berhasil ditambahkan');
            redirect('guru');
        }

        $data['title'] = 'Tambah Guru';
        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('guru/form', $data);
        $this->load->view('layouts/footer');
    }

    public function edit($id)
    {
        if ($this->input->post()) {
            $this->Guru_model->update($id, [
                'nama_guru' => $this->input->post('nama_guru'),
                'nip'       => $this->input->post('nip'),
                'jabatan'   => $this->input->post('jabatan')
            ]);
            $this->session->set_flashdata('success','Data guru berhasil diupdate');
            redirect('guru');
        }

        $data['title'] = 'Edit Guru';
        $data['row']   = $this->Guru_model->get_by_id($id);

        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('guru/form', $data);
        $this->load->view('layouts/footer');
    }

    public function hapus($id)
    {
        $this->Guru_model->delete($id);
        $this->session->set_flashdata('success','Data guru berhasil dihapus');
        redirect('guru');
    }
    public function import_excel()
{
    if (!isset($_FILES['file_excel']['name'])) {
        redirect('guru');
    }

    $file = $_FILES['file_excel']['tmp_name'];

    try {
        $spreadsheet = IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet()->toArray();

        // mulai dari baris ke-2 (skip header)
        for ($i = 1; $i < count($sheet); $i++) {

            if ($sheet[$i][0] == '') continue;

            $data = [
                'nama_guru' => $sheet[$i][0],
                'nip'       => $sheet[$i][1],
                'jabatan'   => $sheet[$i][2]
            ];

            if (!$this->Guru_model->cek_nip($sheet[$i][1])) {
    $this->Guru_model->insert($data);
}

        }

        $this->session->set_flashdata(
            'success',
            'Import data guru berhasil'
        );

    } catch (Exception $e) {
        $this->session->set_flashdata(
            'error',
            'Gagal import: '.$e->getMessage()
        );
    }

    redirect('guru');
}
public function download_template()
{
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Header
    $sheet->setCellValue('A1', 'nama_guru');
    $sheet->setCellValue('B1', 'nip');
    $sheet->setCellValue('C1', 'jabatan');

    // Contoh data
    $sheet->setCellValue('A2', 'Budi Santoso');
    $sheet->setCellValue('B2', '19871234');
    $sheet->setCellValue('C2', 'Guru Matematika');

    // Styling header
    $sheet->getStyle('A1:C1')->getFont()->setBold(true);

    // Auto width
    foreach (range('A','C') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    $filename = 'template_import_guru.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'.$filename.'"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}

}
