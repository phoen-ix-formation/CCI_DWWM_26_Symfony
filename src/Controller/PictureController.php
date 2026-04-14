<?php

namespace App\Controller;

use App\Entity\Picture;
use App\Form\PictureCreateFormType;
use App\Form\PictureUpdateFormType;
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

            // Création d'un nom unique pour l'image (le fichier final)

            // On récupère le nom du fichier sans l'extension (.png, .jpg...)
            $strBasefileName = pathinfo($objUploadedFile->getClientOriginalName(), PATHINFO_FILENAME);

            // On accolle uniqid pour rendre unique le nom + l'extension du fichier (PNG, JPG...)
            $strNewFilename = $strBasefileName . uniqid() . '.' . $objUploadedFile->guessExtension();

            // Déplace le fichier dans le répertoire /public/uploads/pictures
            $objUploadedFile->move($pictureDirectory, $strNewFilename);

            // Définit les attributs de l'entité Picture
            $objPicture->setFilename($strNewFilename)
                ->setCreatedAt(new DateTimeImmutable('now'))
                ->setTakenBy($this->getUser()); //< $this->getUser() : récupère l'utlisateur connecté à l'application

            $entityManager->persist($objPicture);
            $entityManager->flush();

            $this->addFlash('success', "La photo a bien été enregistrée");

            return $this->redirectToRoute('app_picture_index');
        }

        return $this->render('picture/form.html.twig', [
            'form'      => $formCreate,
            'title'     => 'Déposer une nouvelle photo'
        ]);
    }

    #[Route('/{id<\d+>}/update', name: 'update')]
    public function update(Picture $picture, Request $request, EntityManagerInterface $entityManager): Response
    {
        $formUpdate = $this->createForm(PictureUpdateFormType::class, $picture);

        $formUpdate->handleRequest($request);

        if($formUpdate->isSubmitted() && $formUpdate->isValid()) {

            $entityManager->flush();

            $this->addFlash('success', "La photo a bien été modifiée");

            return $this->redirectToRoute('app_picture_index');
        }

        return $this->render('picture/form.html.twig', [
            'form'      => $formUpdate,
            'title'     => "Modifier une photo"
        ]);
    }
}
