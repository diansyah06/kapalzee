<?php
require_once('tcpdf/tcpdf.php');
require_once('fpdi/fpdi.php');

class PDFStampclass extends FPDI {
    public $pdf, $file, $newFile, 
            $fontsize = 24,
            $X=0,
            $Y=0,
            $fontfamily = 'helvetica',
            $psswordmodify="aSdSs@sdfs76851Dgf",
            $certificate = '', 
            $key = '', 
            $info = array(
                'Name' => 'PT Biro Klasifikasi Indonesia',
                'Location' => 'BKI Head Office Jakarta',
                'Reason' => 'BKI E-Certificate',
                'ContactInfo' => 'https://www.bki.co.id',
                );

    /** $file and $newFile have to include the full path. */
    public function __construct($file = null, $newFile = null) {

        $this->pdf = new FPDI();

        $this->certificate= 'file://' . realpath('../ssl_bki/ServerCertificate.crt');
        $this->key = 'file://' . realpath('../ssl_bki/bkidomain.key');

        if (!empty($file)) {
            $this->file = $file;
        }
        if (!empty($newFile)) {
            $this->newFile = $newFile;
        }

    }

    /** $file and $newFile have to include the full path. */
    public static function applyAndSpit($file, $newFile = null) {
        $wm = new Watermarker($file, $newFile);

        if ($wm->isWaterMarked())
            return $wm->spitWaterMarked();
        else {
            $wm->doWaterMark();
            return $wm->spitWaterMarked();
        }
    }



    public function CreatePDFStamp($namadrawing = 'downloaded.pdf',$approvaldrawing=0, $commetArray='',$nomersurat='B. /SV001/PRB-KI-19',$nomerkontrak='000000000'){

        $currentFile = $this->file;
        $newFile = $this->newFile;
        $pagecount = $this->pdf->setSourceFile($currentFile);  
        $this->pdf->SetCreator('PT Biro Klasifikasi Indonesia');
        $this->pdf->SetAuthor('BKI HO');
        $this->pdf->SetTitle('E-Certificate');
        $this->pdf->setSignature($this->certificate, $this->key, 'PT.BKI', '', 2, $this->info);


        for ($i = 1; $i <= $pagecount; $i++) {
            $tplidx = $this->pdf->importPage($i);
            $specs = $this->pdf->getTemplateSize($tplidx);
            $this->pdf->SetPrintHeader(false);
            $this->pdf->SetPrintFooter(false);
            $this->pdf->addPage($specs['h'] > $specs['w'] ? 'P' : 'L');
            $this->pdf->useTemplate($tplidx, null, null, 0, 0, true);

            if ($i==1) { // untuk lembar pertama akan di isi stamp dan comment
              $this->pdf->setPageMark(); // supaya tidak ada gambar yang overlaping table html
             //$this->pdf->startLayer('layer1', true, true);
               
               $this->pdf->setSignatureAppearance($this->X, $this->Y, 60, 85);
               //$this->pdf->setSignatureAppearance($this->X, $this->Y, 50, 100);

            }     

        }

        //die;
        $this->pdf->SetProtection($permissions=array('modify', 'copy', 'annot-forms', 'fill-forms', 'extract', 'assemble', 'print-high'), $user_pass='', $owner_pass=$this->psswordmodify, 0, null);

        if (empty($newFile)) {
            header('Content-Type: application/pdf');

            $this->pdf->Output($namadrawing . ".pdf","I");
        } else {
         $this->pdf->Output($newFile, 'F');
        }


    }

}
?>