<?php

namespace App\Repository;

use App\Dto\MovieDto;
use App\Entity\MovieCatalog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MovieCatalog|null find($id, $lockMode = null, $lockVersion = null)
 * @method MovieCatalog|null findOneBy(array $criteria, array $orderBy = null)
 * @method MovieCatalog[]    findAll()
 * @method MovieCatalog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovieCatalogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MovieCatalog::class);
    }

    public function findLikeTitle(string $title): ?MovieCatalog
    {
        $qb = $this->createQueryBuilder('m');
        $query = $qb->where($qb->expr()->like('m.title', ':title'))
            ->setParameter('title', '%'.$title.'%')
            ->getQuery();
        return $query->getOneOrNullResult();
    }

    public function setFavorite(string $imdb): void
    {
        $qb = $this->createQueryBuilder('m');
        $qb->update()
            ->set('m.favorite',$qb->expr()->literal('Y'))
            ->where('m.imdbId = :imdb')
            ->setParameter('imdb',$imdb)
            ->getQuery()
            ->execute();
    }

    public function delFavorite(string $imdb): void
    {
        $qb = $this->createQueryBuilder('m');
        $qb->update()
            ->set('m.favorite',$qb->expr()->literal('N'))
            ->where('m.imdbId = :imdb')
            ->setParameter('imdb', $imdb)
            ->getQuery()
            ->execute();
    }

    public function getAll(): array
    {
        $qb = $this->createQueryBuilder('m');
        return $qb->select()
            ->getQuery()
            ->execute();

    }

    public function getAllCount(): int
    {
        $qb = $this->createQueryBuilder('m');
        return $qb->select('count(m.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getAllFavorite($state): array
    {
        $qb = $this->createQueryBuilder('m');
        return $qb->select()
            ->where('m.favorite = :state')
            ->setParameter('state', $state)
            ->getQuery()
            ->execute();
    }

    public function delFromCatalog($imdb): void
    {
        $qb = $this->createQueryBuilder('m');
        $qb->delete()
            ->where('m.imdbId = :imdb')
            ->setParameter('imdb', $imdb)
            ->getQuery()
            ->execute();
    }

    public function save(MovieDto $movieDto)
    {
        $movie = new MovieCatalog();
        $movie->setTitle($movieDto->title)
            ->setDirector($movieDto->director)
            ->setImdbId($movieDto->imdbId)
            ->setPlot($movieDto->plot)
            ->setPoster($movieDto->poster)
            ->setReleased(new \DateTime($movieDto->release))
            ->setType($movieDto->type)
            ->setYear($movieDto->year)
            ->setFavorite($movieDto->favorite)
            ->setCatalog($movieDto->catalog);
        $this->getEntityManager()->persist($movie);
        $this->getEntityManager()->flush();
    }
}
