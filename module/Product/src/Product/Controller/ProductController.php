<?php

namespace Product\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Product\Form\ProductForm;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Product\Entity\Product;
use Zend\Stdlib\DateTime;

class ProductController extends AbstractActionController
{

    private $_objectManager = null;

    public function indexAction() 
    {
        $seller_products = $this->getObjectManager()->getRepository('\Product\Entity\Product')->findBy(array(
                'p_deleted' => 'f',
            ));

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
        $productEntity = new Product();
        $productForm->bind($productEntity);
        $productForm->setData(array(
            'product' => array(
                'p_xref_u_id' => $loggedUser->getId(),
            ),
        ));

        if ($this->request->isPost()) {
            $productForm->setData($this->request->getPost());
            if ($productForm->isValid()) {
                $productEntity->setPDeleted('f');
                $productEntity->setPCreation(new DateTime());
                $objectManager->persist($productEntity);
                $objectManager->flush();

                return $this->redirect()->toRoute('product');
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
        $productEntity = $this->getObjectManager()->getRepository('\Product\Entity\Product')->find($id);
        $objectManager = $this->getObjectManager();
        $productForm = new ProductForm($objectManager);
        $productForm->bind($productEntity);

        $productForm->getFieldsets()['product']->remove('p_creation');
        $productForm->getFieldsets()['product']->remove('p_deleted');

        if ($this->request->isPost()) {
            $productForm->setData($this->request->getPost());
            $productEntity->setPDeleted('f');
            $productEntity->setPCreation(new DateTime());
            if ($productForm->isValid()) {
                $objectManager->persist($productEntity);
                $objectManager->flush();

                return $this->redirect()->toRoute('product');
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
        $productEntity = $this->getObjectManager()->getRepository('\Product\Entity\Product')->find($id);
        $productEntity->setPDeleted('t');
        $objectManager->persist($productEntity);
        $objectManager->flush();

        $this->redirect()->toRoute('product');
    }

    protected function getObjectManager()
    {
        if (!$this->_objectManager) {
            $this->_objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }

        return $this->_objectManager;
    }
}
