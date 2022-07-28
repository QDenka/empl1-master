<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Image;
use App\Entity\News;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<News>
 *
 * @method News|null find($id, $lockMode = null, $lockVersion = null)
 * @method News|null findOneBy(array $criteria, array $orderBy = null)
 * @method News[]    findAll()
 * @method News[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, News::class);
    }

    public function add(News $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(News $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function createOrUpdate($newsDto)
    {
        $em = $this->getEntityManager();
        $categories = $em->getRepository(Category::class)
            ->createOrUpdate($newsDto->getCategories());
        foreach ($newsDto->getAll() as $news) {
            $newsItemInstance = new News();
            $newsItemInstance->setHeader($news->getHeader())
                // ->setImage($news->getImage())
                ->setDescription($news->getDescription())
                ->setCategory($category);
            // ->setNewsId($news->getNewsId());

            $image = new Image();
            $image->setNews($newsItemInstance);
            $image->setImage($news->getImage());

            $em->persist($newsItemInstance);
        }

        $em->flush();
        $em->clear();
    }
}
