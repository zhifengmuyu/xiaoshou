<?php

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

use Docttine\Common\Annotations\AnnotationRegistry;


/** 
* @ORM\Entity 
* @ORM\Table(name="individual_users")
*/
class IndividualUser
{
    /** 
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    * @ORM\Column(type="integer",name="iu_id") 
    */
    protected $id;

    /** 
    * @ORM\Column(type="integer") 
    */
    protected $iu_xref_u_id;

    /** 
    * @ORM\Column(type="string") 
    */
    protected $iu_nickname;

    /** 
    * @ORM\Column(type="string") 
    */
    protected $iu_wechat;

    /** 
    * @ORM\Column(type="string") 
    */
    protected $iu_fixed_phone;

    /** 
    * @ORM\Column(type="string")
    */
    protected $iu_labels;   
    
    public function setId($id) 
    {
        $this->id = $id;
    }

    public function getId() 
    {
        return $this->id;
    }

    public function setIuXrefUId($u_id) 
    {
        $this->iu_xref_u_id = $u_id;
    }

    public function getIuXrefUId() 
    {
        return $this->iu_xref_u_id;
    }

    public function setIuNickname($nickname) 
    {
        $this->iu_nickname = $nickname;
    }

    public function getIuNickname() 
    {
        return $this->iu_nickname;
    }

    public function setIuWechat($wechat)
    {
        $this->iu_wechat = $wechat;
    }

    public function getIuWechat() 
    {
        return $this->iu_wechat;
    }

    public function setIuFixedPhone($phone) 
    {
        $this->iu_fixed_phone = $phone;
    }

    public function getIuFixedPhone() 
    {
        return $this->iu_fixed_phone;
    }    

    public function setIuLabels($labels) 
    {
        $this->iu_labels = $labels;
    }

    public function getIuLabels() 
    {
        return $this->iu_labels;
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
