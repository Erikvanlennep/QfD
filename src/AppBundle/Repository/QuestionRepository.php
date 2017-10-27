<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class QuestionRepository extends EntityRepository
{
    public function findAll()
    {
        return $this->createQueryBuilder('q')
            ->where('q.answer IS NOT NULL AND q.deleted = false')
            ->getQuery()
            ->execute();
    }

    public function findAllUnanswered()
    {
        return $this->createQueryBuilder('q')
            ->where('q.answer IS NULL AND q.deleted = false')
            ->getQuery()
            ->execute();
    }

    public function findByFilter($param)
    {
        $paramQuery = 'q.' . $param . '';
        return $this->createQueryBuilder('q')
            ->where('q.answer IS NOT NULL AND q.deleted = false')
            ->orderBy($paramQuery, 'DESC')
            ->getQuery()
            ->execute();
    }
}