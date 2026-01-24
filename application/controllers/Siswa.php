<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Siswa_model');
    }

    public function index()
    {
        $data['title'] = 'Data Siswa';
        $data['siswa'] = $this->Siswa_model->get_all();

        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('siswa/index', $data);
        $this->load->view('layouts/footer');
    }

    public function tambah()
    {
        if ($this->input->post()) {
            $this->Siswa_model->insert([
                'nama_siswa' => $this->input->post('nama_siswa'),
                'nisn'       => $this->input->post('nisn'),
                'kelas'      => $this->input->post('kelas')
            ]);
            $this->session->set_flashdata('success','Data siswa berhasil ditambahkan');
            redirect('siswa');
        }

        $data['title'] = 'Tambah Siswa';
        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('siswa/form', $data);
        $this->load->view('layouts/footer');
    }

    public function edit($id)
    {
        if ($this->input->post()) {
            $this->Siswa_model->update($id, [
                'nama_siswa' => $this->input->post('nama_siswa'),
                'nisn'       => $this->input->post('nisn'),
                'kelas'      => $this->input->post('kelas')
            ]);
            $this->session->set_flashdata('success','Data siswa berhasil diupdate');
            redirect('siswa');
        }

        $data['title'] = 'Edit Siswa';
        $data['row']   = $this->Siswa_model->get_by_id($id);

        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('siswa/form', $data);
        $this->load->view('layouts/footer');
    }

    public function hapus($id)
    {
        $this->Siswa_model->delete($id);
        $this->session->set_flashdata('success','Data siswa berhasil dihapus');
        redirect('siswa');
    }
    public function import_excel()
{
    if (!isset($_FILES['file_excel']['name'])) {
        redirect('siswa');
    }

    $file = $_FILES['file_excel']['tmp_name'];

    try {
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet()->toArray();

        for ($i = 1; $i < count($sheet); $i++) {

            if ($sheet[$i][0] == '') continue;

            // Cegah NISN dobel
            if ($this->Siswa_model->cek_nisn($sheet[$i][1])) {
                continue;
            }

            $data = [
                'nama_siswa' => $sheet[$i][0],
                'nisn'       => $sheet[$i][1],
                'kelas'      => $sheet[$i][2]
            ];

            $this->Siswa_model->insert($data);
        }

        $this->session->set_flashdata(
            'success',
            'Import data siswa berhasil'
        );

    } catch (Exception $e) {
        $this->session->set_flashdata(
            'error',
            'Gagal import: '.$e->getMessage()
        );
    }

    redirect('siswa');
}

public function download_template()
{
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Header
    $sheet->setCellValue('A1', 'nama_siswa');
    $sheet->setCellValue('B1', 'nisn');
    $sheet->setCellValue('C1', 'kelas');

    // Contoh
    $sheet->setCellValue('A2', 'Ahmad Fauzi');
    $sheet->setCellValue('B2', '1234567890');
    $sheet->setCellValue('C2', 'X IPA 1');

    $sheet->getStyle('A1:C1')->getFont()->setBold(true);

    foreach (range('A','C') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    $filename = 'template_import_siswa.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="'.$filename.'"');
    header('Cache-Control: max-age=0');

    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}

}
