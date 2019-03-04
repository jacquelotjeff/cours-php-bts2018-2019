<?php

namespace AppBundle\Service;

use AppBundle\Entity\Article;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ArticleManager
{
    private $doctrine;

    public function __construct(RegistryInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function dernierArticle(): ?Article
    {
        $articleRep = $this->doctrine->getRepository(Article::class);

        return $articleRep->findOneBy([], ['id' => 'DESC']);
    }
}