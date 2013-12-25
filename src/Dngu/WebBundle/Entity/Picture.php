<?php
namespace Dngu\WebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="pictures")
 * @ORM\Entity(repositoryClass="Dngu\WebBundle\Repository\PictureRepository")
 */
class Picture
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    protected $name;
    
    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $description;
    
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
     * @ORM\ManyToOne(targetEntity="Statistics", inversedBy="Statistics")
     * @ORM\JoinColumn(name="statistics_id", referencedColumnName="id", nullable=false)
     */
    protected $statistics;
    
    /**
     * @ORM\ManyToOne(targetEntity="Album", inversedBy="Album")
     * @ORM\JoinColumn(name="album_id", referencedColumnName="id", nullable=false)
     */
    protected $album;

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
     * @return Picture
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
     * @return Picture
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
     * Set is_deleted
     *
     * @param boolean $isDeleted
     * @return Picture
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
     * @return Picture
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

    /**
     * Set updated_at
     *
     * @param \DateTime $updatedAt
     * @return Picture
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
     * Set statistics
     *
     * @param \Dngu\WebBundle\Entity\Statistics $statistics
     * @return Picture
     */
    public function setStatistics(\Dngu\WebBundle\Entity\Statistics $statistics)
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

    /**
     * Set album
     *
     * @param \Dngu\WebBundle\Entity\Album $album
     * @return Picture
     */
    public function setAlbum(\Dngu\WebBundle\Entity\Album $album)
    {
        $this->album = $album;
    
        return $this;
    }

    /**
     * Get album
     *
     * @return \Dngu\WebBundle\Entity\Album 
     */
    public function getAlbum()
    {
        return $this->album;
    }
}