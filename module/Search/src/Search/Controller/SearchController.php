<?php

namespace Search\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use User\Entity\Users;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Zend\Stdlib\DateTime;

class SearchController extends AbstractActionController
{

    private $_objectManager = null;

    public function indexAction() 
    {
        return new ViewModel(array(
        ));
    }

    public function productAction()
    {
        if ($this->request->isPost()) {
            $name = $this->params()->fromPost('name');
            $qb = $this->getObjectManager()->createQueryBuilder();
            $qb->select('p')
               ->from('Product\Entity\Product', 'p')
               ->where('lower(p.p_name) like ?1')
               ->orWhere('lower(p.p_description) like ?1')
               ->setParameter(1, '%' . $name . '%');
            $products = $qb->getQuery()->getResult();
            return new viewModel(array(
                'products' => $products,
            ));            
        } else {
        }
    }

    public function channelAction()
    {
        if ($this->request->isPost()) {
            $name = $this->params()->fromPost('name');
            $qb = $this->getObjectManager()->createQueryBuilder();
            $qb->select('c')
               ->from('Channel\Entity\Channel', 'c')
               ->where('lower(c.c_name) like ?1')
               ->orWhere('lower(c.c_description) like ?1')
               ->setParameter(1, '%' . $name . '%');
            $channels = $qb->getQuery()->getResult();
            return new viewModel(array(
                'channels' => $channels,
            ));            
        } else {

        }
    }

    protected function getObjectManager()
    {
        if (!$this->_objectManager) {
            $this->_objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }

        return $this->_objectManager;
    }
}
