<?php

namespace Dngu\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\UserInterface;

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

    public function __construct()
    {
        parent::__construct();
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
}