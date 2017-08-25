<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 11/8/17
 * Time: 4:12 PM
 */

namespace AppBundle\Controller;

use AppBundle\EventListener\FileUploadedEvent;
use AppBundle\Exceptions\FailToMoveFileException;
use AppBundle\Exceptions\FailToUploadFileException;
use AppBundle\Exceptions\FieldIsNullException;
use DatabaseBundle\Business\ProjectBusinessModel;
use DatabaseBundle\Business\ProjectMetaBusinessModel;
use DatabaseBundle\Common\StringHelper;
use DatabaseBundle\Entity\Project;
use DatabaseBundle\Entity\ProjectMeta;
use DatabaseBundle\Enum\ProjectMetaType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class AddController extends Controller
{
    /**
     * render to add page
     *
     * @return Response
     */
    public function addAction()
    {
        $account = $this->getUser() ? $this->getUser() : null;
        if ($account != null) {
            $account = $account->convertToArray();
        }

        return $this->render('AppBundle:Default:add.html.twig', array(
            'user' => $account,
            'types' => StringHelper::EnumToArray("DatabaseBundle\Enum\ProjectType"),
        ));
    }

    /**
     * list project action
     *
     * @return Response
     */
    public function listAction()
    {
        $title = $this->getRequest()->get('title') ? $this->getRequest()->get('title') : null;
        $price_from = $this->getRequest()->get('price_from') ? $this->getRequest()->get('price_from') : $price_from = $this->getRequest()->get('price_to') ? $price_from = $this->getRequest()->get('price_to') : null;
        $price_to = $this->getRequest()->get('price_to') ? $this->getRequest()->get('price_to') : $this->getRequest()->get('price_from') ? $this->getRequest()->get('price_from') : null;
        $desc = $this->getRequest()->get('description') ? $this->getRequest()->get('description') : null;
        $address = $this->getRequest()->get('address') ? $this->getRequest()->get('address') : null;
        $longitude = $this->getRequest()->get('longitude') ? $this->getRequest()->get('longitude') : null;
        $latitude = $this->getRequest()->get('latitude') ? $this->getRequest()->get('latitude') : null;
        $suburb = $this->getRequest()->get('locality') ? $this->getRequest()->get('locality') : null;
        $state = $this->getRequest()->get('administrative_area_level_1') ? $this->getRequest()->get('administrative_area_level_1') : null;
        $post_code = $this->getRequest()->get('postal_code') ? $this->getRequest()->get('postal_code') : null;
        $country = $this->getRequest()->get('country') ? $this->getRequest()->get('country') : null;
        $type = $this->getRequest()->get('type') ? $this->getRequest()->get('type') : null;
        $beds = $this->getRequest()->get('beds') ? $this->getRequest()->get('beds') : null;
        $baths = $this->getRequest()->get('baths') ? $this->getRequest()->get('baths') : null;
        $cars = $this->getRequest()->get('cars') ? $this->getRequest()->get('cars') : null;
        $storages = $this->getRequest()->get('storages') ? $this->getRequest()->get('storages') : null;
        $internal_area = $this->getRequest()->get('internal_area') ? $this->getRequest()->get('internal_area') : null;
        $external_area = $this->getRequest()->get('external_area') ? $this->getRequest()->get('external_area') : null;
        $land = $this->getRequest()->get('land') ? $this->getRequest()->get('land') : null;
        $amenities = $this->getRequest()->get('amenities') ? $this->getRequest()->get('amenities') : null;
        $images = $this->getRequest()->files->get("upload_images") ? $this->getRequest()->files->get("upload_images") : null;
        $project_bm = $this->getProjectBusinessModel();
        $account = $this->getUser() ? $this->getUser() : null;

        try {
            if (!$images || !$title || !$address) {
                throw new FieldIsNullException();
            }

            // create new project
            $project = new Project();
            $project->setAccount($account);
            $project->setTitle($title);
            $project->setMinPrice($price_from);
            $project->setMaxPrice($price_to);
            $project->setAddress($address);
            $project->setDescription($desc);
            $project->setLongitude($longitude);
            $project->setLatitude($latitude);
            $project->setType($type);
            $project->setBeds($beds);
            $project->setBaths($baths);
            $project->setCars($cars);
            $project->setStorages($storages);
            $project->setInternalArea($internal_area);
            $project->setExternalArea($external_area);
            $project->setLand($land);
            $project->setSuburb($suburb);
            $project->setState($state);
            $project->setPostcode($post_code);
            $project->setCountry($country);
            $project_bm->saveProject($project);

            //save images & save images into project meta
            $this->saveImages($account, $project, $images, $title);

            //save amenities into project meta
            $this->saveAmenities($project, $amenities);

            if ($account != null) {
                $account = $account->convertToArray();
            }
        } catch (\Exception $e) {
            return new Response($e->getMessage());
        }
        return $this->render('AppBundle:Default:index.html.twig', array(
            'user' => $account
        ));
    }

    /**
     * save project image into project meta
     *
     * @param $account
     * @param Project $project
     * @param $images
     * @param $title
     * @throws FailToMoveFileException
     * @throws FailToUploadFileException
     */
    public function saveImages($account, Project $project, $images)
    {
        $project_bm = $this->getProjectBusinessModel();
        $project_meta_bm = $this->getProjectMetaBusinessModel();
        // $file_array[1] name,[2]type,[3]size,[4]error,[5]tmp_path
        $array_images = StringHelper::ObjToArray($images);
        $offset = -1;
        foreach ($array_images as $array_image) {
            $offset++;
            // file basic attribute
            $file_name = $array_image [1];
            $image_temp = $images[$offset]->getPathname(); // path name
            $extension = pathinfo($file_name) ['extension'];

            $relativeFilePath = "uploads" . DIRECTORY_SEPARATOR . hash("md5", $account->getUsername())
                . DIRECTORY_SEPARATOR . $project->getId() . "_" . $project->getTitle() . DIRECTORY_SEPARATOR . uniqid() . ".$extension";
            $fullFilePath = WEBROOT . DIRECTORY_SEPARATOR . $relativeFilePath;

            if (!file_exists(dirname($fullFilePath))) {
                mkdir(dirname($fullFilePath), 0755, true);
            }

            // check upload file is varified & upload action
            if (!is_uploaded_file($image_temp)) {
                throw new FailToMoveFileException();
            }

            if (!move_uploaded_file($image_temp, $fullFilePath)) {
                throw new FailToUploadFileException();
            }

            $project_meta = new ProjectMeta();
            $project_meta->setProject($project);
            $project_meta->setType(ProjectMetaType::image);
            $project_meta->setMetaName($file_name);
            $project_meta->setMetaValue($relativeFilePath);
            $project_meta_bm->newProjectMeta($project_meta);

            // set the first image as the project front image
            if ($offset == 0) {
                $project->setFrontImage($relativeFilePath);
                $project_bm->saveProject($project);
            }
            $dispatcher = $this->get('event_dispatcher');
            $dispatcher->dispatch("iprex.file.uploaded", new FileUploadedEvent($fullFilePath, $relativeFilePath));
        }
        return;
    }

    /**
     * save amenities into project meta
     *
     * @param Project $project
     * @param $amenities
     */
    public function saveAmenities(Project $project, $amenities)
    {
        $project_meta_bm = $this->getProjectMetaBusinessModel();
        foreach ($amenities as $key => $amenity) {
            $project_meta = new ProjectMeta();
            $project_meta->setProject($project);
            $project_meta->setType(ProjectMetaType::amenities);
            $project_meta->setMetaName($key);
            $project_meta->setMetaValue($amenity);
            $project_meta_bm->newProjectMeta($project_meta);
        }
        return;
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
}