<?php

namespace Dngu\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="oauths")
 * @ORM\Entity(repositoryClass="Dngu\UserBundle\Repository\OauthRepository")
 */
class Oauth
{
    const WEIBO_TYPE = 1;
    const TQQ_TYPE = 2;
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="smallint")
     */
    protected $type;
    
    /**
     * @ORM\Column(type="string", length=32, nullable=false)
     */
    protected $access_token;
    
    /**
     * @ORM\Column(type="string", nullable=false, length=32)
     */
    protected $uid;
    
    /**
     * @ORM\Column(type="string", nullable=true, length=32)
     */
    protected $refresh_token;
    
    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $expires_in;
    
    /**
     * @ORM\Column(type="json_array", nullable=false)
     */
    protected $data;
    
    /**
     * @ORM\Column(type="datetime")
     */
    protected $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="oauths")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

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
     * @return Oauth
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
     * Set access_token
     *
     * @param string $accessToken
     * @return Oauth
     */
    public function setAccessToken($accessToken)
    {
        $this->access_token = $accessToken;
    
        return $this;
    }

    /**
     * Get access_token
     *
     * @return string 
     */
    public function getAccessToken()
    {
        return $this->access_token;
    }

    /**
     * Set uid
     *
     * @param string $uid
     * @return Oauth
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
    
        return $this;
    }

    /**
     * Get uid
     *
     * @return string 
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * Set fresh_token
     *
     * @param string $freshToken
     * @return Oauth
     */
    public function setRefreshToken($freshToken)
    {
        $this->refresh_token = $freshToken;
    
        return $this;
    }

    /**
     * Get fresh_token
     *
     * @return string 
     */
    public function getRefreshToken()
    {
        return $this->fresh_token;
    }

    /**
     * Set expires_in
     *
     * @param integer $expiresIn
     * @return Oauth
     */
    public function setExpiresIn($expiresIn)
    {
        $this->expires_in = $expiresIn;
    
        return $this;
    }

    /**
     * Get expires_in
     *
     * @return integer 
     */
    public function getExpiresIn()
    {
        return $this->expires_in;
    }

    /**
     * Set data
     *
     * @param array $data
     * @return Oauth
     */
    public function setData($data)
    {
        $this->data = $data;
    
        return $this;
    }

    /**
     * Get data
     *
     * @return array 
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set updated_at
     *
     * @param \DateTime $updatedAt
     * @return Oauth
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
     * @return Oauth
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
    
    public function update($oauth)
    {
        $this->setAccessToken($oauth['access_token']);
        $this->setExpiresIn($oauth['expires_in']);
        $this->setData($oauth['data']);
        $this->setType($oauth['type']);
        $this->setUid($oauth['uid']);
        if(isset($oauth['refresh_token'])){
            $this->setRefreshToken($oauth['refresh_token']);
        }
        $this->setUpdatedAt(new \DateTime());
    }
}