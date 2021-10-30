<?php

class RLP_C1_2_print implements IPrintTemplate {

    private string $output_buffer = "";

    private string $html = "";

    private PrintTemplateModelAbstract $model;
//    private PrintTemplateFactoryAdpater $ptfa;

    public function __construct(PrintTemplateModelAbstract $model)
    {
        $this->model = $model;
    }

    public function render(): bool
    {
        $this->html = '
       
                  <style>
                  @page
                  {
                    font-smooth: never;
                    -webkit-font-smoothing : none;
                  }

                  .report {
                    width: 21cm;
                    display: block;
                    background: white;
                    margin: 0 auto;
                    position: relative; /* This is the basis for all elements */
                    overflow: hidden;
                    word-break: break-all;
                    hyphens: auto;
                    font-size: 12px;
                    line-height: 150%;
                    box-sizing: border-box;
                    max-height: 10000px; /* Computed font size increases otherwise, seems to be Chrome Bug */
                  }

                  .report-content {
                    text-align: justify;
                  }

                  img.print-wappen {
                    width: 3cm;
                    height: auto;
                  }

                  .report span {
                    display: block;
                  }
    
                  .report table {
                    font-size: 12px;
                    letter-spacing: 1px !important;
                    margin: 0;
                    width: 100%;
                    vertical-align: top;
                    border-spacing: 0;
                  }
    
                  .report table td {
                    vertical-align: top;
                  }

                  .report .report-header {
                    text-align: center;
                  }

                  .report .print-school-name {
                    font-size: 28px;
                    font-weight: bold;
                    text-align: center;
                  }

                  .hr-print-school-name {
                    color: #000;
                    border-top: 2px solid #000;
                    height: 2px;
                    margin-top: 5px;
                    margin-bottom: 5px;
                    line-height: 100%;
                  }
    
                  .report .print-half-year {
                    font-size: 22px;
                    font-weight: bold;
                    text-align: center;
                    padding-top: 0mm; /* USER INTERACTION: Set border padding */
                    line-height: 100%;
                  }
    
                  .report .print-pupil {
                    text-align: left;
                    padding-top: 10mm;
                  }
    
                  .report .print-class {
                    text-align: right;
                    padding-top: 10mm;
                    padding-bottom: 10mm;
                  }

                  .report .print-datum {
                    margin-top: 5mm;
                    font-style: italic;
                  }

                  .report table.print-signature {
                    margin-top: 15mm;
                    border-collapse: separate;
                  }

                  .report table.print-signature td {
                    text-align: center;
                    width: 33%;
                    border-top: 1px solid #000;
                    border-right: 5mm solid #fff;
                    padding-top: 3mm;
                  }

                  .report-footer {
                    font-size: 11px;
                  }

                  </style>

                  <div class="report">

                    <table>
                      <tbody>
                      <tr>
                      <td>
                        <img class="print-wappen" src="Modules/RLP/RLP.png">
                      </td>
                      <td class="report-header">
                        <span class="print-school-name">' . $this->model->getSchool()->getSchoolName() . '</span>
                        <hr class="hr-print-school-name">
                        <span class="print-half-year">Jahreszeugnis</span>
                      </td>
                      </tr>
                      </tbody>
                      </table>

                      <table>
                      <tr>
                      <td class="print-pupil">Vor- und Familienname: <b>' . $this->model->getStudent()->getFirstname(). ' ' . $this->model->getStudent()->getLastname() . '</b></td>
                      <td class="print-class">Schuljahr: 2020 / 2021 <br> Klasse ' . $this->model->getSchoolClass()->getSchoolClassName(). '</td>
                      </tr>
                      </table>
                      
                      <div class="report-content">

                        <div class="print-lernverhalten">
                          <b>Arbeits- und Sozialverhalten:</b>
                          ' . $this->model->getLernArbeitsUndSozialVerhalten() . '
                        </div>
                        <br>
                        <div class="print-deutsch">
                          <b>Deutsch und Sachkunde:</b>
                          ' . $this->model->getDeutschSachunterricht() . '
                        </div>
                        <br>
                        <div class="print-mathe">
                          <b>Mathematik:</b>
                          ' . $this->model->getMathematik() . '
                        </div>
                        <br>
                        <div class="print-musik-sport">
                          <b>Musik und Sport:</b>
                          ' . $this->model->getMusikSport() . '
                        </div>
                        <br>
                        <div class="print-religion">
                        <b>Religion / Ethik:</b>
                        ' . $this->model->getReligion() . '
                        </div>
                        <br>
                        <div class="print-leistungsentwicklung">
                        <b>Leistungsentwicklung:</b>
                        ' . $this->model->getLeistungsentwicklung() . '
                        </div>
                        <br>
                        <div class="print-fehltage">
                            Versäumt wurden ' . $this->model->getFehlzeitenEntschuldigt() . ' Tage, davon ' . $this->model->getFehlzeitenUnentschuldigt() . ' Tage unentschuldigt.
                        </div>
                        <br>
                        <div class="print-bemerkungen">
                          <b>Bemerkungen:</b> ' . $this->model->getBemerkungen() . '
                        </div>
                        <br>
                        <div class="print-datum">
                        Ausgabedatum: ' . $date = date('d. M. Y') . '
                        </div>

                      </div>

                      <table class="print-signature">
                        <tr>
                          <td class="print-signature-leader">Schulleiter</td>
                          <td class="print-signature-teacher">Klassenleiter</td>
                          <td class="print-signature-parent"><b>Kenntnisnahme des Sorgeberechtigte(n)</b></td>
                        </tr>
                      </table>

                 </div>
        ';

        $header = '';

        $footer = '
        <table class="report-footer" width="100%">
            <tr>
                <td width="33%" style="text-align: left;"></td>
                <td width="33%" style="text-align: center;"></td>
                <td width="33%" style="text-align: right;">Seite <b>{PAGENO}</b> von <b>{nbpg}</b></td>
            </tr>
        </table>';

        if(!isset($_GET['previewJS'])) {

          $pdf = new \Mpdf\Mpdf([
                  'mode' => 'utf-8',
                  'format' => "A4",
                  'default_font' => 'Arial',
                  'setAutoBottomMargin' => 'stretch' // Auto margin for footer
              ]
          );

          if(isset($_GET['printNow'])) {
            //$this->output_buffer .= $pdf->SetJS('window.print();'); 
          }
          
          $this->output_buffer .= $pdf->SHYlang = 'de';
          $this->output_buffer .= $pdf->SHYleftmin = 3;
          $this->output_buffer .= $pdf->SetDisplayMode('fullwidth');  
          $this->output_buffer .= $pdf->SetTitle($this->model->getStudent()->getFirstname() . ' ' . $this->model->getStudent()->getLastname());

          $this->output_buffer .= $pdf->SetHTMLFooter($footer);

          $this->output_buffer .= $pdf->AddPage(
            'P', // L - landscape, P - portrait 
            '', // $type
            '', // $resetpagenum
            '', // $pagenumstyle
            '', // $suppress 
            '', // $margin-left
            '', // $margin-right
            '', // $margin-top
            '', // $margin-bottom
            '', // $margin-header
            ''); // $margin-footer

          $this->output_buffer .= $pdf->WriteHTML($this->html);

          // $this->output_buffer .= $pdf->SetHTMLFooter('ONLY LAST'); // This footer only for the last page.

          $this->output_buffer .= $pdf->Output('Zeugnis ' . $this->model->getStudent()->getFirstname() . ' ' . $this->model->getStudent()->getLastname() . '.pdf', \Mpdf\Output\Destination::STRING_RETURN);
        }
      
    return true;

    }

    public function output() : string
    {
        return $this->output_buffer;
    }
}

?>