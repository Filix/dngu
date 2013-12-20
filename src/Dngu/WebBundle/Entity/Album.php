<?php

namespace Dngu\WebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="albums")
 * @ORM\Entity(repositoryClass="Dngu\WebBundle\Repository\AlbumRepository")
 */
class Album
{

    const DIARY_ALBUM_NAME = '日志相册';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $description;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $is_system = false;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $is_deleted = false;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created_at;
    
    /**
     * @ORM\Column(type="datetime")
     */
    protected $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity="Dngu\UserBundle\Entity\User", inversedBy="Albums")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="Statistics", inversedBy="Statistics")
     * @ORM\JoinColumn(name="statistics_id", referencedColumnName="id", nullable=false)
     */
    protected $statistics;
    
    /**
     * @ORM\OneToMany(targetEntity="Picture", mappedBy="album")
     */
    protected $pictures;

    public function __construct()
    {
        $this->updated_at = new \DateTime;
    }
    
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
     * Set name
     *
     * @param string $name
     * @return Album
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Album
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set is_system
     *
     * @param boolean $isSystem
     * @return Album
     */
    public function setIsSystem($isSystem)
    {
        $this->is_system = $isSystem;

        return $this;
    }

    /**
     * Get is_system
     *
     * @return boolean 
     */
    public function getIsSystem()
    {
        return $this->is_system;
    }

    /**
     * Set updated_at
     *
     * @param \DateTime $updatedAt
     * @return Album
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;

        return $this;
    }

    /**
     * Get updated_at
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Set user
     *
     * @param \Dngu\UserBundle\Entity\User $user
     * @return Album
     */
    public function setUser(\Dngu\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Dngu\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set statistics
     *
     * @param \Dngu\WebBundle\Entity\Statistics $statistics
     * @return Album
     */
    public function setStatistics(\Dngu\WebBundle\Entity\Statistics $statistics = null)
    {
        $this->statistics = $statistics;

        return $this;
    }

    /**
     * Get statistics
     *
     * @return \Dngu\WebBundle\Entity\Statistics 
     */
    public function getStatistics()
    {
        return $this->statistics;
    }
    
    public function getCommentCount(){
        return $this->getStatistics() ? $this->getStatistics()->getCommentCount() : 0;
    }
    
    public function getLikeCount(){
        return $this->getStatistics() ? $this->getStatistics()->getLikeCount() : 0;
    }
    
    public function getPictureCount(){
        return $this->getStatistics() ? $this->getStatistics()->getPictureCount() : 0;
    }


    /**
     * Set is_deleted
     *
     * @param boolean $isDeleted
     * @return Album
     */
    public function setIsDeleted($isDeleted)
    {
        $this->is_deleted = $isDeleted;
    
        return $this;
    }

    /**
     * Get is_deleted
     *
     * @return boolean 
     */
    public function getIsDeleted()
    {
        return $this->is_deleted;
    }

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return Album
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
    
        return $this;
    }

    /**
     * Get created_at
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }
}