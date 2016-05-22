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

    public function buyerAction()
    {
        if ($this->request->isPost()) {
            $name = $this->params()->fromPost('name');
            $qb = $this->getObjectManager()->createQueryBuilder();
            $qb->select('u')
               ->from('User\Entity\Users', 'u')
               ->where('u.u_channels like ?1')
               ->setParameter(1, '%' . $name . '%');
            $allBuyers = $qb->getQuery()->getResult();
            return new viewModel(array(
                'allBuyers' => $allBuyers,
            ));            
        } else {

        }
    }

    public function sellerAction()
    {
        if ($this->request->isPost()) {
            $name = $this->params()->fromPost('name');
            $qb = $this->getObjectManager()->createQueryBuilder();
            $qb->select('u')
               ->from('User\Entity\Users', 'u')
               ->where('u.u_products like ?1')
               ->setParameter(1, '%' . $name . '%');
            $allSellers = $qb->getQuery()->getResult();
            return new viewModel(array(
                'allSellers' => $allSellers,
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
