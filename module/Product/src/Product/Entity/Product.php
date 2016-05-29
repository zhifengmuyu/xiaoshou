<?php

namespace Product\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;
use Docttine\Common\Annotations\AnnotationRegistry;

/** 
* @ORM\Entity 
* @ORM\Table(name="products")
*/
class Product
{
    /** 
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    * @ORM\Column(type="integer",name="p_id") 
    */
    protected $id;

    /**
    * @ORM\Column(type="integer")
    */
    protected $p_xref_u_id;

    /**
    * @ORM\Column(type="string")
    */
    protected $p_type;

    /**
    * @ORM\Column(type="string")
    */
    protected $p_name;

    /**
    * @ORM\Column(type="string")
    */
    protected $p_description;
    
    /**
    * @ORM\Column(type="datetime",nullable=false)
    */
    protected $p_creation;

    /**
    * @ORM\Column(type="boolean")
    */
    protected $p_deleted;

    public function setId($id) 
    {
        $this->id = $id;
    }

    public function getId() 
    {
        return $this->id;
    }

    public function setPXrefUId($id) 
    {
        $this->p_xref_u_id = $id;
    }

    public function getPXrefUId() 
    {
        return $this->p_xref_u_id;
    }

    public function setPType($type) 
    {
        $this->p_type = $type;
    }

    public function getPType() 
    {
        return $this->p_type;
    }

    public function setPName($name) 
    {
        $this->p_name = $name;
    }

    public function getPName() 
    {
        return $this->p_name;
    }

    public function setPDescription($description) 
    {
        $this->p_description = $description;
    }

    public function getPDescription() 
    {
        return $this->p_description;
    }

    public function setPDeleted($deleted) 
    {
        $this->p_deleted = $deleted;
    }

    public function getPDeleted() 
    {
        return $this->p_deleted;
    }

    public function setPCreation($creation) 
    {
        $this->p_creation = $creation;
    }

    public function getPCreation() 
    {
        return $this->p_creation;
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
