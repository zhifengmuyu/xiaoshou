<?php

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

use Docttine\Common\Annotations\AnnotationRegistry;


/** 
* @ORM\Entity 
* @ORM\Table(name="company_users")
*/
class CompanyUser
{
    /** 
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    * @ORM\Column(type="integer",name="cu_id") 
    */
    protected $id;

    /** 
    * @ORM\Column(type="integer") 
    */
    protected $cu_xref_u_id;

    /** 
    * @ORM\Column(type="string") 
    */
    protected $cu_name;

    /** 
    * @ORM\Column(type="string") 
    */
    protected $cu_description;

    /** 
    * @ORM\Column(type="string") 
    */
    protected $cu_fixed_phone;

    /** 
    * @ORM\Column(type="string")
    */
    protected $cu_wechat;   

    /** 
    * @ORM\Column(type="string")
    */
    protected $cu_location;   
    
    /** 
    * @ORM\Column(type="string")
    */
    protected $cu_labels;

    public function setId($id) 
    {
        $this->id = $id;
    }

    public function getId() 
    {
        return $this->id;
    }

    public function setCuXrefUId($u_id) 
    {
        $this->cu_xref_u_id = $u_id;
    }

    public function getCuXrefUId() 
    {
        return $this->cu_xref_u_id;
    }

    public function setCuName($name) 
    {
        $this->cu_name = $name;
    }

    public function getCuName() 
    {
        return $this->cu_name;
    }

    public function setCuDescription($description)
    {
        $this->cu_description = $description;
    }

    public function getCuDescription() 
    {
        return $this->cu_description;
    }

    public function setCuFixedPhone($phone) 
    {
        $this->cu_fixed_phone = $phone;
    }

    public function getCuFixedPhone() 
    {
        return $this->cu_fixed_phone;
    }    

    public function setCuLocation($location) 
    {
        $this->cu_location = $location;
    }

    public function getCuLocation() 
    {
        return $this->cu_location;
    }

    public function setCuLabels($labels) 
    {
        $this->cu_labels = $labels;
    }

    public function getCuLabels() 
    {
        return $this->cu_labels;
    }

    public function setCuWechat($wechat) 
    {
        $this->cu_wechat = $wechat;
    }

    public function getCuWechat()
    {
        return $this->cu_wechat;
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
