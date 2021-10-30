<?php

class NRW_C1_1_print implements IPrintTemplate
{
    private string $output_buffer = "";

    private string $html = "";

    private PrintTemplateModelAbstract $model;

    public function __construct(PrintTemplateModelAbstract $model)
    {
        $this->model = $model;
    }

    private function formatDate($date)
    {
        $formatDate = new DateTime($date);
        return $formatDate->format('d.m.Y');
    }

    public function render(): bool
    {
        $this->html =
        '
<style>
    @page {
        font-smooth: never;
        -webkit-font-smoothing: none;
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
        line-height: 150%;
        box-sizing: border-box;
        max-height: 10000px; /* Computed font size increases otherwise, seems to be Chrome Bug */
    }

    .report-content {
        text-align: justify;
        margin-top: 30px;
    }

    .report span {
        display: block;
    }

    .report table {
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
        font-size: 24px;
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
        font-size: 10px;
        font-weight: lighter;
        text-align: center;
        padding-top: 0mm; /* USER INTERACTION: Set border padding */
        line-height: 100%;
    }

    .report .print-report-tier {
        text-align: center;
        font-size: 20px;
        font-weight: bold;
        padding-top: 5mm;
    }

    .report .print-pupil {
        text-align: left;
        padding-top: 10mm;
    }

    .report .print-class-left {
        text-align: left;
        padding-top: 2mm;
    }

    .report .print-class-center {
        text-align: center;
        padding-top: 2mm;
    }

    .report .print-class-right {
        text-align: right;
        padding-top: 2mm;
    }

    .report .hr-before-content {
        color: #000;
        border-top: 2px solid #000;
        height: 2px;
        margin-top: 5px;
        margin-bottom: 5px;
        line-height: 100%;
    }

    .report table.print-signature {
        margin-top: 15mm;
        border-collapse: separate;
        font-size: 8px;
        font-weight: bold;
    }

    .report table.print-signature td {
        text-align: center;
        width: 33%;
        border-top: 1px solid #000;
        border-right: 5mm solid #fff;
        padding-top: 1mm;
    }

    .report table.print-signature td.middle-spacer {
        border-top: 0px;
    }

    .report table.print-signature-last-line td {
        width: 50%;
    }

    .unterschrift-feld {
        letter-spacing: 0px;
    }

</style>

<div class="report">

    <table>
        <tbody>
        <tr>

            <td class="report-header">
                <span class="print-school-name">Grundschule ' . $this->model->getSchool()->getSchoolName() . '</span>
                <hr class="hr-print-school-name">
                <span class="print-half-year">Name und amtliche Bezeichnung der Schule</span>
            </td>
        </tr>
        <tr>
            <td class="print-report-tier">Zeugnis Klasse 1</td>
        </tr>
        </tbody>
    </table>

    <table>
        <tr>
            <td class="print-pupil">für: <b>' . $this->model->getStudent()->getFirstname() . ' ' . $this->model->getStudent()->getLastname() . '</b></td>
        </tr>

        <tr>
            <td class="print-class-left">geb. am <b>' . $this->formatDate($this->model->getStudent()->getDateOfBirth()) . '</b></td>
            <td class="print-class-center">Klasse <b>' . $this->model->getSchoolClass()->getSchoolClassName() . '</b></td>
            <td class="print-class-right">Schuljahr <b>' . $this->model->getSchoolTemplateVariables()->getTemplateVariableValueByName("NRW_GLOB_Current_Schoolyear") . '</b></td>
        </tr>
    </table>

    <hr class="hr-before-content">

    <table>
        <tr>
            <td><b>Fehlzeiten:</b></td>
            <td>0 Tage entschuldigt</td>
            <td>0 Tage unentschuldigt</td>
        </tr>
    </table>

    <div class="report-content">

        <div class="print-lernverhalten">
            <b>Hinweise zum Arbeits- und Sozialverhalten:</b><br>
            ' . $this->model->getHinweiseLernArbeitsSozialverhalten() . '
        </div>

        <br>

        <div class="print-lernverhalten">
            <b>Hinweise zu Lernbereichen / Fächern:</b><br>
            ' . $this->model->getHinweiseLernbereiche() . '
        </div>

        <br>
        
        <div class="print-bemerkungen">
            <b>Bemerkungen:</b> ' . $this->model->getBemerkungen() . '
        </div>

    </div>

    <br>
    <br>
    <br>

    <div>
        ' . $this->model->getStudent()->getFirstname() . ' ' . $this->model->getStudent()->getLastname() . ' nimmt ab 01.01.2003 am Unterricht der Klasse 2 teil.
    </div>
    
    <br>
    
    <div>
        <b>Konferenzbeschluss vom: </b> ' . $this->formatDate($this->model->getSchoolTemplateVariables()->getTemplateVariableValueByName("NRW_1_C1_ConferenceDate")) . '
    </div>
    
    <br>
    
    <div>
        <b>Augustdorf, den ' . $this->formatDate($this->model->getSchoolTemplateVariables()->getTemplateVariableValueByName("NRW_1_C1_IssueDate")) . '</b>
    </div>

    <br>
    <br>

    <table class="print-signature">
        <tr>
            <td class="print-signature-leader">Klassenlehrer/in</td>
            <td class="middle-spacer"></td>
            <td class="print-signature-parent">Schulleiter/in</td>
        </tr>
    </table>

    <br>
    <br>
    <br>

    <table class="print-signature-last-line">
        <tr>
            <td>Kenntnis genommen: <span class="unterschrift-feld">___________________________</span></td>
            <td>Wiederbeginn des Unterrichts: ' . $this->formatDate($this->model->getSchoolTemplateVariables()->getTemplateVariableValueByName("NRW_1_C1_Restart_School")) . '</td>
        </tr>
    </table>

</div>
        ';

//        $header = '';
//
//        $footer = '
//        <table class="print-signature-last-line">
//                      <tr>
//                      <td>Kenntniss genommen: ___________________________________</td>
//                      <td>KWiederbeginn des Unterrichts: 01.01.2003</td>
//                        </tr>
//
//                        </table>';

        $pdf = new \Mpdf\Mpdf([
                'mode' => 'utf-8',
                'format' => "A4",
                'default_font' => 'dejavusans',
                'default_font_size' => 9,
                'setAutoBottomMargin' => 'stretch', // Auto margin for footer
                'cropMarkLength' => 150
            ]
        );

        $this->output_buffer .= $pdf->SHYlang = 'de';
        $this->output_buffer .= $pdf->SHYleftmin = 3;
        $this->output_buffer .= $pdf->SetDisplayMode('fullwidth');
        $this->output_buffer .= $pdf->SetTitle($this->model->getStudent()->getFirstname() . ' ' . $this->model->getStudent()->getLastname());

//        $this->output_buffer .= $pdf->SetHTMLFooter($footer);

        $this->output_buffer .= $pdf->AddPage(
            'P', // L - landscape, P - portrait
            '', // $type
            '', // $resetpagenum
            '', // $pagenumstyle
            '', // $suppress
            '20', // $margin-left
            '16', // $margin-right
            '', // $margin-top
            '1', // $margin-bottom
            '', // $margin-header
            ''); // $margin-footer

        $this->output_buffer .= $pdf->WriteHTML($this->html);

        // $this->output_buffer .= $pdf->SetHTMLFooter('ONLY LAST'); // This footer only for the last page.

        $this->output_buffer .= $pdf->Output('Zeugnis ' . $this->model->getStudent()->getFirstname() . ' ' . $this->model->getStudent()->getLastname() . '.pdf', \Mpdf\Output\Destination::STRING_RETURN);

        return true;
    }

    public function output(): string
    {
        return $this->output_buffer;
    }
}

?>