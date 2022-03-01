<?php
require_once('tcpdf/tcpdf.php');
require_once('fpdi/fpdi.php');

class PDFStampclass extends FPDI {
    public $pdf, $file, $newFile, 
            $fontsize = 24,
            $X=0,
            $Y=0,
            $fontfamily = 'helvetica',
            $watermarktext = "*BIRO KLASIFIKASI INDONESIA*",
            $psswordmodify="aSdSs@sdfs76851Dgf",
            $certificate = '', 
            $key = '', 
            $info = array(
                'Name' => 'PT Biro Klasifikasi Indonesia',
                'Location' => 'BKI Head Office Jakarta',
                'Reason' => 'Plan Approval BKI',
                'ContactInfo' => 'https://www.bki.co.id',
                ), 
            $sign, $logo;

    /** $file and $newFile have to include the full path. */
    public function __construct($file = null, $newFile = null) {
        require_once('../modern/base64Img.php');
        $this->pdf = new FPDI();

        $this->certificate= 'file://' . realpath('../ssl_bki/ServerCertificate.crt');
        $this->key = 'file://' . realpath('../ssl_bki/bkidomain.key');

        if (!empty($file)) {
            $this->file = $file;
        }
        if (!empty($newFile)) {
            $this->newFile = $newFile;
        }

        $this->sign = $sign150Base64;
        $this->logo = $bkiRed100;
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
        $this->pdf->SetAuthor('Bahtera-Zee');
        $this->pdf->SetTitle('Dokumen Approval');
        $this->pdf->setSignature($this->certificate, $this->key, 'PTBKI', '', 2, $this->info);


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
               $this->pdf->SetXY($this->X, $this->Y);
               $html=$this->ContrucHtmlStamp($approvaldrawing,$nomersurat,$nomerkontrak); // write html stamp
               $this->pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
               $this->pdf->setSignatureAppearance($this->X, $this->Y, 60, 85);
               //$this->pdf->setSignatureAppearance($this->X, $this->Y, 50, 100);

               if(($approvaldrawing != 1 && $approvaldrawing != 7) || count($commetArray) <= 0)
               {
                $html=$this->ConstructHtmlComment($commetArray); // write comment
                $this->pdf->SetXY($this->X + 70, $this->Y);
                $this->pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);            
                //$this->pdf->endLayer();
              }
            }

            $this->GetFontSizeikutigambar($specs['w'],$specs['h']);
            //echo $specs['w'] . "-" . $specs['h'] . "<br>";
            $this->pdf->SetFont($this->fontfamily, 'BI',$this->fontsize );
            $this->pdf->SetTextColor(255, 0, 0);
             //$_x = ($specs['w']/2) - ($this->pdf->GetStringWidth($this->watermarktext, $this->fontfamily, '', $this->fontsize)/1.0);
             $_y = ($specs['h'] * 0.8);
             $_x= ($specs['w'] * 0.1) ;

            $this->pdf->SetXY($_x, $_y);
            $this->pdf->setAlpha(0.2);
            // biar rotatenya pas miringnya
            $sudutRotasi= rad2deg(atan( $specs['h'] /  $specs['w'] ));
            $this->_rotate($sudutRotasi);
            $this->pdf->Write(0, $this->watermarktext);            

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

    private function GetApprovalString($id_status){


       switch($id_status)
       {
          case "1": case "9":
            $statusEng = '<td class="status-eng">
                            <b><br>APPROVED</b>
                          </td>';
            $statusInd = '<td class="status-ind">
                            <b><i>DISETUJUI</i></b>
                          </td>';
            break;
          case "7": case "8":
            $statusEng = '<td class="status-eng">
                            <b><br>SEEN</b>
                          </td>';
            $statusInd = '<td class="status-ind">
                            <b><i>DIKETAHUI</i></b>
                          </td>';
            break;
          case "6":
            $statusEng = '<td class="status-eng">
                            <b><br>NOT APPROVED</b>
                          </td>';
            $statusInd = '<td class="status-ind">
                            <b><i>TIDAK DISETUJUI</i></b>
                          </td>';
            break;
          case "4":
            $statusEng = '<td class="status-eng">
                            <b><br>EXAMINED</b>
                          </td>';
            $statusInd = '<td class="status-ind">
                            <b><i>DIPERIKSA</i></b>
                          </td>';
            break;
          case "5":
            $statusEng = '<td class="status-eng">
                            <b><br>REFERENCE</b>
                          </td>';
            $statusInd = '<td class="status-ind">
                            <b><i>REFERENSI</i></b>
                          </td>';
            break;
          case "3":
            $statusEng = '<td class="status-eng-long">
                            <b>EXAMINED BY FLAG STATE</b>
                          </td>';
            $statusInd = '<td class="status-ind-long">
                            <b><i>DIPERIKSA OLEH FLAG STATE</i></b>
                          </td>';
            break;
          case "2":
            $statusEng = '<td class="status-eng">
                            <b><br>RETURNED</b>
                          </td>';
            $statusInd = '<td class="status-ind">
                            <b><i>DIKEMBALIKAN</i></b>
                          </td>';
            break;


    }
            $result = array($statusEng, $statusInd );
            return $result ;


  }


    private function ContrucHtmlStamp($option,$nomersurat,$nomerkontrak='00000000000'){

      $result= $this->GetApprovalString($option);
      $statusEng = $result[0];
      $statusInd = $result[1];
      $tanggal=date('d-M-Y');

                  $shtml = <<<EOD
                                  <style>
                                    .tablekita {
                                      border-collapse: collapse;
                                      border: 2px solid red;
                                      color: red;
                                      font-family: Arial;
                                      z-index: -1;
                                    }

                                    tr.border_bottom td {
                                      border-bottom: 1pt solid red;
                                    }

                                    .center {
                                      text-align: center;
                                    }

                                    .right {
                                      text-align: right;
                                    }

                                    td.status-eng {
                                      font-size: 16px; 
                                      height: 30px; 
                                    }

                                    td.status-ind {
                                      font-size: 10px; 
                                      height: 30px; 
                                    }

                                    td.status-eng-long {
                                      font-size: 10px; 
                                      height: 30px;
                                    }   

                                    td.status-ind-long {
                                      font-size: 6px; 
                                      height: 30px; 
                                    }    

                                  </style>
                                    <table class="tablekita" width="140px">
                                      <tbody>
                                        <tr class="center">
                                          <td>
                                            <img id="target" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAA+CAYAAABZcVnrAAABiUlEQVRoge2WwQ7CMAiGGx/BN1g8LXspE5/aB3CevXmbR02F8pfCypaRmDhLy8cPdKZkZPMwLvMwLtxzd/sFCgeX0hcqJFxKGwLMv4exTQ0J9XzYLiz0JOdw4SApmAOwxjjAMJAHYKtxU9wFkHutSYCrQFMBEED1v52akkg+knK5L8L154gERxOVFEPOgxREFK4FRM8TAdEWqO0/sxKjV0dLksXyo9cCpQA3CNJEszAIIJe5pBbXbzXqS7+RVnKSVCopiShrYkhgqWfVAVsg8zWT2BrpkeFoTdIEsLW3xL3aq4FSMF9vSVIFiA4FqqYZoDShzPq9thpqwNc0nVH40roLIKcaCsgpDANKQeZhXJaUTlSJUMDcV9oPB+KgtIBNMcMDaiG1gKqkNMHW2qPOzAoQgtME9PaHD/D+7AOwFxwE2RsubKlhoB6QTXDekCZwXpCmcJsALEFa+bsAeuw5LJRxZSuV03VIUBANuBsgtRZOQQLwTUGvDvgYxhvl+7xMV07V0D3InUPZB2XCWXOgXMzAAAAAAElFTkSuQmCC" width="32" />
                                          </td>
                                        </tr>
                                        <tr class="center border_bottom">
                                          <td style="font-size: 9px"><b>BIRO KLASIFIKASI INDONESIA</b></td>
                                        </tr>
                                        <tr><td><br></td></tr>
                                        <tr class="center">
                                          $statusEng
                                        </tr>
                                        <tr class="center border_bottom">
                                          $statusInd
                                        </tr>
                                        <tr>
                                          <td style="font-size:9px; text-align: left;">
                                            <b>Number: $nomerkontrak</b>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td style="font-size:7px; text-align: left;">
                                            <i>Nomor:</i>
                                          </td>
                                        </tr>
                                        <tr>
                                            <td class="center">
                                                &nbsp;Ttd
                                            </td>
                                        </tr>
                                        <tr><td><br></td></tr>
                                        <tr class="right">
                                          <td>
                                            Jakarta,<u>$tanggal</u>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
EOD;

/*$shtml = <<<EOD
                                  <style>
                                    .tablekita {
                                      border-collapse: collapse;
                                      border: 2px solid red;
                                      color: red;
                                      font-family: Arial;
                                      z-index: -1;
                                    }

                                    tr.border_bottom td {
                                      border-bottom: 1pt solid red;
                                    }

                                    .center {
                                      text-align: center;
                                    }

                                    .right {
                                      text-align: right;
                                    }

                                    td.status-eng {
                                      font-size: 16px; 
                                      height: 30px; 
                                    }

                                    td.status-ind {
                                      font-size: 10px; 
                                      height: 30px; 
                                    }

                                    td.status-eng-long {
                                      font-size: 10px; 
                                      height: 30px;
                                    }   

                                    td.status-ind-long {
                                      font-size: 6px; 
                                      height: 30px; 
                                    }    

                                  </style>
                                    <table class="tablekita" width="140px">
                                      <tbody>
                                        <tr class="center">
                                          <td>
                                            <img id="target" src="$this->logo" width="32" />
                                          </td>
                                        </tr>
                                        <tr class="center border_bottom">
                                          <td style="font-size: 9px"><b>BIRO KLASIFIKASI INDONESIA</b></td>
                                        </tr>
                                        <tr><td><br></td></tr>
                                        <tr class="center">
                                          $statusEng
                                        </tr>
                                        <tr class="center border_bottom">
                                          $statusInd
                                        </tr>
                                        <tr>
                                          <td style="font-size:9px; text-align: left;">
                                            <b>Number: $nomerkontrak</b>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td style="font-size:7px; text-align: left;">
                                            <i>Nomor:</i>
                                          </td>
                                        </tr>
                                        <tr>
                                            <td class="center">
                                                <img id="sign" src="$this->sign" width="65"/>
                                            </td>
                                        </tr>
                                        <tr class="right">
                                          <td>
                                            Jakarta,<u>$tanggal</u>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
EOD;*/

      $remarkhtml= $this->ConstructHtmlRemark($nomersurat);
      return $shtml ."<br><br>". $remarkhtml ;                            
    }


    public function isWaterMarked() {
        //return (file_exists($this->newFile));
        $_file = $this->newFile;
        $file = file_get_contents($_file);
        force_download($file);
    }

    public function spitWaterMarked() {
        $_file = $this->newFile;
        $file = file_get_contents($_file);
        force_download($file);
        //return readfile($this->newFile);
    }

    protected function _rotate($angle, $x = -1, $y = -1) {
        if ($x == -1)
            $x = $this->pdf->x;
        if ($y == -1)
            $y = $this->pdf->y;
        $this->pdf->angle = $angle;

        if ($angle != 0) {
            $angle*=M_PI / 180;
            $c = cos($angle);
            $s = sin($angle);
            $cx = $x * $this->pdf->k;
            $cy = ($this->pdf->h - $y) * $this->pdf->k;

            $this->pdf->_out(sprintf(
                            'q %.5f %.5f %.5f %.5f %.2f %.2f cm 1 0 0 1 %.2f %.2f cm', $c, $s, -$s, $c, $cx, $cy, -$cx, -$cy));
        }
    }

    public function setCoordinate($x = 10,$y = 20)
    {
        $total = 1;
        if (!empty($x) && !empty($y) ) {
            $this->X = $x;
            $this->Y = $y;


        }

        return $this;
    }

    private function ConstructHtmlRemark($nomersurat='B. /SV001/PRB-KI-19'){

      $shtml= <<<EOD
              <style>
              table {
                color: red;
                font-family: Arial;
              }
              .miring {
                font-size: 6px; 
              }
              .tegak {
                font-size: 8px; 
              }  

              </style>

              <table>
                <tr>
                  <td class="tegak">REMARKS SEE LETTER NO.</td>
                </tr>
                <tr>
                  <td class="miring" ><i>REKOMENDASI LIHAT SURAT NO.</i></td>
                </tr>
                <tr>
                  <td class="miring"><b>$nomersurat</b></td>
                </tr>
                <tr>
                  <td class="tegak" >AND ENTRIES IN THE DRAWING DOCUMENT TO BE OBSERVED</td>
                </tr>
                <tr>
                  <td class="miring" ><i>DAN CATATAN MERAH PADA GAMBAR/DOKUMEN AGAR DIPERHATIKAN</i></td>
                </tr>
              </table>
EOD;

      return $shtml ;

    }


    private function ConstructHtmlComment($commentarrays){

      $shtml= "<style>
                    table {
                      color: red;
                      font-family: Arial;
                    }
                    .miring {
                      font-size: 10px; 
                    }
                    .tegak {
                      font-size: 12px; 
                    }
                    .judulcomment {
                      color: red;
                      font-family: Arial;
                    }                     
                    </style>" . '
                    <span class="judulcomment" ><i >See comment No : </i></span> 
                    <table>';

               foreach ($commentarrays as $comment) {
                 $shtml= $shtml . '<tr><td class="tegak"><i>' . $comment['nomer_comment'] . '</i></td></tr>' ;
               }

              $shtml= $shtml . "</table>";
      

      return $shtml ;

    }

    private function GetFontSizeikutigambar($width,$height){

      // A0  841 x 1189 mm 33.1 x 46.8 in
      // A1  594 x 841 mm  23.4 x 33.1 in
      // A2  420 x 594 mm  16.5 x 23.4 in
      // A3  297 x 420 mm  11.7 x 16.5 in
      // A4  210 x 297 mm  8.3 x 11.7 in
      // A5  148 x 210 mm  5.8 x 8.3 in

      if($width > 1100){
        $this->fontsize=110 ;

      }elseif($width > 840){ //A1
        $this->fontsize=90 ;

      }elseif($width > 590){ //A1
        $this->fontsize=70 ;

      }elseif($width > 420){
        $this->fontsize=60 ;

      }elseif($width > 297){ //A3
        $this->fontsize=50 ;

      }elseif($width > 218){ //A4
        $this->fontsize=40 ;

      }elseif($width > 148){
        $this->fontsize=25 ;

      }




    }        


}
?>