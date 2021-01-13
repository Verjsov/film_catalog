<?php

namespace App\Controller;

use App\Entity\MovieCatalog;
use App\Service\CatalogServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CatalogController extends AbstractController
{
    /**
     * @Route("/catalogs", name="allCatalog")
     * @param CatalogServiceInterface $catalogService
     * @return Response
     */
    public function all(CatalogServiceInterface $catalogService): Response
    {
        $res = $catalogService->getAllDbFilms();
        return $this->render('catalog/catalog.html.twig', [
            'result' => $res,
        ]);
    }

    /**
     * @Route("/catalogs/dell/{imdb}", name="delFilm")
     * @param CatalogServiceInterface $catalogService
     * @return Response
     */
    public function dell(CatalogServiceInterface $catalogService,$imdb): Response
    {
        $res = $catalogService->dellFromCatalogFilms($imdb);
        return $this->json($res);
    }

    /**
     * @Route("/", name="title")
     * @param CatalogServiceInterface $catalogService
     * @return Response
     */
    public function index(CatalogServiceInterface $catalogService): Response
    {
        $res = $catalogService->getCountAllDbFilms();
        return $this->render('index/index.html.twig', [
            'result' => ['count'=>$res],
        ]);
    }

}
