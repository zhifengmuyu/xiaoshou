<?php

namespace Channel\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;
use Docttine\Common\Annotations\AnnotationRegistry;

/** 
* @ORM\Entity 
* @ORM\Table(name="channels")
*/
class Channel
{
    /** 
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    * @ORM\Column(type="integer",name="c_id") 
    */
    protected $id;

    /**
    * @ORM\Column(type="integer")
    */
    protected $c_xref_u_id;

    /**
    * @ORM\Column(type="string")
    */
    protected $c_type;

    /**
    * @ORM\Column(type="string")
    */
    protected $c_name;

    /**
    * @ORM\Column(type="string")
    */
    protected $c_description;
    
    /**
    * @ORM\Column(type="datetime",nullable=false)
    */
    protected $c_creation;

    /**
    * @ORM\Column(type="boolean")
    */
    protected $c_deleted;

    public function setId($id) 
    {
        $this->id = $id;
    }

    public function getId() 
    {
        return $this->id;
    }

    public function setCXrefUId($id) 
    {
        $this->c_xref_u_id = $id;
    }

    public function getCXrefUId() 
    {
        return $this->c_xref_u_id;
    }

    public function setCType($type) 
    {
        $this->c_type = $type;
    }

    public function getCType() 
    {
        return $this->c_type;
    }

    public function setCName($name) 
    {
        $this->c_name = $name;
    }

    public function getCName() 
    {
        return $this->c_name;
    }

    public function setCDescription($description) 
    {
        $this->c_description = $description;
    }

    public function getCDescription() 
    {
        return $this->c_description;
    }

    public function setCDeleted($deleted) 
    {
        $this->c_deleted = $deleted;
    }

    public function getCDeleted() 
    {
        return $this->c_deleted;
    }

    public function setCCreation($creation) 
    {
        $this->c_creation = $creation;
    }

    public function getCCreation() 
    {
        return $this->c_creation;
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
