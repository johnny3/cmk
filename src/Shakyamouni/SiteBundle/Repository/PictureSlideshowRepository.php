<?php

namespace Shakyamouni\SiteBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * SlideShowRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PictureSlideshowRepository extends EntityRepository {

    public function getPicturesBySlideShowAndPositionOrder()
    {
        $qb = $this->createQueryBuilder('p')
                ->leftJoin('p.slideshow', 'c')
                ->addSelect('c')
                ->OrderBy('p.slideshow', 'ASC')
                ->addOrderBy('p.position', 'ASC');

        return $qb->getQuery()
                        ->getResult();
    }

}
