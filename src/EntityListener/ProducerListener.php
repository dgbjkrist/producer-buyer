<?php

declare(strict_types=1);

namespace App\EntityListener;

use App\Entity\Producer;
use App\Entity\Farm;
use Symfony\Component\Uid\Uuid;

class ProducerListener
{
    public function prePersist(Producer $producer)
    {
        $farm = new Farm();
        $farm->setUuid(Uuid::v4());
        $farm->setProducer($producer);
        $producer->setFarm($farm);
    }
}
