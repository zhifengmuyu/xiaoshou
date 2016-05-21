<?php

namespace Sp\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Sp\Form\ProductForm;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Sp\Entity\Product;
use Zend\Stdlib\DateTime;

class SpController extends AbstractActionController
{

    private $_objectManager = null;

    public function indexAction() 
    {
        $seller_products = $this->getObjectManager()->getRepository('\Sp\Entity\Product')->findAll();

        return new ViewModel(array(
            'products' => $seller_products,
        ));
    }

    public function addAction() 
    {
        
        $authenticationService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        $loggedUser = $authenticationService->getIdentity();
        if (!$loggedUser) {
            return $this->redirect()->toRoute('user/login');
        }

        $objectManager = $this->getObjectManager();
        $productForm = new ProductForm($objectManager);
        $productForm->getFieldsets()['product']->remove('p_id');
        $productForm->getFieldsets()['product']->remove('p_creation');
        $productForm->getFieldsets()['product']->remove('p_deleted');
        $productEntity = new Product();
        $productForm->bind($productEntity);

        if ($this->request->isPost()) {
            $productForm->setData($this->request->getPost());
            $productEntity->setPDeleted('f');
            $productEntity->setPCreation(new DateTime());
            if ($productForm->isValid()) {
                $objectManager->persist($productEntity);
                $objectManager->flush();

                return $this->redirect()->toRoute('sp');
            }
        }
        $productForm->prepare();
        $view = new ViewModel(array(
            'productForm' => $productForm, 
            'loggedUser' => $loggedUser,
        ));

        return $view;
    }

    public function editAction()
    {
        $authenticationService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        $loggedUser = $authenticationService->getIdentity();
        if (!$loggedUser) {
            return $this->redirect()->toRoute('user/login');
        }

        $id = $this->params()->fromRoute('id');
        $productEntity = $this->getObjectManager()->getRepository('\Sp\Entity\Product')->find($id);

        $objectManager = $this->getObjectManager();
        $productForm = new ProductForm($objectManager);
        $productForm->getFieldsets()['product']->remove('p_id');
        $productForm->getFieldsets()['product']->remove('p_creation');
        $productForm->getFieldsets()['product']->remove('p_deleted');
        $productForm->bind($productEntity);

        if ($this->request->isPost()) {
            $productForm->setData($this->request->getPost());
            $productEntity->setPDeleted('f');
            $productEntity->setPCreation(new DateTime());
            if ($productForm->isValid()) {
                $objectManager->persist($productEntity);
                $objectManager->flush();

                return $this->redirect()->toRoute('sp');
            }
        }
        $productForm->prepare();

        $view = new ViewModel(array(
            'productForm' => $productForm, 
            'loggedUser' => $loggedUser,
        ));

        return $view;
    }

    public function deleteAction()
    {
        $authenticationService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        $loggedUser = $authenticationService->getIdentity();
        if (!$loggedUser) {
            return $this->redirect()->toRoute('user/login');
        }
        $objectManager = $this->getObjectManager();
        $id = $this->params()->fromRoute('id');
        $productEntity = $this->getObjectManager()->getRepository('\Sp\Entity\Product')->find($id);
        $productEntity->setPDeleted('t');
        $objectManager->persist($productEntity);
        $objectManager->flush();

        $this->redirect()->toRoute('sp');
    }

    protected function getObjectManager()
    {
        if (!$this->_objectManager) {
            $this->_objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }

        return $this->_objectManager;
    }
}
