<?php

namespace BlogApp\BlogBundle\Repository;

use BlogApp\BlogBundle\Entity\Post;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class PostRepository extends EntityRepository
{

    /**
     * @param $page
     * @return Paginator
     */
    public function getPostsByPage($page)
    {
        $qb = $this->getEntityManager()
                    ->createQueryBuilder();

        $qb->select('p')
            ->from('BlogApp\BlogBundle\Entity\Post', 'p')
            ->orderBy('p.lastUpdate', 'DESC')
            ->setFirstResult(($page-1) * Post::POSTS_PER_PAGE)
            ->setMaxResults(Post::POSTS_PER_PAGE);

        return new Paginator($qb->getQuery());
    }

}
