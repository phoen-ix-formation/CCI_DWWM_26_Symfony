<?php

namespace App\Controller;

use App\Entity\Picture;
use App\Form\PictureCreateFormType;
use App\Repository\PictureRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/picture', name: 'app_picture_')]
final class PictureController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(PictureRepository $pictureRepository): Response
    {
        $arrPictures = $pictureRepository->findAll();

        return $this->render('picture/index.html.twig', [
            'pictures'  => $arrPictures    
        ]);
    }
    
    #[Route('/create', name: 'create')]
    public function create(Request $request, EntityManagerInterface $entityManager,
        #[Autowire('%kernel.project_dir%/public/uploads/pictures')] string $pictureDirectory): Response
    {
        $objPicture = new Picture();

        $formCreate = $this->createForm(PictureCreateFormType::class, $objPicture);

        $formCreate->handleRequest($request);

        if($formCreate->isSubmitted() && $formCreate->isValid()) {

            /** @var UploadedFile $objUploadedFile */
            $objUploadedFile = $formCreate->get('filename')->getData();

            // Déplace le fichier dans le répertoire /public/uploads/pictures
            $objUploadedFile->move($pictureDirectory, $objUploadedFile->getClientOriginalName());

            // Définit les attributs de l'entité Picture
            $objPicture->setFilename($objUploadedFile->getClientOriginalName())
                ->setCreatedAt(new DateTimeImmutable('now'))
                ->setTakenBy($this->getUser()); //< $this->getUser() : récupère l'utlisateur connecté à l'application

            $entityManager->persist($objPicture);
            $entityManager->flush();

            $this->addFlash('success', "La photo a bien été enregistrée");

            return $this->redirectToRoute('app_picture_index');
        }

        return $this->render('picture/create.html.twig', [
            'formCreate'    => $formCreate
        ]);
    }
}
