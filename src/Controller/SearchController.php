<?php

namespace App\Controller;

use App\Service\CatalogServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     * @param CatalogServiceInterface $catalogService
     * @return Response
     */
    public function index(Request $request,CatalogServiceInterface $catalogService): Response
    {
        $name = $request->request->get('film_name') ?? $request->query->get('film_name') ?? '';
        if ($name){
            $result = $catalogService->search($name);
            if ($result === null){
                $result = ['err' => true,'msg' => 'Фильм не найден, попробуйте еще раз!'];
            }
        } else {
            $result = ['err' => true,'msg' => 'Передана пустая строка, попробуйте еще раз!'];
        }
        return $this->render('search/search.html.twig', [
            'result' => $result,
        ]);
    }
}
