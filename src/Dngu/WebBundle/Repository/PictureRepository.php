<?php

namespace Dngu\WebBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Dngu\WebBundle\Entity\Album;

class PictureRepository extends EntityRepository
{
     public function getAlbumPicturesQuery(Album $album)
    {
        return $this->getEntityManager()
                        ->createQueryBuilder()
                        ->select('a')
                        ->from('DnguWebBundle:Picture', 'p')
                        ->where('p.album = :album')
                        ->andWhere('p.is_deleted = 0')
                        ->getQuery()
                        ->setParameter('album', $album);
    }
}
