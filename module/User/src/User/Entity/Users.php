<?php

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

use Docttine\Common\Annotations\AnnotationRegistry;


/** 
* @ORM\Entity 
* @ORM\Table(name="users")
* @Annotation\Name("Users")
*/
class Users
{
    /** 
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    * @ORM\Column(type="integer",name="u_id") 
    */
    protected $id;

    /** 
    * @ORM\Column(type="string") 
    */
    protected $u_email;

    /** 
    * @ORM\Column(type="string") 
    */
    protected $u_password;

    /** 
    * @ORM\Column(type="string") 
    */
    protected $u_type;

    /** 
    * @ORM\Column(type="string") 
    */
    protected $u_channels;

    /** 
    * @ORM\Column(type="string") 
    */
    protected $u_products;

    /** 
    * @ORM\Column(type="string") 
    */
    protected $u_nickname;

    /** 
    * @ORM\Column(type="string") 
    */
    protected $u_mobile_phone;

    /** 
    * @ORM\Column(type="string") 
    */
    protected $u_fixed_phone;

    /** 
    * @ORM\Column(type="string") 
    */
    protected $u_wechat;

    /** 
    * @ORM\Column(type="datetime",nullable=false)
    */
    protected $u_creation;   
    
    /** 
    * @ORM\Column(type="boolean")
    */
    protected $u_deleted;

    public function setId($id) 
    {
        $this->id = $id;
    }

    public function getId() 
    {
        return $this->id;
    }

    public function setUEmail($email) 
    {
        $this->u_email = $email;
    }

    public function getUEmail() 
    {
        return $this->u_email;
    }

    public function setUPassword($password) 
    {
        $this->u_password = $password;
    }

    public function getUPassword() 
    {
        return $this->u_password;
    }

    public function setUType($type)
    {
        $this->u_type = $type;
    }

    public function getUType() 
    {
        return $this->u_type;
    }

    public function setUChannels($channels) 
    {
        $this->u_channels = $channels;
    }

    public function getUChannels() 
    {
        return $this->u_channels;
    }

    public function setUProducts($products) 
    {
        $this->u_products = $products;
    }

    public function getUProducts() 
    {
        return $this->u_products;
    }

    public function setUNickname($nickname) 
    {
        $this->u_nickname = $nickname;
    }

    public function getUNickname() 
    {
        return $this->u_nickname;
    }

    public function setUMobilePhone($mobile) 
    {
        $this->u_mobile_phone = $mobile;
    }

    public function getUMobilePhone() 
    {
        return $this->u_mobile_phone;
    }    

    public function setUFixedPhone($fixed) 
    {
        $this->u_fixed_phone = $fixed;
    }

    public function getUFixedPhone() 
    {
        return $this->u_fixed_phone;
    }     

    public function setUWechat($wechat) 
    {
        $this->u_wechat = $wechat;
    }

    public function getUWechat() 
    {
        return $this->u_wechat;
    }

    public function setUCreation($creation) 
    {
        $this->u_creation = $creation;
    }

    public function getUCreation() 
    {
        return $this->u_creation;
    }

    public function setUDeleted($deleted) 
    {
        $this->u_deleted = $deleted;
    }

    public function getUDeleted() 
    {
        return $this->u_deleted;
    }

    public function __set($property, $value)
    {
        $this->$property = $value;
    }

    public function __get($property)
    {
        return $this->$property;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}
