<?php
namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use User\Service\UserServiceInterface;
use zend\View\Model\ViewModel;
use User\Form\RegisterForm;
use User\Form\LoginForm;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use User\Entity\Users;
use Zend\Crypt\Password\Bcrypt;

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
        return new ViewModel(array(
            'users' => $this->getEntityManager()->getRepository('User\Entity\Users')->findAll(),
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
    }

    public function authenticateAction() 
    {
    }

    public function registerAction() 
    {
        $authenticationService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        if ($loggedUser = $authenticationService->getIdentity()) {
            return $this->redirect()->toRoute('user');
        }
        

        $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $registerForm = new RegisterForm($objectManager);
        $userEntity = new Users();
        $registerForm->bind($userEntity);

        if ($this->request->isPost()) {
            $registerForm->setData($this->request->getPost());

            if ($registerForm->isValid()) {
                $bcrypt = new Bcrypt(array(
                    'salt' => 'AL(u)P(*JC09-=acJ~',
                    'cost' => 11,
                ));
                $userEntity->setPassword($bcrypt->create($userEntity->getPassword()));
                $objectManager->persist($userEntity);
                $objectManager->flush();
            }
        }
        $registerForm->prepare();
        
        $view = new ViewModel(array(
            'registerForm' => $registerForm, 
        ));

        return $view;
    }

}

