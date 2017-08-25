<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 10/8/17
 * Time: 4:38 PM
 */

namespace DatabaseBundle\Business;


use DatabaseBundle\Entity\Project;

class ProjectBusinessModel extends AbstractBusinessModel
{
    public function __construct($doctrine)
    {
        parent::__construct($doctrine);
        $this->entity = new Project();
    }

    /**
     * persist project
     *
     * @param Project $project
     * @return Project
     */
    public function saveProject(Project $project)
    {
        $this->persistEntity($project);
        return $project;
    }

    /**
     * get all projects
     *
     * @param int $max_result_size
     * @param int $page
     * @return array
     */
    public function getAllProjects($max_result_size = 3, $page = 0)
    {
        $qb = $this->getQueryBuilder("DatabaseBundle:Project", "project");
        $dql = "project.id >= :id";
        $qb->where($dql)->setParameter(":id", 1);
        $qb->setFirstResult($page * $max_result_size);
        $qb->setMaxResults($max_result_size);
        $query = $qb->getQuery();
        return $query->getResult();
    }

    /**
     * load similar projects by project id ant type
     *
     * @param $id
     * @param $type
     * @return array
     */
    public function loadSimilarProjects($id, $type)
    {
        $qb = $this->getQueryBuilder("DatabaseBundle:Project", "project");
        $trashed = "project.trashed = :status";
        $query_type = "project.type = :type";
        //$query_id = "project.id != :id";
        $qb->Where($trashed)->setParameter(":status", 0);
        $qb->andWhere($query_type)->setParameter(":type", $type);
        //$qb->andWhere($query_id)->setParameter(":id", $id);
        $qb->orderBy("project.id", "DESC");
        $page = 0;
        $qb->setFirstResult($page * 6);
        $qb->setMaxResults(6);

        $query = $qb->getQuery();
        $results = $query->getResult();

        $results_array = array();

        foreach ($results as $result) {
            $results_array [] = $result->convertToArray();
        }
        return $results_array;
    }
}