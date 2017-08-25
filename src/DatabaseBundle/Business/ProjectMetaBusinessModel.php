<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 10/8/17
 * Time: 5:12 PM
 */

namespace DatabaseBundle\Business;

use DatabaseBundle\Entity\Project;
use DatabaseBundle\Entity\ProjectMeta;

class ProjectMetaBusinessModel extends AbstractBusinessModel
{
    public function __construct($doctrine)
    {
        parent::__construct($doctrine);
        $this->entity = new ProjectMeta();
    }

    /**
     * persist project meta
     *
     * @param ProjectMeta $project_meta
     * @return ProjectMeta
     */
    public function newProjectMeta(ProjectMeta $project_meta)
    {
        $this->persistEntity($project_meta);
        return $project_meta;
    }

    /**
     * load project meta by project and type
     *
     * @param Project $project
     * @param $type
     * @return array
     */
    public function loadByProjectAndType(Project $project, $type)
    {
        $criteria = array(
            'type' => $type,
            'project' => $project
        );
        $project_metas = $this->getRepository()->findBy($criteria);
        $project_meta_array = array();
        foreach ($project_metas as $project_meta) {
            $project_meta_array[] = $project_meta->convertToArray();
        }
        return $project_meta_array;
    }
}