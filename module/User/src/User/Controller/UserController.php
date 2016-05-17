<?php
namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use User\Service\UserServiceInterface;
use zend\View\Model\ViewModel;
use User\Form\RegisterForm;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use User\Entity\Users;

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
//\Zend\Debug\Debug::dump(md5(1));
        $data = array(
            'email' => 'gslinhu@live.com',
            'password' => '1',
        );
        $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        $adapter = $authService->getAdapter();
        $adapter->setIdentity('gslinhu@live.com');
        $adapter->setCredential('1');
        $authResult = $authService->authenticate();

        if ($authResult->isValid()) {
            return $this->redirect()->toRoute('user/register');
        }
        
        return new ViewModel(array(
            'error' => 'Your authentication credentials are not valid',
        ));
    }

    public function logoutAction()
    {
    }

    public function authenticateAction() 
    {
    }

    public function registerAction() 
    {
        //$authenticationService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        //if ($loggedUser = $authenticationService->getIdentity()) {
        //    //return $this->redirect()->toRoute('user');
        //}
        //

        $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $registerForm = new RegisterForm($objectManager);
        $userEntity = new Users();
        $registerForm->bind($userEntity);

        if ($this->request->isPost()) {
            $registerForm->setData($this->request->getPost());

            if ($registerForm->isValid()) {
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

