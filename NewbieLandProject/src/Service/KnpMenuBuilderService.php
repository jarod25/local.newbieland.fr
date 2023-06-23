<?php

namespace App\Service;

use Knp\Menu\FactoryInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class KnpMenuBuilderService
{
    /** @var FactoryInterface */
    private FactoryInterface $factory;

    /** @var  AuthorizationCheckerInterface */
    private AuthorizationCheckerInterface $authChecker;

    public function __construct(FactoryInterface $factory, AuthorizationCheckerInterface $authorizationCheckerInterface)
    {
        $this->factory = $factory;
        $this->authChecker = $authorizationCheckerInterface;
    }

    public function createMainMenu(array $options)
    {
        $menu = $this->factory->createItem('root');
        // si un admin est connecté, on affiche tout le menu, sinon on affiche juste le menu User
        if ($this->authChecker->isGranted('ROLE_ADMIN')) {
            $this->addItems($menu);
        } elseif ($this->authChecker->isGranted('ROLE_USER')) {
            $this->addItemsUser($menu);
            $menu->addChild('Profile', ['route' => 'app_profile']);
        }
    else {
            $this->addItemsUser($menu);
        }
        if (!$this->authChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            $menu->addChild('Login', ['route' => 'app_login']);
        } else {
            $menu->addChild('Logout', ['route' => 'app_logout']);
        }
        return $this->setAttributes($menu);
    }

    private function addItems($menu)
    {
        $menu->addChild('Home', ['route' => 'homepage']);
        $menu->addChild('Admin', ['route' => '']);
        $menu['Admin']->addChild('Home Admin', ['route' => 'espace-reserve']);
        $menu['Admin']->addChild('Home Sonata', ['route' => 'sonata_admin_dashboard']);
        $menu['Admin']->addChild('Sport', ['route' => 'app_sport_index']);
        $menu['Admin']->addChild('Delegation', ['route' => 'app_delegation_index']);
        $menu['Admin']->addChild('Sportif', ['route' => 'app_sportif_index']);
        $menu['Admin']->addChild('Ville', ['route' => 'app_ville_index']);
        $menu['Admin']->addChild('Evenements', ['route' => 'app_evenement_index']);
        $menu['Admin']->addChild('Actualités', ['route' => 'app_actualite_index']);
        $menu->addChild('User', ['route' => '']);
        $menu['User']->addChild('Liste des sport', ['route' => 'app_liste_sports']);
        $menu['User']->addChild('Liste des sportifs', ['route' => 'app_liste_sportifs']);
        $menu['User']->addChild('Liste des événements', ['route' => 'app_liste_evenements']);
        $menu['User']->addChild('Liste des actualités', ['route' => 'app_liste_actualites']);

        return $menu;
    }

    private function setAttributes($menu)
    {
        foreach ($menu as $item) {
            $item->setLinkAttribute('class', 'nav-link'); // a class
        }
        $menu->setChildrenAttribute('class', 'nav nav-pills'); // ul class
        return $menu;
    }

    private function addItemsUser($menu)
    {
        $menu->addChild('Home', ['route' => 'homepage']);
        $menu->addChild('Liste des sport', ['route' => 'app_liste_sports']);
        $menu->addChild('Liste des sportifs', ['route' => 'app_liste_sportifs']);
        $menu->addChild('Liste des événements', ['route' => 'app_liste_evenements']);
        $menu->addChild('Liste des actualités', ['route' => 'app_liste_actualites']);
        return $menu;
    }
}