<?php

namespace App\Service;


use App\Entity\Bebe;
use App\Entity\Contrat;
use App\Entity\Fiche;
use App\Entity\Nounou;

class PdfGenerator
{
    private const array FILL_DEFAULT = [232, 232, 232];
    private const int LN = 6;
    private const int HOUR_PER_DAY = 9;

    public function __construct(
        private readonly \FPDF $fpdf,
        private readonly Fiche $fiche,
        private readonly Contrat $contrat,
        private readonly Nounou $nounou,
        private readonly Bebe $bebe,
    ) {

        $this->fpdf->SetMargins(7, 7, 7);
        $this->fpdf->SetAutoPageBreak(false, 0);
        $fontSize = 8;

        $startDate = $this->fiche->getDateDebut();
        $endDate = $this->fiche->getDateFin();

        $this->fpdf->SetFont('DejaVuSerif', 'B', $fontSize);
        $this->fpdf->SetX($this->fpdf->GetX() - 3);
        $this->fpdf->Cell(90, self::LN, $this->encode('FICHE DE CALCUL DU SALAIRE'), 0, 0, 'L');
        $this->fpdf->SetX($this->fpdf->GetX() + 10);
        $this->fpdf->SetFont('DejaVuSerif', '', $fontSize);
        $this->fpdf->SetFillColor(...self::FILL_DEFAULT);
        $this->fpdf->SetDrawColor(150, 150, 150);

        $this->fpdf->Cell(8, self::LN, 'Du', 0, 0, 'L');
        $this->fpdf->Cell(35, self::LN, $startDate->format('d/m/Y'), 0, 0, 'C', true);
        $this->fpdf->Cell(4, self::LN, '', 0, 0, 'L');
        $this->fpdf->Cell(8, self::LN, 'au', 0, 0, 'L');
        $this->fpdf->Cell(35, self::LN, $endDate->format('d/m/Y'), 0, 0, 'C', true);

        $this->fpdf->Ln(self::LN);
        $this->fpdf->Cell(80, self::LN, $this->encode("Accueil de l'enfant 46 semaines ou moins par période de 12 mois"), 0, 0, 'L');
        $this->fpdf->Ln(self::LN);
        $this->fpdf->Cell(90, self::LN, $this->encode('Nom/Prénom du salarié: '.$this->nounou->getLastname().$this->nounou->getFirstname()), 1, 0, 'L', true);
        $this->fpdf->SetX($this->fpdf->GetX() + 10);
        $this->fpdf->Cell(90, self::LN, $this->encode('Nom/Prénom de l\'employeur: '.$this->bebe->getFullnameParent()), 1, 0, 'L', true);
        $this->fpdf->Ln(self::LN);
        $this->fpdf->Cell(90, self::LN, $this->encode('Adresse: '.$this->nounou->getAdress()), 1, 0, 'L', true);
        $this->fpdf->SetX($this->fpdf->GetX() + 10);
        $this->fpdf->Cell(90, self::LN, $this->encode('Adresse: '.$this->bebe->getAdress()), 1, 0, 'L', true);
        $this->fpdf->Ln(self::LN);
        $this->fpdf->Cell(90, self::LN, $this->encode('CP / Ville: '.$this->nounou->getPostalcode().' '.$this->nounou->getCity()), 1, 0, 'L', true);
        $this->fpdf->SetX($this->fpdf->GetX() + 10);
        $this->fpdf->Cell(90, self::LN, $this->encode('CP / Ville: '.$this->bebe->getPostalcode().' '.$this->bebe->getCity()), 1, 0, 'L', true);
        $this->fpdf->Ln(self::LN);
        $this->fpdf->Cell(90, self::LN, $this->encode('N sécurité sociale: '.$this->nounou->getNumSecu()), 1, 0, 'L', true);
        $this->fpdf->SetX($this->fpdf->GetX() + 10);
        $this->fpdf->Cell(90, self::LN, $this->encode('N PAJEMPLOI: '.$this->bebe->getNumEmployeur()), 1, 0, 'L', true);
        $this->fpdf->Ln(self::LN * 1.5);
        $this->fpdf->SetX($this->fpdf->GetX() + 10);
        $this->fpdf->Cell(40, self::LN, $this->encode("Pour l'accueil de l'enfant:"), 0, 0, 'L');
        $this->fpdf->Cell(40, self::LN, $this->encode($this->bebe->getFullnameChild()), 1, 0, 'C', true);
        $this->fpdf->SetX($this->fpdf->GetX() + 9);
        $this->fpdf->Cell(30, self::LN, $this->encode('Date de naissance :'), 0, 0, 'L');
        $this->fpdf->Cell(25, self::LN, $this->encode($this->bebe->getBirthdate()->format('d-m-Y')), 1, 0, 'C', true);

        $this->fpdf->Ln(self::LN + 4);

        // Cadre contrat
        $widthInput = 15;
        $widthDescInput = 12;


        //calcul du brut

        $heureNormalMensualiser = $this->contrat->getSemaineHeures() * $this->contrat->getNombreSemaine() / 12;
        $prixHeureNormalMensualiser = $heureNormalMensualiser * $this->contrat->getTarifHoraireBrutHeuresNormal();



        $nbMois = 12;

        $this->fpdf->Cell(130, 40, '', 1);
        $this->fpdf->SetX($this->fpdf->GetX() - 115);
        $this->fpdf->SetFont('DejaVuSerif', 'B', $fontSize);
        $this->fpdf->Cell(20, self::LN, 'Base de mensualisation', 0, 0, 'L');
        $this->fpdf->SetFont('DejaVuSerif', '', $fontSize);
        $this->fpdf->Ln(self::LN);
        $this->fpdf->SetX($this->fpdf->GetX() + 5);
        $this->fpdf->Cell($widthInput, self::LN, $this->contrat->getSemaineHeures(), 1, 0, 'L', true);
        $this->fpdf->Cell($widthDescInput, self::LN, 'heures ', 0, 0, 'L');
        $this->fpdf->Cell(5, self::LN, 'x', 0, 0, 'L');
        $this->fpdf->Cell($widthInput, self::LN, $this->contrat->getNombreSemaine(), 1, 0, 'L', true);
        $this->fpdf->Cell($widthDescInput + 15, self::LN, 'semaines / 12 mois', 0, 0, 'L');
        $this->fpdf->Cell(6, self::LN, '=', 0, 0, 'R');
        $this->fpdf->Cell(40, self::LN, $this->encode($heureNormalMensualiser.'h. normales mensualisées'), 0, 0, 'L');
        $this->fpdf->Ln(self::LN);
        $this->fpdf->SetX($this->fpdf->GetX() + 5);
        $this->fpdf->Cell($widthInput, self::LN, 0, 1, 0, 'L', true);
        $this->fpdf->Cell($widthDescInput, self::LN, 'heures ', 0, 0, 'L');
        $this->fpdf->Cell(5, self::LN, 'x', 0, 0, 'L');
        $this->fpdf->Cell($widthInput, self::LN, $this->contrat->getNombreSemaine(), 1, 0, 'L', true);
        $this->fpdf->Cell($widthDescInput + 15, self::LN, 'semaines / 12 mois', 0, 0, 'L');
        $this->fpdf->Cell(6, self::LN, '=', 0, 0, 'R');
        $this->fpdf->Cell(40, self::LN, $this->encode('0h. majorées mensualisées'), 0, 0, 'L');
        $this->fpdf->Ln(self::LN + 2);
        $this->fpdf->SetX($this->fpdf->GetX() + 5);
        $this->fpdf->Cell(80, self::LN, $this->encode('tarif horaire brut des heures normales'), 0, 0, 'L');
        $this->fpdf->Cell($widthInput, self::LN, $this->contrat->getTarifHoraireBrutHeuresNormal(), 1, 0, 'L', true);
        $this->fpdf->Cell(10, self::LN, $this->encode('€/h'), 0, 0, 'L');
        $this->fpdf->Ln(self::LN);
        $this->fpdf->SetX($this->fpdf->GetX() + 5);
        $this->fpdf->Cell(80, self::LN, $this->encode('tarif horaire brut des heures complémentaires'), 0, 0, 'L');

        $this->fpdf->Cell($widthInput, self::LN, $this->encode( $this->contrat->getTarifHoraireBrutHeuresComplementaire()), 1, 0, 'L', true);
        $this->fpdf->Cell(10, self::LN, $this->encode('€/h'), 0, 0, 'L');
        $this->fpdf->Ln(self::LN);
        $this->fpdf->SetX($this->fpdf->GetX() + 5);
        $this->fpdf->Cell(80, self::LN, $this->encode('tarif horaire brut des heures majorées'), 0, 0, 'L');
        $this->fpdf->Cell($widthInput, self::LN, $this->encode( $this->contrat->getTarifHoraireBrutHeuresMajorees()), 1, 0, 'L', true);
        $this->fpdf->Cell(10, self::LN, $this->encode('€/h'), 0, 0, 'L');

        $this->fpdf->Ln(self::LN * 2);

        // Cadre Renumeration brute
        $widthTitle = 46.5;
        $widthInput = 13;
        $widthDescInput = 32;
        $widthTotal = 7;

        $this->fpdf->Cell(130, 65, '', 1);
        $this->fpdf->SetX($this->fpdf->GetX() - 115);
        $this->fpdf->SetFont('DejaVuSerif', 'B', $fontSize);
        $this->fpdf->Cell(20, self::LN, 'Salaire mensuel brut', 0, 0, 'L');
        $this->fpdf->SetFont('DejaVuSerif', '', $fontSize);


        $totalWidth = $widthTitle + $widthInput + $widthDescInput + 4 + $widthInput + 15;

        $this->fpdf->Ln(self::LN);
        $this->fpdf->Cell($widthTitle, self::LN, $this->encode('H. normales mensualisées'), 0, 0, 'L');
        $this->fpdf->Cell($widthInput, self::LN, $this->encode($heureNormalMensualiser), 1, 0, 'L', true);
        $this->fpdf->Cell($widthDescInput, self::LN, $this->encode('heures normales'), 0, 0, 'L');
        $this->fpdf->Cell(4, self::LN, $this->encode('x'), 0, 0, 'L');
        $this->fpdf->Cell($widthInput, self::LN, $this->contrat->getTarifHoraireBrutHeuresNormal(), 1, 0, 'L', true);
        $this->fpdf->Cell(15, self::LN, $this->encode('€ = '), 0, 0, 'L');
        $this->fpdf->Cell($widthTotal, self::LN, $this->encode($prixHeureNormalMensualiser.' €'), 0, 0, 'R');
        $this->fpdf->Ln(self::LN);

        $this->fpdf->Cell($widthTitle, self::LN, $this->encode('H. majorées mensualisées'), 0, 0, 'L');
        $this->fpdf->Cell($widthInput, self::LN, $this->encode(0), 1, 0, 'L', true);
        $this->fpdf->Cell($widthDescInput, self::LN, $this->encode('heures majorées'), 0, 0, 'L');
        $this->fpdf->Cell(4, self::LN, $this->encode('x'), 0, 0, 'L');
        $this->fpdf->Cell($widthInput, self::LN, $this->encode($this->contrat->getTarifHoraireBrutHeuresMajorees()), 1, 0, 'L', true);
        $this->fpdf->Cell(15, self::LN, $this->encode('€ = '), 0, 0, 'L');
        $this->fpdf->Cell($widthTotal, self::LN, $this->encode('0 €'), 0, 0, 'R');
        $this->fpdf->Ln(self::LN);

        $this->fpdf->Cell($widthTitle, self::LN, $this->encode('H. compl. contractuelles'), 0, 0, 'L');
        $this->fpdf->Cell($widthInput, self::LN, $this->encode("0"), 1, 0, 'L', true);
        $this->fpdf->Cell($widthDescInput, self::LN, $this->encode('h. compl. normales'), 0, 0, 'L');
        $this->fpdf->Cell(4, self::LN, $this->encode('x'), 0, 0, 'L');
        $this->fpdf->Cell($widthInput, self::LN, $this->encode($this->contrat->getTarifHoraireBrutHeuresMajorees()), 1, 0, 'L', true);
        $this->fpdf->Cell(15, self::LN, $this->encode('€ = '), 0, 0, 'L');
        $this->fpdf->Cell($widthTotal, self::LN, $this->encode("0".' €'), 0, 0, 'R');
        $this->fpdf->Ln(self::LN);

        $this->fpdf->Cell($widthTitle, self::LN, $this->encode('H. compl. non contractuelles'), 0, 0, 'L');
        $this->fpdf->Cell($widthInput, self::LN, '0', 1, 0, 'L', true);
        $this->fpdf->Cell($widthDescInput, self::LN, $this->encode('h. compl'), 0, 0, 'L');
        $this->fpdf->Cell(4, self::LN, $this->encode('x'), 0, 0, 'L');
        $this->fpdf->Cell($widthInput, self::LN, $this->contrat->getTarifHoraireBrutHeuresMajorees(), 1, 0, 'L', true);
        $this->fpdf->Cell(15, self::LN, $this->encode('€ = '), 0, 0, 'L');
        $this->fpdf->Cell($widthTotal, self::LN, $this->encode('0 €'), 0, 0, 'R');
        $this->fpdf->Ln(self::LN);

        $this->fpdf->Cell($widthTitle, self::LN, $this->encode('H. majorées'), 0, 0, 'L');
        $this->fpdf->Cell($widthInput, self::LN, "0", 1, 0, 'L', true);
        $this->fpdf->Cell($widthDescInput, self::LN, $this->encode('heures majorées'), 0, 0, 'L');
        $this->fpdf->Cell(4, self::LN, $this->encode('x'), 0, 0, 'L');
        $this->fpdf->Cell($widthInput, self::LN, $this->encode($this->contrat->getTarifHoraireBrutHeuresMajorees()), 1, 0, 'L', true);
        $this->fpdf->Cell(15, self::LN, $this->encode('€ = '), 0, 0, 'L');
        $this->fpdf->Cell($widthTotal, self::LN, $this->encode("0".' €'), 0, 0, 'R');
        $this->fpdf->Ln(self::LN);

        $this->fpdf->Cell($widthTitle, self::LN, $this->encode('Accueil occasionnel'), 0, 0, 'L');
        $this->fpdf->Cell($widthInput, self::LN, '', 1, 0, 'L', true);
        $this->fpdf->Cell($widthDescInput, self::LN, $this->encode('heures normales'), 0, 0, 'L');
        $this->fpdf->Cell(4, self::LN, $this->encode('x'), 0, 0, 'L');
        $this->fpdf->Cell($widthInput, self::LN, '', 1, 0, 'L', true);
        $this->fpdf->Cell(15, self::LN, $this->encode('€ = '), 0, 0, 'L');
        $this->fpdf->Cell($widthTotal, self::LN, $this->encode('0 €'), 0, 0, 'R');
        $this->fpdf->Ln(self::LN);

        $this->fpdf->Cell($totalWidth, self::LN, $this->encode("Montant de la déduction des périodes d'absence"), 0, 0, 'L');
        $this->fpdf->Cell($widthTotal, self::LN, $this->encode("0".' €'), 0, 0, 'R');
        $this->fpdf->Ln(self::LN);

        $this->fpdf->Cell($totalWidth, self::LN, $this->encode('Divers'), 0, 0, 'L');
        $this->fpdf->Cell($widthTotal, self::LN, $this->encode('0 €'), 0, 0, 'R');
        $this->fpdf->Ln(self::LN);

        $this->fpdf->Cell($totalWidth, self::LN, $this->encode('Congés payés'), 0, 0, 'L');
        $this->fpdf->Cell($widthTotal, self::LN, $this->encode('0 €'), 0, 0, 'R');
        $this->fpdf->Ln(self::LN);
        $this->fpdf->SetFont('DejaVuSerif', 'B', $fontSize);
        $this->fpdf->Cell($totalWidth - 12, self::LN, $this->encode('SALAIRE BRUT TOTAL'), 1, 0, 'L', true);
        $this->fpdf->Cell($widthTotal + 11.5, self::LN, $this->encode($prixHeureNormalMensualiser.' €'), 1, 0, 'R', true);
        $this->fpdf->Ln(self::LN * 1.5);

        //Calcul du net
        $salaireDeclarationPaje = round($prixHeureNormalMensualiser * $this->contrat->getCoef(), 2);

        $this->fpdf->Cell(111.5, self::LN, $this->encode('SALAIRE NET A DECLARER A PAJEMPLOI'), 1, 0, 'L', true);
        $this->fpdf->Cell(18.5, self::LN, $this->encode($salaireDeclarationPaje.' €'), 1, 0, 'R', true);
        $this->fpdf->Ln(self::LN);
        $this->fpdf->SetFont('DejaVuSerif', 'B', 6.80);
        $this->fpdf->Cell(111.5, self::LN, $this->encode("Report du montant de l'exonération des heures complémentaires et/ou majorées"), 1, 0, 'L');
        $this->fpdf->SetFont('DejaVuSerif', 'B', $fontSize);
        $this->fpdf->Cell(18.5, self::LN, $this->encode('0€'), 1, 0, 'R');

//        $this->fpdf->Cell(111.5, self::LN, $this->encode("SALAIRE NET en tenant compte de l'exonération"), 1, 0, 'L', true);
//        $this->fpdf->Cell(18.5, self::LN, $this->encode("".' €'), 1, 0, 'R', true);
        $this->fpdf->Ln(self::LN * 1.5);

        $this->fpdf->SetFont('DejaVuSerif', '', $fontSize);

        // Cadre indemnités
        $widthTitle = 55;
        $widthInput = 15;
        $widthDescInput = 10;
        $widthTotal = 20;
        $widthOperande = 5;
        $allWidthForRupture = $widthTitle + $widthInput + $widthDescInput + $widthOperande + $widthInput + $widthDescInput;

        //Calcul jour de présence
        $nbJourPresence = 0;
        foreach ($this->fiche->getLigneFiches() as $ligneFiche) {
            if (is_numeric($ligneFiche->getHeureNormalJour())) {
                $nbJourPresence++;
            }
        }
        $totalIndemniteEntretien = round($this->contrat->getIndemniteEntretien() * $nbJourPresence, 2);
        $totalIndemniteRepas = round($this->contrat->getIndemniteDejeuner() * $nbJourPresence, 2);
        $totalIndemniteGouter = round($this->contrat->getIndemniteGouter() * $nbJourPresence, 2);
        $totalIndemnite = round($totalIndemniteEntretien + $totalIndemniteRepas + $totalIndemniteGouter, 2);

        $this->fpdf->Cell(130, 35, '', 1);
        $this->fpdf->SetX($this->fpdf->GetX() - 130);
        $this->fpdf->Cell($widthTitle, self::LN, $this->encode('Indemnités d\'entretien'), 0, 0, 'L');
        $this->fpdf->Cell($widthInput, self::LN, $this->encode(round($this->contrat->getIndemniteEntretien(), 2)), 1, 0, 'L', true);
        $this->fpdf->Cell($widthDescInput, self::LN, $this->encode('jours'), 0, 0, 'L');
        $this->fpdf->Cell($widthOperande, self::LN, $this->encode('x'), 0, 0, 'L');
        $this->fpdf->Cell($widthInput, self::LN, $this->encode($nbJourPresence), 1, 0, 'L', true);
        $this->fpdf->Cell($widthDescInput, self::LN, $this->encode('€ ='), 0, 0, 'L');
        $this->fpdf->Cell($widthTotal, self::LN, $this->encode($totalIndemniteEntretien.' €'), 0, 0, 'R');
        $this->fpdf->Ln(self::LN);

        //        $this->fpdf->Cell($widthTitle, self::LN, $this->encode('Indemnités d\'entretien'), 0, 0, 'L');
        //        $this->fpdf->Cell($widthInput, self::LN, "", 1, 0, 'L', true);
        //        $this->fpdf->Cell($widthDescInput, self::LN, $this->encode('jours'), 0, 0, 'L');
        //        $this->fpdf->Cell($widthOperande, self::LN, $this->encode('x'), 0, 0, 'L');
        //        $this->fpdf->Cell($widthInput, self::LN, "", 1, 0, 'L', true);
        //        $this->fpdf->Cell($widthDescInput, self::LN, $this->encode('€ ='), 0, 0, 'L');
        //        $this->fpdf->Cell($widthTotal, self::LN, $this->encode('0.00 €'), 0, 0, 'R');
        //        $this->fpdf->Ln(self::LN);

        $this->fpdf->Cell($widthTitle, self::LN, $this->encode('Indemnités repas'), 0, 0, 'L');
        $this->fpdf->Cell($widthInput, self::LN, $this->encode($this->contrat->getIndemniteDejeuner()), 1, 0, 'L', true);
        $this->fpdf->Cell($widthDescInput, self::LN, $this->encode('jours'), 0, 0, 'L');
        $this->fpdf->Cell($widthOperande, self::LN, $this->encode('x'), 0, 0, 'L');
        $this->fpdf->Cell($widthInput, self::LN, $this->encode($nbJourPresence), 1, 0, 'L', true);
        $this->fpdf->Cell($widthDescInput, self::LN, $this->encode('€ ='), 0, 0, 'L');
        $this->fpdf->Cell($widthTotal, self::LN, $this->encode($totalIndemniteRepas.' €'), 0, 0, 'R');
        $this->fpdf->Ln(self::LN);

        $this->fpdf->Cell($widthTitle, self::LN, $this->encode('Indemnités goûters'), 0, 0, 'L');
        $this->fpdf->Cell($widthInput, self::LN, $this->contrat->getIndemniteGouter(), 1, 0, 'L', true);
        $this->fpdf->Cell($widthDescInput, self::LN, $this->encode('jours'), 0, 0, 'L');
        $this->fpdf->Cell($widthOperande, self::LN, $this->encode('x'), 0, 0, 'L');
        $this->fpdf->Cell($widthInput, self::LN, $this->encode($nbJourPresence), 1, 0, 'L', true);
        $this->fpdf->Cell($widthDescInput, self::LN, $this->encode('€ ='), 0, 0, 'L');
        $this->fpdf->Cell($widthTotal, self::LN, $this->encode($totalIndemniteGouter.' €'), 0, 0, 'R');
        $this->fpdf->Ln(self::LN);

        //A retirer pour aléger si besoin
        $this->fpdf->Cell($widthTitle, self::LN, $this->encode('Indemnités kimolétriques'), 0, 0, 'L');
        $this->fpdf->Cell($widthInput, self::LN, 0, 1, 0, 'L', true);
        $this->fpdf->Cell($widthDescInput, self::LN, $this->encode('km'), 0, 0, 'L');
        $this->fpdf->Cell($widthOperande, self::LN, $this->encode('x'), 0, 0, 'L');
        $this->fpdf->Cell($widthInput, self::LN, 0, 1, 0, 'L', true);
        $this->fpdf->Cell($widthDescInput, self::LN, $this->encode('€ ='), 0, 0, 'L');
        $this->fpdf->Cell($widthTotal, self::LN, $this->encode("0".' €'), 0, 0, 'R');
        $this->fpdf->Ln(self::LN);

        $this->fpdf->Cell($allWidthForRupture, self::LN, $this->encode('Indemnités de rupture'), 0, 0, 'L');
        $this->fpdf->Cell($widthTotal, self::LN, $this->encode('0.00 €'), 0, 0, 'R');
        $this->fpdf->Ln(self::LN);
        $this->fpdf->SetFont('DejaVuSerif', 'B', $fontSize);
        $this->fpdf->Cell($allWidthForRupture, self::LN, $this->encode('Total des indémnitées'), 1, 0, 'L', true);
        $this->fpdf->Cell($widthTotal, self::LN, $this->encode($this->encode($totalIndemnite).' €'), 1, 0, 'R', true);
        $this->fpdf->SetFont('DejaVuSerif', '', $fontSize);
        $this->fpdf->Ln(self::LN * 1.5);

//        $this->fpdf->Cell(32, self::LN, $this->encode('Total Ind. Entretien'), 1, 0, 'L', true);
//        $this->fpdf->Cell(12, self::LN, $this->encode($totalINdemnite.' €'), 1, 0, 'R', true);


        //Calcul des totaux
        $netPayerAvantImpot = $totalIndemnite + $salaireDeclarationPaje;
        $soldeAVerser = $netPayerAvantImpot - $this->fiche->getPrelevementSourceIndiquationPaje();

        // NET A PAYER
        $this->fpdf->SetFont('DejaVuSerif', 'B', $fontSize - 2);
        $this->fpdf->Cell(51, self::LN, $this->encode('Net à payer avant impôt sur le revenu'), 1, 0, 'C', true);
        $this->fpdf->SetFont('DejaVuSerif', 'B', $fontSize);
        $this->fpdf->Cell(30, self::LN, $this->encode($netPayerAvantImpot.' €'), 1, 0, 'C', true);
        $this->fpdf->SetFont('DejaVuSerif', '', $fontSize);

        $this->fpdf->Ln(self::LN);

//        $this->fpdf->Cell(32, self::LN, $this->encode('Total Ind. Nourriture'), 1, 0, 'L', true);
//        $this->fpdf->Cell(12, self::LN, $this->encode("".' €'), 1, 0, 'R', true);
        $this->fpdf->SetX($this->fpdf->GetX() - 1);
        $this->fpdf->SetFont('DejaVuSerif', '', $fontSize - 2);
        $this->fpdf->Cell(52, self::LN, $this->encode('Prélèvement a la source indiqué par pajemploi'), 0, 0, 'L');
        $this->fpdf->SetFont('DejaVuSerif', 'B', $fontSize);
        $this->fpdf->Cell(30, self::LN, $this->encode($this->fiche->getPrelevementSourceIndiquationPaje().' €'), 1, 0, 'C');
        $this->fpdf->SetFont('DejaVuSerif', '', $fontSize);
        $this->fpdf->Ln(self::LN);
//        $this->fpdf->Cell(32, self::LN, $this->encode('Total Ind. KM'), 1, 0, 'L', true);
//        $this->fpdf->Cell(12, self::LN, $this->encode('0 €'), 1, 0, 'R', true);

        $this->fpdf->SetFont('DejaVuSerif', 'B', $fontSize);
        $this->fpdf->SetX($this->fpdf->GetX());
        $this->fpdf->Cell(51, self::LN, $this->encode('SOLDE A VERSER'), 1, 0, 'C', true);
        $this->fpdf->Cell(30, self::LN, $this->encode($soldeAVerser.' €'), 1, 0, 'C', true);
        $this->fpdf->SetFont('DejaVuSerif', '', $fontSize);
        $this->fpdf->Ln(self::LN * 1.5);
        //A modifier en cas de plusieurs congés dans le mois (créer une table pour)
        if ($this->fiche->getCongeDateStart()) {
                //$typeVacation = ('sans_solde' === $vacation['vacationType']) ? 'sans solde' : '';
                $this->fpdf->Cell(12, self::LN, $this->encode('Congés : '), 0, 0, 'L', false);
                $this->fpdf->Ln(self::LN );
                $this->fpdf->Cell(6, self::LN, $this->encode('du'), 1, 0, 'c', true);
                $this->fpdf->Cell(30, self::LN, $this->encode($this->fiche->getCongeDateStart()->format('d-m-Y')), 1, 0, 'C', true);
                $this->fpdf->Cell(6, self::LN, $this->encode('au'), 1, 0, 'c', true);
                $this->fpdf->Cell(30, self::LN, $this->encode($this->fiche->getCongeDateEnd()->format('d-m-Y')), 1, 0, 'C', true);
                $this->fpdf->Ln(self::LN);

        }

        // Calendrier de présence

        $this->fpdf->SetY(59);
        $this->fpdf->SetX($this->fpdf->GetX() + 145);
        $this->fpdf->Cell(45, self::LN, $this->encode('Calendrier de présence'), 1, 0, 'C', true);
        $this->fpdf->Ln();
        $this->fpdf->SetY($this->fpdf->GetY());
        $this->fpdf->SetFont('DejaVuSerif', '', $fontSize - 1);
        $this->fpdf->SetX($this->fpdf->GetX() + 145);
        $this->fpdf->MultiCell(15, self::LN, $this->encode('jrs/heures présence'), 1, 'C', true);

        $this->fpdf->SetY($this->fpdf->GetY() - self::LN * 2);
        $this->fpdf->SetX($this->fpdf->GetX() + 145 + 15);
        $this->fpdf->MultiCell(15, self::LN, $this->encode('Heures compl.'), 1, 'C', true);

        $this->fpdf->SetY($this->fpdf->GetY() - self::LN * 2);
        $this->fpdf->SetX($this->fpdf->GetX() + 145 + 30);
        $this->fpdf->MultiCell(15, self::LN, $this->encode('Heure majorées'), 1, 'C', true);

        $jourHeureContractuel = 0;
        $jourHeureComple = 0;
        $jourHeureMajore = 0;
        $heureNormalMensualiserEffectue = 0;
        $nbJourTravailler = 0;
        $nbJourTravaillerIncluantAbsenceInjustifer = 0;
        $nbJourAbs = 0;
        $i = 1;
        $arrayExclude = ['SED', 'ABS'];
        foreach ($this->fiche->getLigneFiches() as $ligneFiche) {
            $iText = ($i < 10 ? '0'.$i : $i);
            if (1 != $i) {
                $this->fpdf->Ln();
            }
            if (!in_array($ligneFiche->getHeureNormalJour(), $arrayExclude) && is_numeric($ligneFiche->getHeureNormalJour())) {
                $jourHeureContractuel += $ligneFiche->getHeureNormalJour();
                $heureNormalMensualiserEffectue += $ligneFiche->getHeureNormalJour();
                $nbJourTravaillerIncluantAbsenceInjustifer+= $ligneFiche->getHeureNormalJour();

                $nbJourTravailler++;
            }
            if (!in_array($ligneFiche->getHeureComplJour(), $arrayExclude) && is_numeric($ligneFiche->getHeureComplJour())) {
                $jourHeureComple += $ligneFiche->getHeureComplJour();
            }
            if (!in_array($ligneFiche->getHeureMajoreesJour(), $arrayExclude) && is_numeric($ligneFiche->getHeureMajoreesJour())) {
                $jourHeureMajore += $ligneFiche->getHeureMajoreesJour();
            }

            if ($ligneFiche->getHeureNormalJour() === "ANJE") {
                // 9 = durée d'un jour de travail normal prévu dans le contrat
                $jourHeureContractuel += 9;
                $nbJourTravaillerIncluantAbsenceInjustifer += 9;
            }

            if ($ligneFiche->getHeureNormalJour() === "ABS") {
                $nbJourAbs++;
            }




            $this->fpdf->SetY($this->fpdf->GetY());
            $this->fpdf->SetX($this->fpdf->GetX() + 145);
            $this->fpdf->Cell(15, self::LN, $this->encode($ligneFiche->getHeureNormalJour()), 1, 0, 'C');
            $this->fpdf->SetY($this->fpdf->GetY());
            $this->fpdf->SetX($this->fpdf->GetX() + 145 + 15);
            $this->fpdf->Cell(15, self::LN, $this->encode($ligneFiche->getHeureComplJour()), 1, 0, 'C');
            $this->fpdf->SetY($this->fpdf->GetY());
            $this->fpdf->SetX($this->fpdf->GetX() + 145 + 30);
            $this->fpdf->Cell(15, self::LN, $this->encode($ligneFiche->getHeureMajoreesJour()), 1, 0, 'C');
            $this->fpdf->SetY($this->fpdf->GetY());
            $this->fpdf->SetX($this->fpdf->GetX() + 145 - 7);
            $this->fpdf->Cell(7, self::LN, $this->encode($iText), 1, 0, 'C', true);
            $i++;
        }

        $this->fpdf->Ln(self::LN);
        $this->fpdf->SetY($this->fpdf->GetY());
        $this->fpdf->SetX($this->fpdf->GetX() + 145);
        $this->fpdf->Cell(15, self::LN, $this->encode($jourHeureContractuel), 1, 0, 'C');
        $this->fpdf->SetY($this->fpdf->GetY());
        $this->fpdf->SetX($this->fpdf->GetX() + 145 + 15);
        $this->fpdf->Cell(15, self::LN, $this->encode($jourHeureComple), 1, 0, 'C');
        $this->fpdf->SetY($this->fpdf->GetY());
        $this->fpdf->SetX($this->fpdf->GetX() + 145 + 30);
        $this->fpdf->Cell(15, self::LN, $this->encode($jourHeureMajore), 1, 0, 'C');
        $this->fpdf->SetY($this->fpdf->GetY());
        $this->fpdf->SetX($this->fpdf->GetX() + 145 - 7);
        $this->fpdf->SetFont('DejaVuSerif', 'B', $fontSize - 3);
        $this->fpdf->Cell(7, self::LN, $this->encode('TOTAL'), 1, 0, 'C', true);

        $this->fpdf->Ln(self::LN * 2);
        $this->fpdf->SetY($this->fpdf->GetY());
        $this->fpdf->SetX($this->fpdf->GetX() + 145 - 7);
        $this->fpdf->Cell(52, self::LN, $this->encode('Heures normales mensualisées : '.$heureNormalMensualiserEffectue), 1, 0, 'C', true);
        $this->fpdf->Ln(self::LN);
        $this->fpdf->SetY($this->fpdf->GetY());
        $this->fpdf->SetX($this->fpdf->GetX() + 145 - 7);
        $this->fpdf->Cell(52, self::LN, $this->encode('Heures contractuelles rémunérées du mois : '.$nbJourTravaillerIncluantAbsenceInjustifer), 1, 0, 'C', true);
        $this->fpdf->Ln(self::LN);
        $this->fpdf->SetY($this->fpdf->GetY());
        $this->fpdf->SetX($this->fpdf->GetX() + 145 - 7);
        $this->fpdf->Cell(52, self::LN, $this->encode("Nb de jours de 8 heures ou plus d'activité : ".$nbJourTravailler), 1, 0, 'C', true);
        $this->fpdf->Ln(self::LN);
        $this->fpdf->SetY($this->fpdf->GetY());
        $this->fpdf->SetX($this->fpdf->GetX() + 145 - 7);
        $this->fpdf->Cell(52, self::LN, $this->encode('Nb de jour Absent : '.$nbJourAbs), 1, 0, 'C', true);
    }


    private function timeToSeconds(string $time): int
    {
        if ('' === $time) {
            return 0;
        }

        $parts = explode(':', $time);

        // Assurer un format HH:MM ou HH:MM:SS
        if (count($parts) < 2 || count($parts) > 3) {
            throw new InvalidArgumentException("Format de temps invalide. Utilise 'HH:MM' ou 'HH:MM:SS'.");
        }

        $hours = (int) $parts[0];
        $minutes = (int) $parts[1];
        $seconds = 3 === count($parts) ? (int) $parts[2] : 0;

        return ($hours * 3600) + ($minutes * 60) + $seconds;
    }

    public function output(): string
    {
        return $this->fpdf->Output('S');
    }

    private function encode(string $text): string
    {
        return str_replace('€', chr(164), mb_convert_encoding($text, 'ISO-8859-15', 'UTF-8'));
    }
}
