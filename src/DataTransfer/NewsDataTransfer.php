<?php

namespace App\DataTransfer;

use App\Entity\News;
use App\Repository\NewsRepository;
use Doctrine\ORM\EntityManagerInterface;

class NewsDataTransfer
{
    private static array $news = [];
    private array $categories;
    private string $header, $description, $category;
    private ?string $image = null;
    private int $newsId;
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function push(): void
    {
        array_push(self::$news, $this);
    }

    public function getCategories()
    {
        return array_unique($this->categories);
    }

    public function getAll()
    {
        return self::$news;
    }

    public function setHeader(string $header)
    {
        $this->header = $header;
        return $this;
    }

    public function getHeader()
    {
        return $this->header;
    }

    public function setImage(?string $image = null)
    {
        $this->image = $image;
        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setCategory($category)
    {
        $this->categories[] = $category;
        $this->category = $category;
        return $this;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setDescription(string $description)
    {
        $this->description = $description;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setNewsId(int $newsId)
    {
        $this->newsId = $newsId;
        return $this;
    }

    public function getNewsId(): int
    {
        return $this->newsId;
    }

    public function save()
    {
        $this->em->getRepository(News::class)
            ->createOrUpdate($this);
    }
}
