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
    protected $is_delete = false;


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
     * @ORM\JoinColumn(name="statistics_id", referencedColumnName="id")
     */
    protected $statistics;

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
     * Set is_delete
     *
     * @param boolean $isDelete
     * @return Album
     */
    public function setIsDelete($isDelete)
    {
        $this->is_delete = $isDelete;
    
        return $this;
    }

    /**
     * Get is_delete
     *
     * @return boolean 
     */
    public function getIsDelete()
    {
        return $this->is_delete;
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
     * @param \Dngu\WebBundle\Entity\User $user
     * @return Album
     */
    public function setUser(\Dngu\WebBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Dngu\WebBundle\Entity\User 
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
}