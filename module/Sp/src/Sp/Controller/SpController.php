<?php

namespace Sp\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use zend\View\Model\ViewModel;
use Sp\Form\ProductForm;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Sp\Entity\Product;

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
        $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $productForm = new ProductForm($objectManager);
        $productForm->getFieldsets()['product']->remove('id');
        $productForm->getFieldsets()['product']->remove('p_creation');
        $productForm->getFieldsets()['product']->remove('p_deleted');
        $productForm->getFieldsets()['product']->get('p_xref_u_id')->setValue('26');

        $productEntity = new Product();
        $productForm->bind($productEntity);

        if ($this->request->isPost()) {
            $productForm->setData($this->request->getPost());

            if ($productForm->isValid()) {
                $objectManager->persist($productEntity);
                $objectManager->flush();

                return $this->redirect()->toRoute('sp');
            } else {
//                \Zend\Debug\Debug::dump($productForm->getMessages());
//                \Zend\Debug\Debug::dump($productForm->getErrorMessages());

            }
        }
        $productForm->prepare();
        $view = new ViewModel(array(
            'productForm' => $productForm, 
        ));

        return $view;
    }

    public function editAction()
    {
    }

    public function deleteAction()
    {
    }

    protected function getObjectManager()
    {
        if (!$this->_objectManager) {
            $this->_objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }

        return $this->_objectManager;
    }
}
