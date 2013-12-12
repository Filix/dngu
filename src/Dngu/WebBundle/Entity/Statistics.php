<?php

namespace Dngu\WebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="statistics")
 * @ORM\Entity(repositoryClass="Dngu\WebBundle\Repository\AlbumRepository")
 */
class Statistics
{
    const ALBUM_TYPE = 0;
    const DIARY_TYPE = 1;
    const PICTURE_TYPE = 2;
    const FEED_TYPE = 3;
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="smallint", nullable=false)
     */
    protected $type;
    
    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $object_id;
    
    /**
     * @ORM\Column(type="smallint")
     */
    protected $comment_count = 0;
    
    /**
     * @ORM\Column(type="smallint")
     */
    protected $like_count = 0;
    /**
     * @ORM\Column(type="smallint")
     */
    protected $picture_count = 0;


    

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return Statistics
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set object_id
     *
     * @param integer $objectId
     * @return Statistics
     */
    public function setObjectId($objectId)
    {
        $this->object_id = $objectId;
    
        return $this;
    }

    /**
     * Get object_id
     *
     * @return integer 
     */
    public function getObjectId()
    {
        return $this->object_id;
    }

    /**
     * Set comment_count
     *
     * @param integer $commentCount
     * @return Statistics
     */
    public function setCommentCount($commentCount)
    {
        $this->comment_count = $commentCount;
    
        return $this;
    }

    /**
     * Get comment_count
     *
     * @return integer 
     */
    public function getCommentCount()
    {
        return $this->comment_count;
    }

    /**
     * Set like_count
     *
     * @param integer $likeCount
     * @return Statistics
     */
    public function setLikeCount($likeCount)
    {
        $this->like_count = $likeCount;
    
        return $this;
    }

    /**
     * Get like_count
     *
     * @return integer 
     */
    public function getLikeCount()
    {
        return $this->like_count;
    }

    /**
     * Set picture_count
     *
     * @param integer $pictureCount
     * @return Statistics
     */
    public function setPictureCount($pictureCount)
    {
        $this->picture_count = $pictureCount;
    
        return $this;
    }

    /**
     * Get picture_count
     *
     * @return integer 
     */
    public function getPictureCount()
    {
        return $this->picture_count;
    }
}