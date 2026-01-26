<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permohonan extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Permohonan_model');
        $this->load->model('Barang_keluar_model');
    }

    /* =========================
       LIST PERMOHONAN
    ==========================*/
    public function index()
    {
        $data['title'] = 'Permohonan Barang';
        $data['list']  = $this->Permohonan_model->get_all();

        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('permohonan/index',$data);
        $this->load->view('layouts/footer');
    }

    /* =========================
       TAMBAH PERMOHONAN
    ==========================*/
    public function tambah()
    {
        if ($this->input->post()) {
            $tanggal = $this->input->post('tanggal');
$tahun   = date('Y', strtotime($tanggal));
$bulan   = bulan_romawi(date('m', strtotime($tanggal)));

// ambil nomor terakhir di tahun yang sama
$last = $this->db
    ->select('nomor_surat')
    ->like('nomor_surat', "/$tahun", 'both') // atau 'after'
    ->order_by('id_permohonan','DESC')
    ->limit(1)
    ->get('permohonan')
    ->row();


$urut = 1;
if($last){
    preg_match('/^(\d+)/', $last->nomor_surat, $m);
    $urut = ((int)$m[1]) + 1;
}

$nomor_surat = str_pad($urut,3,'0',STR_PAD_LEFT)
    ."/PL.01/SMKN1-CILIMUS/$bulan/$tahun";

$header = [
    'nomor_surat'    => $nomor_surat,
    'tanggal'        => $this->input->post('tanggal'),
    'jenis_kebutuhan'=> $this->input->post('jenis_kebutuhan'),
    'pemohon'        => $this->input->post('pemohon'),
    'id_guru'        => $this->input->post('pemohon') == 'guru'
                        ? $this->input->post('id_guru') : NULL,
    'id_siswa'       => $this->input->post('pemohon') == 'siswa'
                        ? $this->input->post('id_siswa') : NULL,
    'keterangan'     => $this->input->post('keterangan'),
    'status'         => 'pending'
];


            $detail = [];
            foreach ($this->input->post('id_barang') as $i => $id_barang) {
                $detail[] = [
                    'id_barang' => $id_barang,
                    'jumlah'    => $this->input->post('jumlah')[$i]
                ];
            }

            $this->Permohonan_model->insert($header, $detail);

            $this->session->set_flashdata('success','Permohonan berhasil diajukan');
            redirect('permohonan');
        }

        $data['title']  = 'Tambah Permohonan';
        $data['barang'] = $this->Permohonan_model->get_barang();
        $data['guru']   = $this->Permohonan_model->get_guru();
        $data['siswa']  = $this->Permohonan_model->get_siswa();

        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('permohonan/form',$data);
        $this->load->view('layouts/footer');
    }

    /* =========================
       DETAIL PERMOHONAN
    ==========================*/
    public function detail($id)
    {
        $data['title'] = 'Detail Permohonan';

        $data['permohonan'] = $this->db
            ->select('p.*, g.nama_guru, s.nama_siswa')
            ->from('permohonan p')
            ->join('guru g','g.id_guru=p.id_guru','left')
            ->join('siswa s','s.id_siswa=p.id_siswa','left')
            ->where('p.id_permohonan',$id)
            ->get()->row();

        if (!$data['permohonan']) {
            show_404();
        }

        $data['detail'] = $this->Permohonan_model->get_detail($id);

        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('permohonan/detail',$data);
        $this->load->view('layouts/footer');
    }

    /* =========================
       APPROVE PERMOHONAN
    ==========================*/
    public function approve($id)
    {
        $permohonan = $this->db
            ->get_where('permohonan',['id_permohonan'=>$id])
            ->row();

        if (!$permohonan || $permohonan->status != 'pending') {
            $this->session->set_flashdata('error','Permohonan sudah diproses');
            redirect('permohonan');
        }

        $detail = $this->Permohonan_model->get_detail($id);

        // cek stok
        foreach ($detail as $d) {
            $stok = $this->Barang_keluar_model->get_stok($d->id_barang);
            if ($d->jumlah > $stok) {
                $this->session->set_flashdata(
                    'error',
                    'Stok tidak mencukupi untuk '.$d->nama_barang
                );
                redirect('permohonan/detail/'.$id);
            }
        }

        $this->db->trans_start();

        // realisasi ke barang_keluar
        foreach ($detail as $d) {
           $this->db->insert('barang_keluar',[
    'tanggal'   => date('Y-m-d'),
    'id_barang' => $d->id_barang,
    'jumlah'    => $d->jumlah,
    'pemohon'   => $permohonan->pemohon,
    'id_guru'   => $permohonan->id_guru,
    'id_siswa'  => $permohonan->id_siswa,
    'keterangan'=> $permohonan->keterangan
]);

        }

        // update status
        $this->Permohonan_model->update_status($id,'disetujui');

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('error','Gagal memproses permohonan');
        } else {
            $this->session->set_flashdata('success','Permohonan berhasil disetujui');
        }

        redirect('permohonan');
    }

    /* =========================
       TOLAK PERMOHONAN
    ==========================*/
    public function tolak($id)
    {
        $permohonan = $this->db
            ->get_where('permohonan',['id_permohonan'=>$id])
            ->row();

        if (!$permohonan || $permohonan->status != 'pending') {
            $this->session->set_flashdata('error','Permohonan sudah diproses');
            redirect('permohonan');
        }

        $this->Permohonan_model->update_status($id,'ditolak');
        $this->session->set_flashdata('success','Permohonan ditolak');
        redirect('permohonan');
    }

    /* =========================
       PDF PERMOHONAN (SIAP PAKAI)
    ==========================*/
   public function pdf($id)
{
    require_once APPPATH.'third_party/dompdf/autoload.inc.php';

$options = new Dompdf\Options();
$options->set('isRemoteEnabled', true);
$options->set('isHtml5ParserEnabled', true);
$options->set('defaultFont', 'Arial');

/**
 * INI KUNCI UTAMA
 * Izinkan DOMPDF membaca file di folder project
 */
$options->set('chroot', FCPATH);

$dompdf = new Dompdf\Dompdf($options);


    $data['permohonan'] = $this->db
        ->select('p.*, g.nama_guru, s.nama_siswa')
        ->from('permohonan p')
        ->join('guru g','g.id_guru=p.id_guru','left')
        ->join('siswa s','s.id_siswa=p.id_siswa','left')
        ->where('p.id_permohonan',$id)
        ->get()->row();

    $data['detail'] = $this->Permohonan_model->get_detail($id);

    $html = $this->load->view('permohonan/pdf',$data,true);

    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4','portrait');
    $dompdf->render();

    $dompdf->stream(
        'Permohonan_Barang_'.$id.'.pdf',
        ['Attachment' => false]
    );
}
public function pdf_pbj($id)
{
    require_once APPPATH.'third_party/dompdf/autoload.inc.php';

$options = new Dompdf\Options();
$options->set('isRemoteEnabled', true);
$options->set('isHtml5ParserEnabled', true);
$options->set('defaultFont', 'Arial');

/**
 * INI KUNCI UTAMA
 * Izinkan DOMPDF membaca file di folder project
 */
$options->set('chroot', FCPATH);

$dompdf = new Dompdf\Dompdf($options);


    $data['permohonan'] = $this->db
        ->select('p.*, g.nama_guru, s.nama_siswa')
        ->from('permohonan p')
        ->join('guru g','g.id_guru=p.id_guru','left')
        ->join('siswa s','s.id_siswa=p.id_siswa','left')
        ->where('p.id_permohonan',$id)
        ->get()->row();

    $data['detail'] = $this->Permohonan_model->get_detail($id);

    $html = $this->load->view('permohonan/pdf_pbj',$data,true);

    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4','portrait');
    $dompdf->render();

    $dompdf->stream(
        'Permohonan_Barang_'.$id.'.pdf',
        ['Attachment' => false]
    );
}

public function download_pdf($id)
{
    require_once APPPATH.'third_party/dompdf/autoload.inc.php';
    $dompdf = new Dompdf\Dompdf();

    $data['permohonan'] = $this->db
        ->select('p.*, g.nama_guru, s.nama_siswa')
        ->from('permohonan p')
        ->join('guru g','g.id_guru=p.id_guru','left')
        ->join('siswa s','s.id_siswa=p.id_siswa','left')
        ->where('p.id_permohonan',$id)
        ->get()->row();

    $data['detail'] = $this->Permohonan_model->get_detail($id);

    $html = $this->load->view('permohonan/pdf',$data,true);

    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4','portrait');
    $dompdf->render();

    // paksa download
    $dompdf->stream(
        'Permohonan_Barang_'.$id.'.pdf',
        ['Attachment' => true]
    );
}
public function delete($id_permohonan)
{
    $p = $this->db
        ->get_where('permohonan',['id_permohonan'=>$id_permohonan])
        ->row();

    if(!$p || $p->status!='pending'){
        $this->session->set_flashdata('error','Permohonan tidak bisa dihapus');
        redirect('permohonan');
    }

    $hapus = $this->Permohonan_model->delete($id_permohonan);

    if ($hapus) {
        $this->session->set_flashdata('success','Permohonan berhasil dihapus');
    } else {
        $this->session->set_flashdata('error','Gagal menghapus permohonan');
    }

    redirect('permohonan');
}

}
