<?php

class RLP_C3_1_print implements IPrintTemplate
{

    private string $output_buffer = "";

    private string $html = "";

    private PrintTemplateModelAbstract $model;

    public function __construct(PrintTemplateModelAbstract $model)
    {
        $this->model = $model;
    }

    private function getGradeName($dataArray)
    {
        switch ($this->model->grades[$dataArray]) {
            case "1":
                return "sehr gut";
            case "2":
                return "gut";
            case "3":
                return "befriedigend";
            case "4":
                return "ausreichend";
            case "5":
                return "mangelhaft";
            case "6":
                return "ungenügend";
            default:
                return "nicht erteilt.";
        }
    }

    private function getCompetenceFields($dataArray)
    {
        $competenceHtml = "";
        for ($i = 1; $i < 5; $i++) $competenceHtml .= '<td> <input type="radio" class="grade-radio" name="' . $dataArray . '" ' . ($this->model->competences[$dataArray] == $i ? "checked=true" : "") . '> </td>';
        return $competenceHtml;
    }

    public function render(): bool
    {
        $this->html = '
<style>
    @page {
        font-smooth: never;
        -webkit-font-smoothing: none;
    }
    
    h2 {
        font-size: 14px;
        border-bottom: 1px solid #000;
        padding-bottom: 5px;
    }

    h3 {

    }

    h3.report-grade {
        border-bottom: 3px solid #d8d8d8;
        line-height: 250%;
    }

    input {
        text-align: center;
        vertical-align: middle;
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
    }

    img.print-wappen {
        width: 3cm;
        height: auto;
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

    .report .print-lernverhalten {
        margin-top: 20px;
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
        font-size: 18px;
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
    
    table.table-grades {
        width: 100%;
        font-weight: lighter;
        color: var(--color-font-dark-grey);
        letter-spacing: 0px;
        background: transparent;
    }

    .final-grade {
        font-weight: bold;
    }

    table.table-grades tbody {
        text-align: left;
        letter-spacing: 0.5px;
    }

    table.table-grades tbody tr {
        vertical-align: middle;
    }

    table.table-grades tbody tr td {
        background: transparent;
        vertical-align: middle;
        width: 170px;
    }

    table.table-grades tbody td {
        vertical-align: middle;
        padding: 5px 0px 25px 0px;
    }

    table.table-grades td {
        border-top: 0px solid #888888;
        border-right: 0px solid #888888;
    }

    table.table-grades tr td:last-child {
        border-right: none;
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
                <span class="print-half-year">Halbjahreszeugnis</span>
            </td>
        </tr>
        </tbody>
    </table>

    <table>
        <tr>
            <td class="print-pupil">Vor- und Familienname: <b>' . $this->model->getStudent()->getFirstname() . ' ' . $this->model->getStudent()->getLastname() . '</b></td>
            <td class="print-class">Schuljahr: 2020 / 2021 <br> Klasse ' . $this->model->getSchoolClass()->getSchoolClassName() . '</td>
        </tr>
    </table>

    <div class="report-content">

        <h2>Hauptfächer</h2>

        <table class="table-grades">
            <tbody>

            <tr>
                <!-- Left Column Grade -->

                <td>Mathematik</td>
                <td class="final-grade" name="grade_mathe" colspan="5"> ' . $this->getGradeName('grade_mathe') . '</td>


                <!-- Right Column Grade -->
                <td>Deutsch</td>
                <td class="final-grade" name="grade_deutsch" colspan="5"> ' . $this->getGradeName('grade_deutsch') . '</td>
            </tr>

            <tr>
                <!-- Left Column Grade -->
                <td>Englisch</td>
                <td class="final-grade" name="grade_englisch" colspan="5"> ' . $this->getGradeName('grade_englisch') . '</td>
            </tr>

            </tbody>

        </table>

        <h2>Nebenfächer</h2>

        <table class="table-grades">

            <tbody>

            <tr>
                <!-- Left Column Grade -->
                <td>Sachunterricht</td>
                <td class="final-grade" name="grade_sachunterricht" colspan="5"> ' . $this->getGradeName('grade_sachunterricht') . '</td>

                <!-- Right Column Grade -->
                <td>Religion/Ethik</td>
                <td class="final-grade" name="grade_ethik" colspan="5"> ' . $this->getGradeName('grade_ethik') . '</td>
            </tr>

            <tr>
                <!-- Left Column Grade -->
                <td>Musik</td>
                <td class="final-grade" name="grade_musik" colspan="5"> ' . $this->getGradeName('grade_musik') . '</td>

                <!-- Right Column Grade -->
                <td>Sport</td>
                <td class="final-grade" name="grade_sport" colspan="5"> ' . $this->getGradeName('grade_sport') . '</td>
            </tr>

            <tr>
                <!-- Left Column Grade -->
                <td>Bildende Kunst</td>
                <td class="final-grade" name="grade_kunst" colspan="5"> ' . $this->getGradeName('grade_kunst') . '</td>

                <!-- Right Column Grade -->
                <td>Schrift</td>
                <td class="final-grade" name="grade_schrift" colspan="5"> ' . $this->getGradeName('grade_schrift') . '</td>
            </tr>

            </tbody>

        </table>

        <div class="print-lernverhalten">
            <b>Arbeits- und Sozialverhalten:</b>
            ' . $this->model->getLernArbeitsUndSozialVerhalten() . '
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


        <div class="print-datum">
            Ausgabedatum: ' . $date = date('d. F. Y') . '
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

        $footer = '
        <table class="report-footer" width="100%">
            <tr>
                <td width="33%" style="text-align: left;"></td>
                <td width="33%" style="text-align: center;"></td>
                <td width="33%" style="text-align: right;">Seite <b>{PAGENO}</b> von <b>{nbpg}</b></td>
            </tr>
        </table>';

        $pdf = new \Mpdf\Mpdf([
                'mode' => 'utf-8',
                'format' => "A4",
                'default_font' => 'Arial',
                'default_font_size' => 10,
                'setAutoBottomMargin' => 'stretch' // Auto margin for footer
            ]
        );

        //TODO: Malte Hoch, kann das weg?
        if (isset($_GET['printNow'])) {
            $this->output_buffer .= $pdf->SetJS('window.print();');
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

        return true;
    }

    public function output(): string
    {
        return $this->output_buffer;
    }
}

?>