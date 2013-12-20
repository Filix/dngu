<?php
namespace Dngu\WebBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;

class SettingController extends BaseController
{
    /**
     * 基本设置
     * @Secure(roles="ROLE_USER")
     * @Template()
     */
    public function basicAction(){
        return array();
    }
    
    /**
     * 病历设置
     * @Secure(roles="ROLE_USER")
     * @Template()
     */
    public function caseAction(){
        
    }
    
    /**
     * 个性设置
     * @Secure(roles="ROLE_USER")
     * @Template()
     */
    public function personalityAction(){
        
    }
    
    /**
     * 密码设置
     * @Secure(roles="ROLE_USER")
     * @Template()
     */
    public function passportAction(){
        
    }
    
    /**
     * 绑定设置
     * @Secure(roles="ROLE_USER")
     * @Template()
     */
    public function bindAction(){
        
    }
}
