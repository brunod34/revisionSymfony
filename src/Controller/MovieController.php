<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Movie as MovieEntity;
use App\Entity\Comment as CommentEntity ;
use App\Form\CommentType;
use App\Form\MovieType;
use App\Model\Movie;
use App\Repository\MovieRepository;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    #[Route(
        path: '/movies',
        name: 'app_movie_list',
        methods: ['GET']
    )]
    public function list(MovieRepository $movieRepository): Response
    {
        $movies = Movie::fromEntities($movieRepository->listAll());

        return $this->render('movie/list.html.twig', [
            'movies' => $movies,
        ]);
    }

    #[Route(
        path: '/movies/{slug}',
        name: 'app_movie_details',
        requirements: [
            'slug' => MovieEntity::SLUG_FORMAT,
        ],
        methods: ['GET']
    )]
    public function details(MovieRepository $movieRepository, string $slug): Response
    {
        $movie = Movie::fromEntity($movieRepository->getBySlug($slug));

        return $this->render('movie/details.html.twig', [
            'movie' => $movie,
        ]);
    }

    #[Route(
        path: '/movies/new',
        name: 'app_movie_new',
        methods: ['GET', 'POST']
    )]
    #[Route(
        path: '/movies/{slug}/edit',
        name: 'app_movie_edit',
        requirements: [
            'slug' => MovieEntity::SLUG_FORMAT,
        ],
        methods: ['GET', 'POST']
    )]
    public function newOrEdit(Request $request, MovieRepository $movieRepository, string|null $slug = null): Response
    {
        $movieEntity = new MovieEntity();
        if (null !== $slug) {
            $movieEntity = $movieRepository->getBySlug($slug);
        }

        $movieForm = $this->createForm(MovieType::class, $movieEntity);
        $movieForm->handleRequest($request);

        if ($movieForm->isSubmitted() && $movieForm->isValid()) {
            $movieRepository->save($movieEntity, true);

            return $this->redirectToRoute('app_movie_details', ['slug' => $movieEntity->getSlug()]);
        }

        return $this->render('movie/new_or_edit.html.twig', [
            'movie_form' => $movieForm,
            'editing_movie' => null !== $slug ? $movieEntity : null,
        ]);
    }


    #[Route(
        path: '/movies/{slug}/comment',
        name: 'app_movie_comment',
        requirements: [
            'slug' => MovieEntity::SLUG_FORMAT,
        ],
        methods: ['GET', 'POST']
    )]
    public function SeeComment(): Response
    {
        $commentEntity = new CommentEntity;
        

        $commentEntity
        ->setText('voici le commentaire')
        ->setScore('1')
        ->setReleasedAt(new DateTimeImmutable());

        $commentForm = $this->createForm(CommentType::class, $commentEntity);

        
        return $this->render('comment/index.html.twig', [
            'commentForm' => $commentForm,
            'title' => 'All comments',
            'comment' => $commentEntity,
        ]);
    }

}
