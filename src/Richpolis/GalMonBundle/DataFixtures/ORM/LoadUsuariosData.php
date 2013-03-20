<?php

// src/Ens/JobeetBundle/DataFixtures/ORM/LoadCategoryData.php
namespace Richpolis\GalMonBundle\DataFixtures\ORM;
 
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Richpolis\GalMonBundle\Entity\Usuarios;
 
class LoadUsuariosData extends AbstractFixture implements OrderedFixtureInterface,ContainerAwareInterface
{
  public function load(ObjectManager $em)
  {
    $user = new Usuarios();
    $user->setUsername('Richpolis');
    $user->setNombre('Ricardo Alcantara Gomez');
    $user->setEmail('richpolis@gmail.com');
    $user->setSalt(md5(uniqid()));

    $encoder = $this->container
         ->get('security.encoder_factory')
         ->getEncoder($user)
    ;
    $user->setPassword($encoder->encodePassword('D3m3s1s1', $user->getSalt()));

    $em->persist($user);
    $em->flush();

  }
 
  public function getOrder()
  {
    return 1; // the order in which fixtures will be loaded
  }

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }


}