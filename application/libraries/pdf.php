<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Dompdf\Dompdf;

class Pdf {

    protected $dompdf;

    public function __construct()
    {
        require_once APPPATH.'third_party/dompdf/autoload.inc.php';
        $this->dompdf = new Dompdf();
    }

    /**
     * @param string $view
     * @param array  $data
     * @param string $paper
     * @param string $orientation
     * @param bool   $preview  true = preview, false = download
     * @param string $filename
     */
    public function load_view($view, $data = [], $paper='A4', $orientation='portrait', $preview=true, $filename='laporan.pdf')
    {
        $CI =& get_instance();

        $html = $CI->load->view($view, $data, TRUE);

        $this->dompdf->loadHtml($html);
        $this->dompdf->setPaper($paper, $orientation);
        $this->dompdf->render();

        // preview = Attachment false
        $this->dompdf->stream($filename, [
            "Attachment" => $preview ? 0 : 1
        ]);
    }
}
