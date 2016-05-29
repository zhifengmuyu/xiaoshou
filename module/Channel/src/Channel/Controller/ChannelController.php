<?php

namespace Channel\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Channel\Form\ChannelForm;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Channel\Entity\Channel;
use Zend\Stdlib\DateTime;

class ChannelController extends AbstractActionController
{

    private $_objectManager = null;

    public function indexAction() 
    {
        $channels = $this->getObjectManager()->getRepository('\Channel\Entity\Channel')->findBy(array(
                'c_deleted' => 'f',
            ));

        return new ViewModel(array(
            'channels' => $channels,
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
        $channelForm = new ChannelForm($objectManager);
        $channelEntity = new Channel();
        $channelForm->bind($channelEntity);
        $channelForm->setData(array(
            'channel' => array(
                'c_xref_u_id' => $loggedUser->getId(),
            ),
        ));

        if ($this->request->isPost()) {
            $channelForm->setData($this->request->getPost());
            if ($channelForm->isValid()) {
                $channelEntity->setCDeleted('f');
                $channelEntity->setCCreation(new DateTime());
                $objectManager->persist($channelEntity);
                $objectManager->flush();

                return $this->redirect()->toRoute('channel');
            }
        }
        $channelForm->prepare();
        $view = new ViewModel(array(
            'channelForm' => $channelForm, 
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
        $channelEntity = $this->getObjectManager()->getRepository('\Channel\Entity\Channel')->find($id);
        $objectManager = $this->getObjectManager();
        $channelForm = new ChannelForm($objectManager);
        $channelForm->bind($channelEntity);

        $channelForm->getFieldsets()['channel']->remove('c_creation');
        $channelForm->getFieldsets()['channel']->remove('c_deleted');

        if ($this->request->isPost()) {
            $channelForm->setData($this->request->getPost());
            $channelEntity->setCDeleted('f');
            $channelEntity->setCCreation(new DateTime());
            if ($channelForm->isValid()) {
                $objectManager->persist($channelEntity);
                $objectManager->flush();

                return $this->redirect()->toRoute('channel');
            }
        }

        $channelForm->prepare();

        $view = new ViewModel(array(
            'channelForm' => $channelForm, 
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
        $channelEntity = $this->getObjectManager()->getRepository('\Channel\Entity\Channel')->find($id);
        $channelEntity->setCDeleted('t');
        $objectManager->persist($channelEntity);
        $objectManager->flush();

        $this->redirect()->toRoute('channel');
    }

    protected function getObjectManager()
    {
        if (!$this->_objectManager) {
            $this->_objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }

        return $this->_objectManager;
    }
}
