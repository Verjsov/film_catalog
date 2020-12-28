<?php


namespace App\Service;


use App\Dto\MovieDto;
use App\Repository\MovieCatalogRepository;

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
            $this->movieCatalogRepository->save($movie);
            return $movie;
        }

        return $result->toDto();
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