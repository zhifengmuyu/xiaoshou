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
    * @ORM\Column(type="integer",name="id") 
    * @Annotation\Options({"label":"ID: "})
    * @Annotation\Exclude()
    */
    protected $id;

    /** 
    * @ORM\Column(type="string") 
    * @Annotation\Options({"label":"Email: "})
    * @Annotation\Type("Zend\Form\Element\Email")
    * @Annotation\Filter({"name":"StripTags"})
    * @Annotation\Filter({"name":"StringTrim"})
    * @Annotation\Validator({"name":"EmailAddress","options":{"domain":"true"}})
    */
    protected $email;

    /** 
    * @ORM\Column(type="string") 
    * @Annotation\Options({"label":"Password: "})
    * @Annotation\Type("Zend\Form\Element\Password")
    * @Annotation\Filter({"name":"StripTags"})
    * @Annotation\Filter({"name":"StringTrim"})
    */
    protected $password;

    public function __get($property) 
    {
        return $this->$property;
    }

    public function __set($property, $value) 
    {
        $this->$property = $value;
    }

    public function setEmail($email) 
    {
        $this->email = $email;
    }

    public function getEmail() 
    {
        return $this->email;
    }

    public function setPassword($password) 
    {
        $this->password = $password;
    }

    public function getPassword() 
    {
        return $this->password;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}
