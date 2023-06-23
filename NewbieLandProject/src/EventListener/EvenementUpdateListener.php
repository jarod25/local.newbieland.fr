<?php

namespace App\EventListener;

use App\Entity\Evenement;
use App\Entity\EventLog;
use Doctrine\ORM\Event\PostUpdateEventArgs;
use Symfony\Bundle\SecurityBundle\Security;

readonly class EvenementUpdateListener
{
    public function __construct(private Security $security)
    {
    }

    public function postUpdate(PostUpdateEventArgs $args): void
    {
        $entity = $args->getObject();
        if (!$entity instanceof Evenement) {
            return;
        }

        $entityManager = $args->getObjectManager();
        $uow = $entityManager->getUnitOfWork();

        $changeSet = $uow->getEntityChangeSet($entity);
        foreach ($changeSet as $field => $changes) {
            $eventLog = new EventLog();
            if (!$field == 'debut' && !$field == 'fin') {
                $eventLog->setPreviousValue($changes[0]);
                $eventLog->setNewValue($changes[1]);
            }
            $eventLog->setClass(Evenement::class);
            $eventLog->setEntityId($entity->getId());
            $eventLog->setCreatedAt(new \DateTime());
            $eventLog->setCreatedBy($this->security->getUser());

            $entityManager->persist($eventLog);
            $entityManager->flush();
        }
    }
}
