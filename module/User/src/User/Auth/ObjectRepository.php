<?php
namespace User\Auth;
 
use DoctrineModule\Authentication\Adapter\ObjectRepository as BaseObjectRepository;
use Zend\Authentication\Result as AuthenticationResult;

class ObjectRepository extends BaseObjectRepository
{
    /**
     * {@inheritDoc}
     */
    public function authenticate()
    {
        $this->setup();
        $options  = $this->options;

        $identities = $options->getIdentityProperty();
        $identitiesProperties = explode(',', $identities);
        $primaryIdentity = current($identitiesProperties);
        $secondaryIdentity = end($identitiesProperties);

        $identity = $options
            ->getObjectRepository()
            ->findOneBy(array(
                $primaryIdentity => $this->identity,
            ));
        if (!$identity) {
            $identity = $options
                ->getObjectRepository()
                ->findOneBy(array(
                    $secondaryIdentity => $this->identity,
                ));
        }
        if (!$identity) {
            $this->authenticationResultInfo['code'] = AuthenticationResult::FAILURE_IDENTITY_NOT_FOUND;
            $this->authenticationResultInfo['messages'][] = 'A record with the supplied identity could not be found.';
            return $this->createAuthenticationResult();
        }
        $authResult = $this->validateIdentity($identity);
        return $authResult;
    }
}