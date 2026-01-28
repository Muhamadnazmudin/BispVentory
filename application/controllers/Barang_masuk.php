<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang_masuk extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Barang_masuk_model');
    }

    public function index()
    {
        $data['title'] = 'Barang Masuk';
        $data['list']  = $this->Barang_masuk_model->get_all();

        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('barang_masuk/index',$data);
        $this->load->view('layouts/footer');
    }

    public function tambah()
    {
        if ($this->input->post()) {

            $simpan = $this->Barang_masuk_model->insert([
    'tanggal'     => $this->input->post('tanggal'),
    'no_faktur'   => $this->input->post('no_faktur'),
    'no_kwitansi' => $this->input->post('no_kwitansi'),
    'no_bast'     => $this->input->post('no_bast'),
    'id_barang'   => $this->input->post('id_barang'),
    'jumlah'      => $this->input->post('jumlah'),
    'satuan'      => $this->input->post('satuan'),
    'toko'        => $this->input->post('toko'),
    'perolehan'   => $this->input->post('perolehan'),
    'keterangan'  => $this->input->post('keterangan')
]);


            if ($simpan) {
                $this->session->set_flashdata('success','Barang masuk berhasil disimpan');
            } else {
                $this->session->set_flashdata('error','Gagal menyimpan data');
            }

            redirect('barang_masuk');
        }

        $data['title']  = 'Tambah Barang Masuk';
        $data['barang'] = $this->Barang_masuk_model->get_barang();

        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('barang_masuk/form',$data);
        $this->load->view('layouts/footer');
    }

    // ===============================
    // EDIT
    // ===============================
    public function edit($id_masuk)
    {
        $data['title']  = 'Edit Barang Masuk';
        $data['row']    = $this->Barang_masuk_model->get_by_id($id_masuk);
        $data['barang'] = $this->Barang_masuk_model->get_barang();

        if (!$data['row']) {
            show_404();
        }

        if ($this->input->post()) {
            $this->Barang_masuk_model->update($id_masuk);
            $this->session->set_flashdata('success','Data berhasil diupdate');
            redirect('barang_masuk');
        }

        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('barang_masuk/form',$data);
        $this->load->view('layouts/footer');
    }

    // ===============================
    // DELETE
    // ===============================
    public function delete($id_masuk)
    {
        $hapus = $this->Barang_masuk_model->delete($id_masuk);

        if ($hapus) {
            $this->session->set_flashdata('success','Data berhasil dihapus');
        } else {
            $this->session->set_flashdata('error','Gagal menghapus data');
        }

        redirect('barang_masuk');
    }
    public function import_excel()
{
    if (!isset($_FILES['file']['name'])) {
        redirect('barang_masuk');
    }

    require_once FCPATH . 'vendor/autoload.php';

    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($_FILES['file']['tmp_name']);
    $rows = $spreadsheet->getActiveSheet()->toArray();

    unset($rows[0]); // hapus header

    $inserted = 0;
    $skipped  = 0;

    foreach ($rows as $r) {

        // VALIDASI WAJIB
        if (
            empty($r[0]) ||        // tanggal
            empty($r[4]) ||        // nama_barang
            empty($r[8])           // jumlah
        ) {
            $skipped++;
            continue;
        }

        // cari barang by NAMA BARANG
        $barang = $this->db->get_where(
            'barang',
            ['nama_barang' => trim($r[4])]
        )->row();

        if (!$barang) {
            $skipped++;
            continue;
        }

        $data = [
            'tanggal'     => $r[0],
            'no_faktur'   => trim($r[1] ?? ''),
            'no_kwitansi' => trim($r[2] ?? ''),
            'no_bast'     => trim($r[3] ?? ''),
            'id_barang'   => $barang->id_barang,
            'jumlah'      => (int)$r[8],
            'satuan'      => $barang->satuan,
            'toko'        => trim($r[9] ?? ''),
            'perolehan'   => trim($r[10] ?? 'BOSP'),
            'keterangan'  => trim($r[11] ?? '')
        ];

        if ($this->Barang_masuk_model->insert($data)) {
            $inserted++;
        } else {
            $skipped++;
        }
    }

    $this->session->set_flashdata(
        'success',
        "Import selesai. Berhasil: $inserted | Dilewati: $skipped"
    );

    redirect('barang_masuk');
}

public function download_template()
{
    // =========================
    // MATIKAN OUTPUT CI
    // =========================
    $this->output->enable_profiler(false);

    if (ob_get_length()) {
        ob_end_clean();
    }

    require_once FCPATH . 'vendor/autoload.php';

    // =========================
    // AMBIL DATA BARANG
    // =========================
    $barang = $this->db
        ->select('nama_barang, satuan, merk, harga')
        ->order_by('nama_barang','ASC')
        ->get('barang')
        ->result();

    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

    /* =========================
       SHEET 1 : TEMPLATE
    ========================= */
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Template Barang Masuk');

    $headers = [
        'A1'=>'tanggal',
        'B1'=>'no_faktur',
        'C1'=>'no_kwitansi',
        'D1'=>'no_bast',
        'E1'=>'nama_barang',
        'F1'=>'satuan',
        'G1'=>'merk',
        'H1'=>'harga',
        'I1'=>'jumlah',
        'J1'=>'toko',
        'K1'=>'perolehan',
        'L1'=>'keterangan',
    ];

    foreach ($headers as $cell=>$text) {
        $sheet->setCellValue($cell,$text);
        $sheet->getStyle($cell)->getFont()->setBold(true);
        $sheet->getColumnDimension(substr($cell,0,1))->setAutoSize(true);
    }

    $sheet->setCellValue('A2', date('Y-m-d'));
    $sheet->setCellValue('I2', '1');
    $sheet->setCellValue('K2', 'BOSP');

    /* =========================
       SHEET 2 : REFERENSI
    ========================= */
    $ref = $spreadsheet->createSheet();
    $ref->setTitle('Referensi');

    $ref->setCellValue('A1','nama_barang');
    $ref->setCellValue('B1','satuan');
    $ref->setCellValue('C1','merk');
    $ref->setCellValue('D1','harga');
    $ref->getStyle('A1:D1')->getFont()->setBold(true);

    $row = 2;
    foreach ($barang as $b) {
        $ref->setCellValue("A{$row}", $b->nama_barang);
        $ref->setCellValue("B{$row}", $b->satuan);
        $ref->setCellValue("C{$row}", $b->merk);
        $ref->setCellValue("D{$row}", $b->harga);
        $row++;
    }

    $lastRow = $row - 1;

    $ref->setSheetState(
        \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::SHEETSTATE_HIDDEN
    );

    /* =========================
       DROPDOWN NAMA BARANG
    ========================= */
    $validationBarang = $sheet->getCell('E2')->getDataValidation();
    $validationBarang->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
    $validationBarang->setAllowBlank(false);
    $validationBarang->setShowDropDown(true);
    $validationBarang->setFormula1("=Referensi!A2:A{$lastRow}");

    for ($i=3; $i<=500; $i++) {
        $sheet->getCell("E{$i}")->setDataValidation(clone $validationBarang);
    }

    /* =========================
       AUTO ISI SATUAN, MERK, HARGA
    ========================= */
    for ($i=2; $i<=500; $i++) {
        $sheet->setCellValue(
            "F{$i}",
            '=IFERROR(VLOOKUP(E'.$i.',Referensi!A:D,2,FALSE),"")'
        );
        $sheet->setCellValue(
            "G{$i}",
            '=IFERROR(VLOOKUP(E'.$i.',Referensi!A:D,3,FALSE),"")'
        );
        $sheet->setCellValue(
            "H{$i}",
            '=IFERROR(VLOOKUP(E'.$i.',Referensi!A:D,4,FALSE),"")'
        );
    }

    /* =========================
       DROPDOWN PEROLEHAN
    ========================= */
    $validationPerolehan = $sheet->getCell('K2')->getDataValidation();
    $validationPerolehan->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
    $validationPerolehan->setAllowBlank(false);
    $validationPerolehan->setShowDropDown(true);
    $validationPerolehan->setFormula1('"BOSP,BOPD"');

    for ($i=3; $i<=500; $i++) {
        $sheet->getCell("K{$i}")->setDataValidation(clone $validationPerolehan);
    }

    /* =========================
       DOWNLOAD
    ========================= */
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="template_import_barang_masuk.xlsx"');
    header('Cache-Control: max-age=0');
    header('Pragma: public');

    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}


    
}
