<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 16/8/17
 * Time: 10:42 AM
 */

namespace DatabaseBundle\Business;

use DatabaseBundle\Common\StringHelper;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;

class ProjectSearchBusinessModel extends AbstractBusinessModel
{
    public function find($conditions, $max_result_size = 3, $page = 0, $type = "results", $is_trashed = 0)
    {
        $qb = $this->getQueryBuilder("DatabaseBundle:Project", "proj");

        // get available projects
        $trashed = "proj.trashed = :status";
        $qb->andWhere($trashed)->setParameter(":status", $is_trashed);
        $qb->orderBy("proj.timestamp", "DESC");

        if (key_exists("country", $conditions)) {
            if (!$conditions ['country'] || in_array('All', $conditions ['country']) || in_array('', $conditions ['country'])) {
                $conditions ['country'] = array_values(StringHelper::EnumToArray("DatabaseBundle\Enum\CountryType"));
            }
            $this->addInFilter($qb, $conditions ['country'], 'country');
        }

        if (key_exists("type", $conditions)) {
            if (!$conditions ['type'] || in_array('All', $conditions ['type']) || in_array('', $conditions ['type'])) {
                $conditions ['type'] = array_values(StringHelper::EnumToArray("DatabaseBundle\Enum\ProjectType"));
            }
            $this->addInFilter($qb, $conditions ['type'], 'type');
        }
        if (key_exists("keyword", $conditions)) {
            if (in_array('', $conditions ['keyword'])) {
                $conditions ['keyword'] [0] = '%';
            }
            $this->addKeyFilter($qb, $conditions ['keyword'] [0]);
        }
        if (key_exists("state", $conditions)) {
            if (!$conditions ['state'] || in_array('All', $conditions ['state']) || in_array('', $conditions ['state'])) {
                $conditions ['state'] = array_values(StringHelper::EnumToArray("DatabaseBundle\Enum\StateType"));
            }
            $this->addInFilter($qb, $conditions ['state'], 'state');
        }
        if (key_exists("price_from", $conditions)) {
            if (!$conditions ['price_from'] [0]) {
                $conditions ['price_from'] [0] = '0';
            }
            $this->addPriceFromFilter($qb, $conditions ['price_from']);
        }
        if (key_exists("price_to", $conditions)) {
            if (!$conditions ['price_to'] [0]) {
                $conditions ['price_to'] [0] = '999999999';
            }
            $this->addPriceToFilter($qb, $conditions ['price_to']);
        }

        $qb->setFirstResult($page * $max_result_size);
        $qb->setMaxResults($max_result_size);

        $query = $qb->getQuery();
        if ($type == "page_number") {
            $paginator = new Paginator($query);
            $result = count($paginator);
            return $result;
        }
        return $query->getResult();
    }

    /**
     *
     * @param QueryBuilder $qb
     * @param string $conditions
     */
    public function addInFilter(QueryBuilder $qb, $values, $field_name)
    {
        $dql = "proj.$field_name in (:$field_name)";
        $qb->andWhere($dql)->setParameter(":$field_name", $values);
        return $this;
    }

    public function addKeyFilter(QueryBuilder $qb, $value)
    {
        $value = "%$value%";
        $dql_title = "proj.title LIKE :keyword or proj.description like :keyword ";
        $qb->andWhere($dql_title)->setParameter(":keyword", $value);
        return $this;
    }

    public function addPriceFromFilter(QueryBuilder $qb, $values)
    {
        $dql = "proj.max_price >= :from";
        $qb->andWhere($dql)->setParameter(":from", $values);
        return $this;
    }

    public function addPriceToFilter(QueryBuilder $qb, $values)
    {
        $dql = "proj.min_price <= :to";
        $qb->andWhere($dql)->setParameter(":to", $values);
        return $this;
    }
}