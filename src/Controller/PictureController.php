<?php

namespace App\Controller;

use App\Entity\Picture;
use App\Entity\Pokemon;
use App\Form\PictureCreateFormType;
use App\Form\PictureUpdateFormType;
use App\Repository\PictureRepository;
use App\Service\FileUploader;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsCsrfTokenValid;

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
        FileUploader $fileUploader): Response
    {
        $objPicture = new Picture();

        $formCreate = $this->createForm(PictureCreateFormType::class, $objPicture);

        $formCreate->handleRequest($request);

        if($formCreate->isSubmitted() && $formCreate->isValid()) {

            /** @var UploadedFile $objUploadedFile */
            $objUploadedFile = $formCreate->get('filename')->getData();

            // Création d'un nom unique pour l'image (le fichier final)
            /*
            // On récupère le nom du fichier sans l'extension (.png, .jpg...)
            $strBasefileName = pathinfo($objUploadedFile->getClientOriginalName(), PATHINFO_FILENAME);

            // On accolle uniqid pour rendre unique le nom + l'extension du fichier (PNG, JPG...)
            $strNewFilename = $strBasefileName . uniqid() . '.' . $objUploadedFile->guessExtension();

            // Déplace le fichier dans le répertoire /public/uploads/pictures
            $objUploadedFile->move($pictureDirectory, $strNewFilename);
            */

            // On utilise le service plutôt que de faire les opérations dans le contrôleur
            $strNewFilename = $fileUploader->upload($objUploadedFile);

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

    #[Route('/create/pokemon/{id<\d+>}', name: 'create_pokemon')] //< /picture/create/pokemon/51
    public function createForPokemon(Pokemon $pokemon, Request $request, 
        EntityManagerInterface $entityManager, FileUploader $fileUploader): Response
    {
        $objPicture = new Picture();

        // Associe le pokémon récupéré via l'URL à la photo qui va être créée
        $objPicture->setPokemon($pokemon);

        $formCreate = $this->createForm(PictureCreateFormType::class, $objPicture);

        $formCreate->handleRequest($request);

        if($formCreate->isSubmitted() && $formCreate->isValid()) {

            /** @var UploadedFile $objUploadedFile */
            $objUploadedFile = $formCreate->get('filename')->getData();
            
            // On utilise le service plutôt que de faire les opérations dans le contrôleur
            $strNewFilename = $fileUploader->upload($objUploadedFile);

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

    #[Route('/{id<\d+>}/delete', name: 'delete', methods: ['POST'])] //< URL : /picture/1/delete
    #[IsCsrfTokenValid('delete-picture', '_csrf_token')] //< 1: nom du token, 2: nom de l'input
    public function delete(Picture $picture, EntityManagerInterface $entityManager, 
        Request $request, LoggerInterface $logger, FileUploader $fileUploader): Response
    {
        try {
            // DELETE .... FROM .... WHERE...
            $entityManager->remove($picture);

            // On utilise le FileUploader pour supprimer le fichier et pas uniquement l'entrée dans la BDD
            $fileUploader->remove($picture->getFilename());

            $entityManager->flush();

            // Lorsque la suppresion est faite, on retourne à la liste
            $this->addFlash('success', "La photo a été supprimée");
        }
        catch(Exception $exc) {
            
            $this->addFlash('danger', "Une erreur est survenue. Réessayez");

            // On écrit dans le fichier de log le détail de l'erreur
            $logger->error($exc->getMessage());
        }

        return $this->redirectToRoute('app_picture_index');
    }
}
