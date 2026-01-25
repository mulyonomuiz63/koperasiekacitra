<?php

namespace App\Libraries;

use Dompdf\Dompdf;
use Dompdf\Options;
use CodeIgniter\HTTP\ResponseInterface;

class PdfService
{
    protected Dompdf $dompdf;

    public function __construct()
    {
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Arial');

        $this->dompdf = new Dompdf($options);
    }

    /**
     * Render PDF generic
     */
    public function render(
        string $view,
        array $data = [],
        string $filename = 'dokumen.pdf',
        string $paper = 'A4',
        string $orientation = 'portrait'
    ): ResponseInterface {

        $html = view($view, $data);

        $this->dompdf->loadHtml($html);
        $this->dompdf->setPaper($paper, $orientation);
        $this->dompdf->render();

        return service('response')
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader(
                'Content-Disposition',
                'inline; filename="' . $filename . '"'
            )
            ->setBody($this->dompdf->output());
    }
}
