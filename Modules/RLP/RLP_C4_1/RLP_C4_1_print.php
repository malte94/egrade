<?php

class RLP_C4_1_print implements IPrintTemplate
{

    private string $output_buffer = "";

    private string $html = "";

    private PrintTemplateModelAbstract $model;

//    private PrintTemplateFactoryAdpater $ptfa;

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

    table.table-competences {
        width: 100%;
        font-weight: lighter;
        letter-spacing: 0px;
        border-collapse: separate;
        border-spacing: 10px 10px;
        background: transparent;
        table-layout: fixed;
        text-align: justify;
    }
    
    table.table-competences:nth-child(1) {
        margin-top: 5px;
        padding-top: 0;
    }
    
    table.table-competences thead {
        letter-spacing: 0px;
        text-align: left;
    }

    table.table-competences thead td {
        border-radius: 2px;
        padding: 10px;
        border-top: none;
        text-align: center;
    }

    table.table-competences thead td:nth-child(1) {
        vertical-align: bottom;
        text-align: left;
        padding: 10px 10px 10px 0;
    }

    table.table-competences thead td:nth-child(2) {
        background: #F1F1F1:
    }

    table.table-competences thead td:nth-child(3) {
        background: #F1F1F1:
    }

    table.table-competences thead td:nth-child(4) {
        background: #F1F1F1:
    }

    table.table-competences thead td:nth-child(5) {
        background: #F1F1F1:
    }

    table.table-competences thead td:nth-child(6) {
        background: #F1F1F1:
    }

    table.table-competences tbody {
        text-align: left;
        letter-spacing: 0.5px;
    }

    table.table-competences tbody tr {
        background: rgba(250, 250, 250, 0.9);
        height: 70px;
        vertical-align: middle;
    }

    table.table-competences tbody td {
        border-radius: 2px;
        vertical-align: middle;
        padding: 15px;
        border-bottom: 1px solid #d8d8d8;
    }

    table.table-competences tbody td:nth-child(1) {
        width: 8cm;
        overflow: hidden;
    }

    table.table-competences tbody td:nth-child(2) {
        width: 3cm;
        vertical-align: middle;
        text-align: center;
    }

    table.table-competences tbody td:nth-child(3) {
        width: 3cm;
        vertical-align: middle;
        text-align: center;
    }

    table.table-competences tbody td:nth-child(4) {
        width: 3cm;
        vertical-align: middle;
        text-align: center;
    }

    table.table-competences tbody td:nth-child(5) {
        width: 3cm;
        vertical-align: middle;
        text-align: center;
    }

    table.table-competences td {
        border-top: 0px solid #888888;
        border-right: 0px solid #888888;
    }

    table.table-competences tr td:last-child {
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
        <!-- ________________________________ Deutsch ___________________________________ -->

        <table class="table-competences">

            <thead>
            <tr>
                <td class="final-grade" name="grade_deutsch" colspan="5"></td>
            </tr>
            <tr>
                <td>
                    <h2>Deutsch</h2>
                    <h3>Rechtschreibung</h3>
                </td>
                <td>Das musst du üben</td>
                <td>Das kannst du teilweise</td>
                <td>Das kannst du gut</td>
                <td>Das kannst du sehr gut</td>
            </tr>
            </thead>

            <tbody>
            <tr>
                <td>erlernte Rechtschreibregeln und -strategien sowie Satzzeichen sicher anwenden</td>
                ' . $this->getCompetenceFields('deutsch_rechtschreibung_regeln') . '
            </tr>
            <tr>
                <td>Hilfsmittel zur richtigen Schreibweise anwenden</td>
                ' . $this->getCompetenceFields('deutsch_rechtschreibung_hilfsmittel') . '
            </tr>
            <tr>
                <td>flüssig und formklar schreiben</td>
                ' . $this->getCompetenceFields('deutsch_rechtschreibung_formklar') . '
            </tr>
            <tr>
                <td>Tafelanschriften methodisch richtig und in angemessener Zeit abschreiben</td>
                ' . $this->getCompetenceFields('deutsch_rechtschreibung_tafel') . '
            </tr>
            </tbody>
        </table>

        <h3>Sprachgebrauch</h3>

        <table class="table-competences">
            <tbody>
            <tr>
                <td>deine Anliegen präzise und sprachlich korrekt formulieren</td>
                ' . $this->getCompetenceFields('deutsch_sprachgebrauch_formulieren') . '
            </tr>
            <tr>
                <td>Gesprächsbeiträge anderer aufgreifen und weiterführen</td>
                ' . $this->getCompetenceFields('deutsch_sprachgebrauch_gespraeche') . '
            </tr>
            <tr>
                <td>situationsgerecht erzählen</td>
                ' . $this->getCompetenceFields('deutsch_sprachgebrauch_situationsgerecht') . '
            </tr>
            </tbody>
        </table>

        <h3>Lesen</h3>

        <table class="table-competences">
            <tbody>
            <tr>
                <td>Texte flüssig und wortgenau vortragen</td>
                ' . $this->getCompetenceFields('deutsch_lesen_vortragen') . '
            </tr>
            <tr>
                <td>Informationen aus Texten entnehmen und diese verarbeiten</td>
                ' . $this->getCompetenceFields('deutsch_lesen_informationen') . '
            </tr>
            <tr>
                <td>schriftliche Arbeitsanweisungen verstehen und umsetzen</td>
                ' . $this->getCompetenceFields('deutsch_lesen_anweisungen') . '
            </tr>
            </tbody>
        </table>

        <h3 class="report-grade">Note: ' . $this->getGradeName('grade_deutsch') . ' </h3>

        <pagebreak>
            <!-- ________________________________ Mathematik ___________________________________ -->

            <table class="table-competences">
                <thead>
                <tr>
                    <td class="final-grade" name="grade_mathe" colspan="5"></td>
                    <input type="hidden" name="grade_mathe" value=""></input>
                </tr>
                <tr>
                    <td>
                        <h2>Mathematik</h2>
                        <h3>Analytische Fähigkeiten</h3>
                    </td>
                    <td>Das musst du üben</td>
                    <td>Das kannst du teilweise</td>
                    <td>Das kannst du gut</td>
                    <td>Das kannst du ausgezeichnet</td>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Lösungsstrategien aufstellen und Vermutungen über Zusammenhänge begründen</td>
                    ' . $this->getCompetenceFields('mathe_analytisch_strategien') . '
                </tr>
                <tr>
                    <td>dich in mathematische Sachverhalte hineindenken und Sachaufgaben zielorientiert lösen</td>
                    ' . $this->getCompetenceFields('mathe_analytisch_sachverhalte') . '
                </tr>
                <tr>
                    <td>Fachwörter anwenden und Lösungen präsentieren</td>
                    ' . $this->getCompetenceFields('mathe_analytisch_fachwoerter') . '
                </tr>
                </tbody>
            </table>

            <h3>Größen- und Zahlenverständnis</h3>

            <table class="table-competences">
                <tbody>
                <tr>
                    <td>Zahlen bis zu einer Millionen abbilden und vergleichen</td>
                    ' . $this->getCompetenceFields('mathe_zahlen_millionen') . '
                </tr>
                <tr>
                    <td>Schriftliche Berechnungen durchführen (Addition, Subrtaktion, Multiplikation, Divison)</td>
                    ' . $this->getCompetenceFields('mathe_zahlen_berechnungen') . '
                </tr>
                <tr>
                    <td>Mathematische Einheiten unterscheiden und in einen für diese vorgesehenen Kontext reflektieren
                    </td>
                    ' . $this->getCompetenceFields('mathe_zahlen_einheiten') . '
                </tr>
                <tr>
                    <td>Kopfrechnen und sachgemäßes Runden und Überschlagen von Zahlen</td>
                    ' . $this->getCompetenceFields('mathe_zahlen_kopfrechnen') . '
                </tr>
                </tbody>
            </table>

            <h3>Geometrie</h3>

            <table class="table-competences">
                <tbody>
                <tr>
                    <td>Geometrische Figuren und Körper benennen sowie diesen markante Eigenschaften zuweisen</td>
                    ' . $this->getCompetenceFields('mathe_geometrie_benennen') . '
                </tr>
                <tr>
                    <td>Flächenberechnungen mit gegebenen Formeln durchführen</td>
                    ' . $this->getCompetenceFields('mathe_geometrie_flaechen') . '
                </tr>
                <tr>
                    <td>Raumorientierung und Raumvorstellung anwenden</td>
                    ' . $this->getCompetenceFields('mathe_geometrie_raumvorstellung') . '
                </tr>
                </tbody>
            </table>

            <h3 class="report-grade">Note: ' . $this->getGradeName('grade_mathe') . ' </h3>

            <pagebreak>
                <!-- ________________________________ Sachunterricht ___________________________________ -->

                <table class="table-competences">
                    <thead>
                    <tr>
                        <td class="final-grade" name="grade_sachunterricht" colspan="5"></td>
                        <input type="hidden" name="grade_sachunterricht" value=""></input>
                    </tr>
                    <tr>
                        <td><h2>Sachunterricht</h2></td>
                        <td>Das musst du üben</td>
                        <td>Das kannst du teilweise</td>
                        <td>Das kannst du gut</td>
                        <td>Das kannst du ausgezeichnet</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>qualitative Informationen aus Medien gezielt für die jeweilige Aufgabenstellungen beziehen
                        </td>
                        ' . $this->getCompetenceFields('sachunterricht_informationen_beziehen') . '
                    </tr>
                    <tr>
                        <td>dich für neue Themengebiete aus der Sachkunde begeistern und aktiv an diesen mitarbeiten
                        </td>
                        ' . $this->getCompetenceFields('sachunterricht_themengebiete') . '
                    </tr>
                    <tr>
                        <td>themenbezogene Sammlungen an Inhalten strukturieren und in die Arbeitsmappe einordnen</td>
                        ' . $this->getCompetenceFields('sachunterricht_arbeitsmappe') . '
                    </tr>
                    </tbody>
                </table>

                <h3 class="report-grade">Note: ' . $this->getGradeName('grade_sachunterricht') . ' </h3>

                <!-- ________________________________ Ethik ___________________________________ -->

                <table class="table-competences">
                    <thead>
                    <tr>
                        <td class="final-grade" name="grade_ethik" colspan="5"></td>
                        <input type="hidden" name="grade_ethik" value=""></input>
                    </tr>
                    <tr>
                        <td><h2>Religion/Ethik</h2></td>
                        <td>Das musst du üben</td>
                        <td>Das kannst du teilweise</td>
                        <td>Das kannst du gut</td>
                        <td>Das kannst du ausgezeichnet</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>offen auf Mitschüler zugehen und sie unabhängig ihrer Religion respektieren</td>
                        ' . $this->getCompetenceFields('ethik_offen_respektvoll') . '
                    </tr>
                    <tr>
                        <td>die eigenen Fähigkeiten einschätzen und Stärken hervorheben</td>
                        ' . $this->getCompetenceFields('ethik_faehigkeiten_einschaetzen') . '
                    </tr>
                    <tr>
                        <td>die Meinung anderer anerkennen und Themen sachlich diskutieren</td>
                        ' . $this->getCompetenceFields('ethik_meinung_anderer') . '
                    </tr>
                    <tr>
                        <td>den Religions-/Ethikunterricht aktiv mitgestalten</td>
                        ' . $this->getCompetenceFields('ethik_unterricht_gestalten') . '
                    </tr>
                    <tr>
                        <td>dich in andere hineindenken und einf&uuml;hlen</td>
                        ' . $this->getCompetenceFields('ethik_andere_einfuehlen') . '
                    </tr>
                    </tbody>
                </table>

                <h3 class="report-grade">Note: ' . $this->getGradeName('grade_ethik') . ' </h3>

                <!-- ________________________________ Bildende Kunst und Textiles Gestalten ___________________________________ -->

                <table class="table-competences">
                    <thead>
                    <tr>
                        <td class="final-grade" name="grade_kunst" colspan="5"></td>
                        <input type="hidden" name="grade_kunst" value=""></input>
                    </tr>
                    <tr>
                        <td><h2>Bildende Kunst & Textiles Gestalten</h2></td>
                        <td>Das musst du üben</td>
                        <td>Das kannst du teilweise</td>
                        <td>Das kannst du gut</td>
                        <td>Das kannst du ausgezeichnet</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>gestalterische Aufgaben nach Vorgaben planen und umsetzen</td>
                        ' . $this->getCompetenceFields('kunst_aufgaben_umsetzen') . '
                    </tr>
                    <tr>
                        <td>deine Ideen handwerklich geschickt umsetzen</td>
                        ' . $this->getCompetenceFields('kunst_ideen_umsetzen') . '
                    </tr>
                    <tr>
                        <td>dich für künstlerische Werke und Literatur begeistern</td>
                        ' . $this->getCompetenceFields('kunst_begeistern') . '
                    </tr>
                    </tbody>
                </table>

                <h3 class="report-grade">Note: ' . $this->getGradeName('grade_kunst') . ' </h3>

                <!-- ________________________________ Musik ___________________________________ -->

                <table class="table-competences">
                    <thead>
                    <tr>
                        <td class="final-grade" name="grade_musik" colspan="5"></td>
                        <input type="hidden" name="grade_musik" value=""></input>
                    </tr>
                    <tr>
                        <td><h2>Musik</h2></td>
                        <td>Das musst du üben</td>
                        <td>Das kannst du teilweise</td>
                        <td>Das kannst du gut</td>
                        <td>Das kannst du ausgezeichnet</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Musik rhythmisch, mit oder ohne Instrument, begleiten</td>
                        ' . $this->getCompetenceFields('musik_rhythmus') . '
                    </tr>
                    <tr>
                        <td>Interesse an verschiedenen Musikrichtungen zeigen und diese voneinander abgrenzen</td>
                        ' . $this->getCompetenceFields('musik_musikrichtungen') . '
                    </tr>
                    <tr>
                        <td>Verschiedene Künstler und Musikinstrumente beschreiben und besonderen Merkmalen zuordnen
                        </td>
                        ' . $this->getCompetenceFields('musik_kuenstler_instrumente') . '
                    </tr>
                    <tr>
                        <td>musikalische Szenen in ein darstellendes Spiel reflektieren</td>
                        ' . $this->getCompetenceFields('musik_darstellen') . '
                    </tr>
                    </tbody>
                </table>

                <h3 class="report-grade">Note: ' . $this->getGradeName('grade_musik') . ' </h3>

                <!-- ________________________________ Sport ___________________________________ -->

                <table class="table-competences">
                    <thead>
                    <tr>
                        <td class="final-grade" name="grade_sport" colspan="5"></td>
                        <input type="hidden" name="grade_sport" value=""></input>
                    </tr>
                    <tr>
                        <td><h2>Sport</h2></td>
                        <td>Das musst du üben</td>
                        <td>Das kannst du teilweise</td>
                        <td>Das kannst du gut</td>
                        <td>Das kannst du ausgezeichnet</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Regeln befolgen und ein faires Verhalten bei Mannschaftsspielen zeigen</td>
                        ' . $this->getCompetenceFields('sport_regeln') . '
                    </tr>
                    <tr>
                        <td>Anstrengungsbereitschaft und Interesse an neuen Inhalten bekunden</td>
                        ' . $this->getCompetenceFields('sport_anstrengungsbereitschaft') . '
                    </tr>
                    <tr>
                        <td>Koordination und Kondition bei gestellten Bewegungsaufgaben demonstrieren</td>
                        ' . $this->getCompetenceFields('sport_kondition') . '
                    </tr>
                    <tr>
                        <td>dein Bewegungsrepertoire erweitern</td>
                        ' . $this->getCompetenceFields('sport_bewegungsrepertoire') . '
                    </tr>
                    </tbody>
                </table>

                <h3 class="report-grade">Note: ' . $this->getGradeName('grade_sport') . ' </h3>

                <pagebreak>

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
                'default_font_size' => 8,
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