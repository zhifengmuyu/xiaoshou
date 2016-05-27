<?php
namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use User\Service\UserServiceInterface;
use zend\View\Model\ViewModel;
use User\Form\PhoneRegisterForm;
use User\Form\EmailRegisterForm;
use User\Form\LoginForm;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use User\Entity\Users;
use Zend\Crypt\Password\Bcrypt;
use Zend\Stdlib\DateTime;

use Zend\Form\Annotation\AnnotationBuilder;

class UserController extends AbstractActionController
{

    protected $userService;

    public function __construct(UserServiceInterface $userService) 
    {
        $this->userService = $userService;
    }

    public function getEntityManager()
    {
        $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        return $this->em;
    }

    public function indexAction()
    {
        $authenticationService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        $identity = $authenticationService->getIdentity();
        if (!$identity) {
            return $this->redirect()->toRoute('user/login');
        }

        return new ViewModel(array(
            'users' => $this->getEntityManager()->getRepository('User\Entity\Users')->findAll(),
            'identity' => $identity,
        ));
    }

    public function loginAction()
    {
        $authenticationService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        if ($loggedUser = $authenticationService->getIdentity()) {
            return $this->redirect()->toRoute('user');
        }

        $loginForm = new LoginForm();

        if ($this->request->isPost()) {
            $loginForm->setData($this->request->getPost());
            if ($loginForm->isValid()) {
                $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
                $adapter = $authService->getAdapter();
                $postData = $this->getRequest()->getPost('login');
                $adapter->setIdentity($postData['email']);
                $adapter->setCredential($postData['password']);
                $authResult = $authService->authenticate();

                if ($authResult->isValid()) {
                    return $this->redirect()->toRoute('user');
                } else {
                    return new ViewModel(array(
                        'loginForm' => $loginForm, 
                        'error' => 'Your authentication credentials are not valid',
                    ));
                }
            }
        }

        $loginForm->prepare();
        $view = new ViewModel(array(
            'loginForm' => $loginForm, 
        ));

        return $view;
        
    }

    public function logoutAction()
    {
        $authenticationService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        $authenticationService->clearIdentity();
        $this->redirect()->toRoute('user/login');
    }

    public function authenticate($login, $password) 
    {
        $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        $adapter = $authService->getAdapter();

        $adapter->setIdentity($login);
        $adapter->setCredential($password);
        $authResult = $authService->authenticate();
            
        if ($authResult->isValid()) {
            return $authService;
        }

        return false;
    }

    public function editAction() 
    {
        $authenticationService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        $identity = $authenticationService->getIdentity();
        if (!$identity) {
            return $this->redirect()->toRoute('user/login');
        }

        $id = $identity->getId();
        $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $userEntity = $objectManager->getRepository('User\Entity\Users')->find($id);
        $userForm = new RegisterForm($objectManager);
        $userForm->getFieldsets()['register']->remove('u_creation');
        $userForm->getFieldsets()['register']->remove('u_deleted');

        $userForm->setValidationGroup(array(
            'register' => array('u_type', 'u_channels', 'u_products', 'u_nickname', 'u_mobile_phone', 'u_fixed_phone', 'u_wechat', 'u_creation', 'u_deleted')
        ));
        $userForm->getFieldsets()['register']->remove('u_email');
        $userForm->getFieldsets()['register']->remove('u_password');
        $userForm->getFieldsets()['register']->remove('passwordVerify');

        $userForm->bind($userEntity);

        if ($this->request->isPost()) {
            $userForm->setData($this->request->getPost());
            if ($userForm->isValid()) {
                \Zend\Debug\Debug::dump('adfasdfasdf');
                $objectManager->persist($userEntity);
                $objectManager->flush();

                return $this->redirect()->toRoute('user');
            } else {
                \Zend\Debug\Debug::dump('1111111');
                \Zend\Debug\Debug::dump($userForm->getMessages());
            }
        }

        $userForm->prepare();
        $view = new ViewModel(array(
            'userForm' => $userForm,
            'loggedUser' => $identity,
        ));

        return $view;
    }

    public function userExists($type, $id) 
    {
        $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $userEntity = $objectManager->getRepository('User\Entity\Users')->findBy(array($type, $id));
        if ($userEntity) return true;

        return false;
    }

    public function registerAction() 
    {
        $authenticationService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        if ($authenticationService->getIdentity()) {
            return $this->redirect()->toRoute('user');
        }
        
        $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $type = $this->params()->fromRoute('type');
        if ($type == 'phone') {
            $registerForm = new PhoneRegisterForm($objectManager);                
        } else {
            $registerForm = new EmailRegisterForm($objectManager);
        }


        //$registerForm = new RegisterForm($objectManager);
        $userEntity = new Users();
        $registerForm->bind($userEntity);

        if ($this->request->isPost()) {
            $registerForm->setData($this->request->getPost());
            if ($registerForm->isValid()) {
                $bcrypt = new Bcrypt(array(
                    'salt' => 'AL(u)P(*JC09-=acJ~',
                    'cost' => 11,
                ));
                $originPassword = $userEntity->getUPassword();
                $userEntity->setUPassword($bcrypt->create($originPassword));
                $userEntity->setUDeleted('f');
                $userEntity->setUCreation(new DateTime());
                $objectManager->persist($userEntity);
                $objectManager->flush();

                $authService = $this->authenticate($userEntity->getUEmail(), $originPassword);
                if ($authService->getIdentity()) {
                    return $this->redirect()->toRoute('user');               
                }
            } else {

            }
        }
        $registerForm->prepare();
        
        $view = new ViewModel(array(
            'registerForm' => $registerForm, 
            'type' => $type,
        ));

        return $view;
    }

}

