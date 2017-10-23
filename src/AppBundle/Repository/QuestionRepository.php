<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class QuestionRepository extends EntityRepository
{
    public function findAllTest()
    {
        return $this->createQueryBuilder('q')
            ->where('q.answer IS NOT NULL AND q.deleted = false')
            ->getQuery()
            ->execute();
    }
}