<?php

namespace App\Controller;

use App\Entity\Bebe;
use App\Entity\Contrat;
use App\Entity\Fiche;
use App\Entity\Nounou;
use App\Form\FicheType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Http\PdfResponse;
use App\Service\PdfGenerator;

final class MainController extends AbstractController
{

    #[Route('/', name: 'app_main')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {



        return $this->render('main/index.html.twig', [
        ]);
    }

    #[Route('/fichedepaie/list', name: 'app_fichedepaie_list')]
    public function listFiches(EntityManagerInterface $em): Response
    {
        $fiches = $em->getRepository(Fiche::class)->findAll();
        return $this->render('main/list_fiches.html.twig', [
            'fiches' => $fiches,
        ]);
    }


    public function download(EntityManagerInterface $em, Fiche $fiche)
    {


    }

    #[Route('/fichedepaie/creation', name: 'app_fichedepaie_creation')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $fiche = new Fiche();
        $dateStart = new \DateTime();
        $dateEnd = new \DateTime();

        //valeur par default
        $dateStart->modify('first day of this month');
        $dateEnd->modify('last day of this month');
        $fiche
            ->setDateDebut($dateStart)
            ->setDateFin($dateEnd)
            ->setHeuresNormalMensuel(135)
            ->setHeuresMajoreesMensuel(0)
            ->setMontantDeductionPeriodeAbs(0)
            ->setMontantDivers(0)
            ->setMontantConges(0)
        ;


        $form = $this->createForm(FicheType::class, $fiche);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Mise a jour effectuée avec succes');
            $em->persist($fiche);
            $em->flush();
        }


        return $this->render('main/creation_fiche.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/fichedepaie/edition/{id}', name: 'app_fichedepaie_edition')]
    public function edit(Request $request, EntityManagerInterface $em, Fiche $fiche): Response
    {
        $dateStart = new \DateTime();
        $dateEnd = new \DateTime();

        $dateStart->modify('first day of this month');
        $dateEnd->modify('last day of this month');

        if (!$fiche->getDateDebut()) {
            $fiche->setDateDebut($dateStart);
        }
        if (!$fiche->getDateFin()) {
            $fiche->setDateFin($dateEnd);
        }

        $fiche
            ->setHeuresNormalMensuel(135)
            ->setHeuresMajoreesMensuel(0)
            ->setMontantDeductionPeriodeAbs(0)
            ->setMontantDivers(0)
            ->setMontantConges(0)

        ;

        $form = $this->createForm(FicheType::class, $fiche);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Mise a jour effectuée avec succes');
            $em->persist($fiche);
            $em->flush();
        }


        return $this->render('main/creation_fiche.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/fichedepaie/download/{id}', name: 'app_fichedepaie_download')]
    public function generationFiche(Request $request,EntityManagerInterface $em, Fiche $fiche): Response
    {
        define('FPDF_FONTPATH', $this->getParameter('kernel.project_dir').'/public/font/');
        $pdf = new \FPDF('P', 'mm', 'A4');
        $pdf->AddFont('DejaVuSerif', '', 'DejaVuSerif.php');
        $pdf->AddFont('DejaVuSerif', 'B', 'DejaVuSerif-Bold.php');
        $pdf->AddPage();

        $contrat = $em->getRepository(Contrat::class)->find(1);
        $nounou = $em->getRepository(Nounou::class)->find(1);
        $bebe = $em->getRepository(Bebe::class)->find(1);

        $generatePdf = new PdfGenerator($pdf, $fiche, $contrat, $nounou, $bebe);

        return PdfResponse::download($generatePdf->output(), \sprintf('fiche_%s.pdf', new \DateTime()->format('Ymd')));
    }
}
