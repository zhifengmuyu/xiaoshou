<?php
namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use User\Service\UserServiceInterface;
use zend\View\Model\ViewModel;
use User\Form\PhoneRegisterForm;
use User\Form\EmailRegisterForm;
use User\Form\LoginForm;
use User\Form\UserProfileForm;
use User\Form\IndividualUserForm;
use User\Form\CompanyUserForm;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use User\Entity\User;
use User\Entity\CompanyUser;
use User\Entity\IndividualUser;
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
            'users' => $this->getEntityManager()->getRepository('User\Entity\User')->findAll(),
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
                $adapter->setIdentity($postData['login_id']);
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

        $messages = array();
        $id = $this->params()->fromRoute('id');
        $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $userEntity = $objectManager->getRepository('User\Entity\User')->find($id);

        if ($userEntity->getUType() == 'company') {
            $userProfileEntity = $objectManager->getRepository('User\Entity\CompanyUser')->findOneBy(array('cu_xref_u_id' => $id));
            if (!$userProfileEntity) {
                $userProfileEntity = new CompanyUser();
            }            

            $userProfileForm = new CompanyUserForm($objectManager);
            $userProfileForm->bind($userProfileEntity);
            $userProfileForm->setData(array(
                'profile' => array(
                    'u_email' => $userEntity->getUEmail(),
                    'u_mobile_phone' => $userEntity->getUMobilePhone(),
                    'cu_xref_u_id' => $userEntity->getId(),
                ),
            ));
        } else {
            $userProfileEntity = $objectManager->getRepository('User\Entity\IndividualUser')->findOneBy(array('iu_xref_u_id' => $id));
            if (!$userProfileEntity) {
                $userProfileEntity = new IndividualUser();
            }
            $userProfileForm = new IndividualUserForm($objectManager);
            $userProfileForm->bind($userProfileEntity);
            $userProfileForm->setData(array(
                'profile' => array(
                    'u_email' => $userEntity->getUEmail(),
                    'u_mobile_phone' => $userEntity->getUMobilePhone(),
                    'cu_xref_u_id' => $userEntity->getId(),
                ),
            ));
        }

        if ($this->request->isPost()) {
            $postData = $this->request->getPost();
            $userProfileForm->setData($postData);
            if ($userProfileForm->isValid()) {

                if (
                    ($postData['profile']['u_email'] and $postData['profile']['u_email'] != $userEntity->getUEmail()) 
                    or ($postData['profile']['u_email'] and $postData['profile']['u_mobile_phone'] != $userEntity->getUMobilePhone())
                    ) {
                    $userEntity->setUEmail($postData['profile']['u_email']);
                    $userEntity->setUMobilePhone($postData['profile']['u_mobile_phone']);
                    $objectManager->persist($userEntity);
                    $objectManager->flush();
                }

                $objectManager->persist($userProfileEntity);
                $objectManager->flush();
                $messages[] = 'User profile updated';
            }
        }

        $userProfileForm->prepare();
        $view = new ViewModel(array(
            'userProfileForm' => $userProfileForm,
            'loggedUser' => $identity,
            'messages' => $messages,
        ));

        return $view;
    }

    public function userExists($type, $id) 
    {
        $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $userEntity = $objectManager->getRepository('User\Entity\User')->findBy(array($type, $id));
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
        $registerType = $this->params()->fromRoute('register_type');
        $accountType = $this->params()->fromRoute('account_type');
        if ($accountType != 'company') $accountType = 'individual';
        if ($registerType == 'phone') {
            $registerForm = new PhoneRegisterForm($objectManager);                
        } else {
            $registerForm = new EmailRegisterForm($objectManager);
        }

        $userEntity = new User();
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
                $userEntity->setUType($accountType);
                $userEntity->setUActivated('t');
                $objectManager->persist($userEntity);
                $objectManager->flush();

                if ($registerType == 'phone') {
                    $authService = $this->authenticate($userEntity->getUMobilePhone(), $originPassword);
                } else {                    
                    $authService = $this->authenticate($userEntity->getUEmail(), $originPassword);
                }
                if ($authService->getIdentity()) {
                    return $this->redirect()->toRoute('user');               
                }
            } else {

            }
        }
        $registerForm->prepare();
        
        $view = new ViewModel(array(
            'registerForm' => $registerForm, 
            'type' => $registerType,
        ));

        return $view;
    }

}

