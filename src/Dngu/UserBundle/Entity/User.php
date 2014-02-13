<?php

namespace Dngu\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="Dngu\UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\OneToMany(targetEntity="Oauth", mappedBy="user")
     */
    protected $oauths;
    
    /**
     * @ORM\OneToMany(targetEntity="Dngu\WebBundle\Entity\Album", mappedBy="user")
     */
    protected $albums;

    /**
     * @ORM\OneToMany(targetEntity="Dngu\WebBundle\Entity\Picture", mappedBy="user")
     */
    protected $pictures;
    
    public function __construct()
    {
        parent::__construct();
        $this->oauths = new ArrayCollection();
        $this->pictures = new ArrayCollection();
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
    
    public function getSlugOrId(){
        return $this->getId();
//        return $this->slug ? $this->slug : $this->id;
    }

    /**
     * Add oauths
     *
     * @param \Dngu\UserBundle\Entity\Oauth $oauths
     * @return User
     */
    public function addOauth(\Dngu\UserBundle\Entity\Oauth $oauths)
    {
        $this->oauths[] = $oauths;
    
        return $this;
    }

    /**
     * Remove oauths
     *
     * @param \Dngu\UserBundle\Entity\Oauth $oauths
     */
    public function removeOauth(\Dngu\UserBundle\Entity\Oauth $oauths)
    {
        $this->oauths->removeElement($oauths);
    }

    /**
     * Get oauths
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOauths()
    {
        return $this->oauths;
    }

    /**
     * Add albums
     *
     * @param \Dngu\WebBundle\Entity\Album $albums
     * @return User
     */
    public function addAlbum(\Dngu\WebBundle\Entity\Album $albums)
    {
        $this->albums[] = $albums;
    
        return $this;
    }

    /**
     * Remove albums
     *
     * @param \Dngu\WebBundle\Entity\Album $albums
     */
    public function removeAlbum(\Dngu\WebBundle\Entity\Album $albums)
    {
        $this->albums->removeElement($albums);
    }

    /**
     * Get albums
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAlbums()
    {
        return $this->albums;
    }

    /**
     * Add pictures
     *
     * @param \Dngu\WebBundle\Entity\Picture $pictures
     * @return User
     */
    public function addPicture(\Dngu\WebBundle\Entity\Picture $pictures)
    {
        $this->pictures[] = $pictures;
    
        return $this;
    }

    /**
     * Remove pictures
     *
     * @param \Dngu\WebBundle\Entity\Picture $pictures
     */
    public function removePicture(\Dngu\WebBundle\Entity\Picture $pictures)
    {
        $this->pictures->removeElement($pictures);
    }

    /**
     * Get pictures
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPictures()
    {
        return $this->pictures;
    }
}