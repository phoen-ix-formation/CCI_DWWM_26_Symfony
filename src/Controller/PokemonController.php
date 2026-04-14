<?php

namespace App\Controller;

use App\Entity\Pokemon;
use App\Entity\User;
use App\Form\PokemonCreateFormType;
use App\Repository\PokemonRepository;
use App\Repository\PokemonTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Knp\Component\Pager\PaginatorInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsCsrfTokenValid;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/pokemon', name: 'app_pokemon_')]
final class PokemonController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(PokemonRepository $pokemonRepository, PaginatorInterface $paginator, Request $request): Response
    {
        // Récupère la chaine dans l'URL pour la recherche par nom
        $strSearchName = $request->query->getString('search_name');

        // On utilise le repository pour construire la requête qui sera envoyée au paginator
        $query = $pokemonRepository->createPaginationQuery($strSearchName);

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /* page number */
            $request->query->getInt('perPage', 4) /* limit per page */
        );

        return $this->render('pokemon/index.html.twig', [
            'pagination'    => $pagination,
            'searchName'    => $strSearchName //< Renvoi à la vue pour l'afficher dans le champ
        ]);
    }

    #[Route('/create', name: 'create')]
    #[IsGranted('ROLE_USER')] //< Bloque la route, si pas le rôle ROLE_USER
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $objNewPokemon = new Pokemon();

        $createForm = $this->createForm(PokemonCreateFormType::class, $objNewPokemon);

        // J'envoi les données de la requête au formulaire
        $createForm->handleRequest($request);

        // Vérifie si le formulaire est soumiii et que les données sont valides
        if($createForm->isSubmitted() && $createForm->isValid()) {

            /** @var User Utilisateur connecté actuellement à l'application */
            $objCurrentUser = $this->getUser();

            $objNewPokemon->setCreatedBy($objCurrentUser); //< Indique l'utilisateur créateur

            $entityManager->persist($objNewPokemon);
            $entityManager->flush();

            // Affiche un message de succès
            $this->addFlash('success', "Le pokémon a bien été créé en base");

            // Redirige vers la page de détails du pokémon créé
            return $this->redirectToRoute('app_pokemon_show', [
                'id' => $objNewPokemon->getId()
            ]);
        }
        
        return $this->render('pokemon/form.html.twig', [
            'createForm'    => $createForm
        ]);
    }

    #[Route('/{id<\d+>}', name: 'show')]
    public function show(Pokemon $pokemon): Response
    {
        return $this->render('pokemon/show.html.twig', [
            /*'pokemon_id'    => $id,
            'pokemon'       => $objPokemon
            */
            'pokemon'       => $pokemon
        ]);
    }

    #[Route('/{id<\d+>}/update', name: 'update')] //< URL : /pokemon/1/update
    #[IsGranted('ROLE_USER')] //< Bloque la route, si pas le rôle ROLE_USER
    #[IsGranted('POKEMON_EDIT', subject: 'pokemon', message: "Droit insuffisant pour la modification")]
    public function update(Pokemon $pokemon, Request $request, EntityManagerInterface $entityManager): Response
    {
        // On construit le formulaire à partir des données de l'entité récupérée
        // depuis l'ID présent dans l'URL
        $updateForm = $this->createForm(PokemonCreateFormType::class, $pokemon);

        $updateForm->handleRequest($request);

        if($updateForm->isSubmitted() && $updateForm->isValid()) {

            // L'entité provenant déjà de la base, Doctrine la connait
            // => pas besoin de persist

            $entityManager->flush();

            $this->addFlash('success', "Le pokémon a bien été modifié en base");

            // Redirige vers la page de détails du pokémon modifié
            return $this->redirectToRoute('app_pokemon_show', [
                'id' => $pokemon->getId()
            ]);
        }

        return $this->render('pokemon/form.html.twig', [
            'createForm'    => $updateForm
        ]);
    }

    #[Route('/{id<\d+>}/delete', name: 'delete', methods: ['POST'])] //< URL : /pokemon/1/delete
    #[IsGranted('ROLE_USER')] //< Bloque la route, si pas le rôle ROLE_USER
    #[IsGranted('POKEMON_DELETE', subject: 'pokemon', message: "Droit insuffisant pour la suppression")]
    #[IsCsrfTokenValid('delete-pokemon', '_csrf_token')] //< 1: nom du token, 2: nom de l'input
    public function delete(Pokemon $pokemon, EntityManagerInterface $entityManager, Request $request, LoggerInterface $logger): Response
    {
        try {
            // DELETE .... FROM .... WHERE...
            $entityManager->remove($pokemon);
            $entityManager->flush();

            // Lorsque la suppresion est faite, on retourne à la liste
            $this->addFlash('success', "Le pokémon a été supprimé");
        }
        catch(Exception $exc) {
            
            $this->addFlash('danger', "Une erreur est survenue. Réessayez");

            // On écrit dans le fichier de log le détail de l'erreur
            $logger->error($exc->getMessage());
        }

        return $this->redirectToRoute('app_pokemon_index');
    }
}
