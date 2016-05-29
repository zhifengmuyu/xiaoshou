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
class User
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
    protected $u_mobile_phone;

    /** 
    * @ORM\Column(type="boolean")
    */
    protected $u_activated;

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


    public function setUMobilePhone($mobile) 
    {
        $this->u_mobile_phone = $mobile;
    }

    public function getUMobilePhone() 
    {
        return $this->u_mobile_phone;
    }    

    public function setUActivated($activated)
    {
        $this->u_activated = $activated;
    }

    public function getUActivated()
    {
        return $this->u_activated;
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
