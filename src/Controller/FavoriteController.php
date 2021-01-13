<?php

namespace App\Controller;

use App\Entity\MovieCatalog;
use App\Service\CatalogServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FavoriteController extends AbstractController
{
    /**
     * @Route("/favorite/add/{imdb}", name="addFavorite")
     * @param CatalogServiceInterface $catalogService
     * @return Response
     */
    public function add(CatalogServiceInterface $catalogService,$imdb): Response
    {
        $res = $catalogService->addToFavorite($imdb);
        return $this->json($res);
    }
    /**
     * @Route("/favorite/del/{imdb}", name="delFavorite")
     * @param CatalogServiceInterface $catalogService
     * @return Response
     */
    public function del(CatalogServiceInterface $catalogService,$imdb): Response
    {
        $res = $catalogService->delToFavorite($imdb);
        return $this->json($res);
    }

    /**
     * @Route("/favorites", name="allFavorite")
     * @param CatalogServiceInterface $catalogService
     * @return Response
     */
    public function all(CatalogServiceInterface $catalogService): Response
    {
        $res = $catalogService->getAllFavoriteFilms('Y');
        return $this->render('favorite/favorite.html.twig', [
            'result' => $res,
        ]);
    }
}
