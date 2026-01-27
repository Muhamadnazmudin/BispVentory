<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Barang_model');
    }

    public function index()
    {
        $data['title']  = 'Data Barang';
        $data['barang'] = $this->Barang_model->get_all();

        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('barang/index', $data);
        $this->load->view('layouts/footer');
    }

   public function tambah()
{
    if ($this->input->post()) {

        $data = [
            'kode_barang' => $this->input->post('kode_barang'),
            'nama_barang' => $this->input->post('nama_barang'),
            'id_kategori' => $this->input->post('id_kategori'),
            'merk'        => $this->input->post('merk'),
            'harga'       => $this->input->post('harga'),
            'satuan'      => $this->input->post('satuan'),
            'keterangan'  => $this->input->post('keterangan'),
        ];

        $this->Barang_model->insert($data);
        redirect('barang');
    }

    $data['title']       = 'Tambah Barang';
    $data['kode_barang'] = $this->Barang_model->generate_kode();
    $data['kategori']    = $this->Barang_model->get_kategori();

    $this->load->view('layouts/header');
    $this->load->view('layouts/sidebar');
    $this->load->view('layouts/topbar');
    $this->load->view('barang/form', $data);
    $this->load->view('layouts/footer');
}


    public function edit($id)
    {
        if ($this->input->post()) {
            $this->Barang_model->update($id, [
                'kode_barang' => $this->input->post('kode_barang'),
                'nama_barang' => $this->input->post('nama_barang'),
                'id_kategori' => $this->input->post('id_kategori'),
                'satuan'      => $this->input->post('satuan'),
                'harga'       => $this->input->post('harga'),
                'keterangan'  => $this->input->post('keterangan')
            ]);
            $this->session->set_flashdata('success','Data barang berhasil diupdate');
            redirect('barang');
        }

        $data['title']    = 'Edit Barang';
        $data['row']      = $this->Barang_model->get_by_id($id);
        $data['kategori'] = $this->Barang_model->get_kategori();

        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('barang/form', $data);
        $this->load->view('layouts/footer');
    }

    public function hapus($id)
    {
        $this->Barang_model->delete($id);
        $this->session->set_flashdata('success','Data barang berhasil dihapus');
        redirect('barang');
    }
    public function import_excel()
{
    if (!isset($_FILES['file']['name'])) {
        redirect('barang');
    }

    require_once FCPATH . 'vendor/autoload.php';

    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($_FILES['file']['tmp_name']);
    $rows = $spreadsheet->getActiveSheet()->toArray();

    unset($rows[0]); // hapus header

    $dataInsert = [];
    $inserted = 0;
    $skipped  = 0;

    foreach ($rows as $r) {

        if (empty($r[1]) || empty($r[2]) || empty($r[5])) {
            $skipped++;
            continue;
        }

        // auto generate kode kalau kosong
        $kode = !empty($r[0])
            ? trim($r[0])
            : $this->Barang_model->generate_kode();

        // validasi kategori
       $kategori = $this->db
    ->get_where(
        'kategori_barang',
        ['nama_kategori' => trim($r[2])]
    )
    ->row();

if (!$kategori) {
    $skipped++;
    continue;
}
$dataInsert[] = [
    'kode_barang' => $kode,
    'nama_barang' => trim($r[1]),
    'id_kategori' => $kategori->id_kategori,
    'merk'        => trim($r[3]),
    'satuan'      => trim($r[4]),
    'harga'       => $r[5],
    'keterangan'  => trim($r[6] ?? '')
];


        $inserted++;
    }

    if ($dataInsert) {
        $this->Barang_model->insert_batch($dataInsert);
    }

    $this->session->set_flashdata(
        'success',
        "Import selesai. Berhasil: $inserted | Dilewati: $skipped"
    );

    redirect('barang');
}
public function download_template()
{
    require_once FCPATH . 'vendor/autoload.php';

    // ambil kategori
    $kategori = $this->db
        ->select('id_kategori, nama_kategori')
        ->order_by('nama_kategori', 'ASC')
        ->get('kategori_barang')
        ->result();

    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

    /* =========================
       SHEET 1 : TEMPLATE
    ========================= */
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Template Barang');

    $headers = [
        'A1' => 'kode_barang',
        'B1' => 'nama_barang',
        'C1' => 'nama_kategori',
        'D1' => 'merk',
        'E1' => 'satuan',
        'F1' => 'harga',
        'G1' => 'keterangan',
    ];

    foreach ($headers as $cell => $text) {
        $sheet->setCellValue($cell, $text);
        $sheet->getStyle($cell)->getFont()->setBold(true);
    }

    foreach (range('A','G') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // contoh baris
    $sheet->setCellValue('A2', '001');
    $sheet->setCellValue('B2', 'Pulpen');
    $sheet->setCellValue('C2', $kategori[0]->nama_kategori ?? '');
    $sheet->setCellValue('D2', 'Standard');
    $sheet->setCellValue('E2', 'pcs');
    $sheet->setCellValue('F2', '150000');
    $sheet->setCellValue('G2', 'Contoh barang');

    /* =========================
       SHEET 2 : REFERENSI
    ========================= */
    $ref = $spreadsheet->createSheet();
    $ref->setTitle('Referensi');

    $ref->setCellValue('A1', 'id_kategori');
    $ref->setCellValue('B1', 'nama_kategori');
    $ref->getStyle('A1:B1')->getFont()->setBold(true);

    $row = 2;
    foreach ($kategori as $k) {
        $ref->setCellValue("A{$row}", $k->id_kategori);
        $ref->setCellValue("B{$row}", $k->nama_kategori);
        $row++;
    }

    // sembunyikan sheet referensi
    $ref->setSheetState(
        \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::SHEETSTATE_HIDDEN
    );

    /* =========================
       DROPDOWN KATEGORI
    ========================= */
    $lastRow = count($kategori) + 1;

    $validation = $sheet->getCell('C2')->getDataValidation();
    $validation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
    $validation->setAllowBlank(false);
    $validation->setShowDropDown(true);
    $validation->setFormula1("=Referensi!B2:B{$lastRow}");

    // copy validation ke banyak baris
    for ($i = 3; $i <= 500; $i++) {
        $sheet->getCell("C{$i}")->setDataValidation(clone $validation);
    }

    /* =========================
       DOWNLOAD
    ========================= */
    $filename = 'template_import_barang.xlsx';
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="'.$filename.'"');
    header('Cache-Control: max-age=0');

    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}

}
