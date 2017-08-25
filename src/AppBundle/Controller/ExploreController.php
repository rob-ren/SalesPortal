<?php

/**
 * Created by PhpStorm.
 * User: robert
 * Date: 16/8/17
 * Time: 10:34 AM
 */

namespace AppBundle\Controller;

use DatabaseBundle\Business\ProjectBusinessModel;
use DatabaseBundle\Business\ProjectMetaBusinessModel;
use DatabaseBundle\Business\ProjectSearchBusinessModel;
use DatabaseBundle\Common\GoogleMapService;
use DatabaseBundle\Common\StringHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ExploreController extends Controller
{
    public function exploreAction($page)
    {
        $account = $this->getUser() ? $this->getUser() : null;
        if ($account != null) {
            $account = $account->convertToArray();
        }

        // search function
        $max_results_per_page = 10;
        $query_country = $this->getRequest()->get('state') == "All" ? null : "Australia";
        $query_state = $this->getRequest()->get('state') == "All" ? null : $this->getRequest()->get('state');
        $query_type = $this->getRequest()->get('type');
        $query_min_price = $this->getRequest()->get('min_price');
        $query_max_price = $this->getRequest()->get('max_price');
        $query_keyword = $this->getRequest()->get('keyword');
        $results_array = $this->searchProjects($query_country, $query_state, $query_type, $query_min_price, $query_max_price, $query_keyword, $max_results_per_page, $page - 1);
        // search map lat&lng
        $google_map = new GoogleMapService();
        if ($query_country == null && $query_state == null) {
            $location = array(
                'latitude' => '-24.537980',
                'longitude' => '134.037349',
                'level' => 2
            );
        } elseif ($query_country != null && $query_state == null) {
            $result = $google_map->getLocation($query_country, null, null, null, null, null);
            $location = array(
                'latitude' => $result ['latitude'],
                'longitude' => $result ['longitude'],
                'level' => 4
            );
        } else {
            $result = $google_map->getLocation($query_country, $query_state, null, null, null, null);
            $location = array(
                'latitude' => $result ['latitude'],
                'longitude' => $result ['longitude'],
                'level' => 7
            );
        }
        // calculate paging number
        $total_results = $this->searchProjects($query_country, $query_state, $query_type, $query_min_price, $query_max_price, $query_keyword, $max_results_per_page, $page - 1, "page_number");
        $max_pages = ceil($total_results / $max_results_per_page);
        $recent_projects = $this->loadRecentProjects();

        return $this->render('AppBundle:Default:explore.html.twig', array(
            'user' => $account,
            'projects' => $results_array,
            'page' => $page,
            'max_pages' => $max_pages,
            'max_results_per_page' => $max_results_per_page,
            'recent_projects' => $recent_projects,
            'location' => $location,
            'total_result' => $total_results,
            'types' => StringHelper::EnumToArray("DatabaseBundle\Enum\ProjectType"),
            'states' => StringHelper::EnumToArray("DatabaseBundle\Enum\StateType"),
        ));
    }

    /**
     * call the project search business model
     *
     * @param $query_country
     * @param $query_state
     * @param $query_type
     * @param $query_min_price
     * @param $query_max_price
     * @param $query_keyword
     * @param $query_max_results
     * @param $query_page
     * @param string $type
     * @return array|int
     */
    public function searchProjects($query_country, $query_state, $query_type, $query_min_price, $query_max_price, $query_keyword, $query_max_results, $query_page, $type = "results")
    {
        $project_search_bm = $this->getProjectSearchBusinessModel();
        $conditions = array();

        if ($query_country) {
            $conditions ["country"] = array(
                $query_country
            );
        }
        if ($query_type) {
            $conditions ["type"] = array(
                $query_type
            );
        }
        if ($query_state) {
            $conditions ["state"] = array(
                $query_state
            );
        }
        if ($query_min_price) {
            $conditions ["price_from"] = array(
                $query_min_price
            );
        }
        if ($query_max_price) {
            $conditions ["price_to"] = array(
                $query_max_price
            );
        }
        if ($query_keyword) {
            $conditions ["keyword"] = array(
                $query_keyword
            );
        }
        if ($type != "results") {
            return $project_search_bm->find($conditions, $query_max_results, $query_page, $type);
        }
        $results = $project_search_bm->find($conditions, $query_max_results, $query_page, $type);

        $results_array = array();
        foreach ($results as $result) {
            $results_array [] = $result->convertToArray();
        }
        return $results_array;
    }

    /**
     * @param int $max_result_size
     * @return array
     */
    public function loadRecentProjects($max_result_size = 3)
    {
        $project__search_bm = $this->getProjectSearchBusinessModel();
        $results = $project__search_bm->find(array()) ? $project__search_bm->find(array()) : null;
        $results_array = array();
        if ($results) {
            foreach ($results as $result) {
                $results_array [] = $result->convertToArray();
            }
        }
        return $results_array;
    }

    /**
     * get project business model
     *
     * @return ProjectBusinessModel
     */
    public function getProjectBusinessModel()
    {
        return $this->get("project_business");
    }

    /**
     * get project meta business model
     *
     * @return ProjectMetaBusinessModel
     */
    public function getProjectMetaBusinessModel()
    {
        return $this->get("project_meta_business");
    }

    /**
     * get project search business model
     *
     * @return ProjectSearchBusinessModel
     */
    public function getProjectSearchBusinessModel()
    {
        return $this->get("project_search_business");
    }
}