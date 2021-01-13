<?php


namespace App\Service;


use App\Dto\MovieDto;
use App\Repository\MovieCatalogRepository;
use PhpParser\Node\Expr\Array_;

class CatalogService implements CatalogServiceInterface
{
    private $movieCatalogRepository;
    private $omdbService;

    public function __construct(MovieCatalogRepository $movieCatalogRepository, OmdbServiceInterface $omdbService)
    {
        $this->movieCatalogRepository = $movieCatalogRepository;
        $this->omdbService = $omdbService;
    }
    /**
     * Search film by title
     *
     * @param string $title
     * @return MovieDto|null
     */
    public function search(string $title): ?MovieDto
    {
        $result = $this->movieCatalogRepository->findLikeTitle($title);
        if (!$result) {
            $movie = $this->omdbService->findByTitle($title);
            if ($movie !== null){
                $this->movieCatalogRepository->save($movie);
                return $movie;
            } else {
                return null;
            }
        }
        return $result->toDto();
    }

    public function addToFavorite(string $imdb): array
    {
        $this->movieCatalogRepository->setFavorite($imdb);
        return ['result'=>'ok'];
    }

    public function delToFavorite(string $imdb): array
    {
        $this->movieCatalogRepository->delFavorite($imdb);
        return ['result'=>'ok'];
    }

    public function getAllDbFilms(): array
    {
       return $this->movieCatalogRepository->getAll();
    }

    public function getCountAllDbFilms(): int
    {
        return $this->movieCatalogRepository->getAllCount();
    }

    public function getAllFavoriteFilms($state): array
    {
        return $this->movieCatalogRepository->getAllFavorite($state);
    }

    public function dellFromCatalogFilms($imdb): array
    {
        $this->movieCatalogRepository->delFromCatalog($imdb);
        return ['result'=>'ok'];
    }



    /**
     * Add film to catalog.
     *
     * @param MovieDto $movieDto
     * @return mixed
     */
    public function add(MovieDto $movieDto)
    {
        // TODO: Implement add() method.
    }

}