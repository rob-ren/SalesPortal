<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 18/8/17
 * Time: 10:00 AM
 */

namespace AppBundle\Controller;


use AppBundle\Exceptions\EmailMessageTooShortException;
use DatabaseBundle\Business\ProjectBusinessModel;
use DatabaseBundle\Business\ProjectMetaBusinessModel;
use DatabaseBundle\Enum\ProjectMetaType;
use DatabaseBundle\Exceptions\EmailFormatErrorException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class SingleController extends Controller
{
    /**
     * render to single page
     *
     * @return Response
     */
    public function singleAction($project_id)
    {
        $account = $this->getUser() ? $this->getUser() : null;
        if ($account != null) {
            $account = $account->convertToArray();
        }
        $project_bm = $this->getProjectBusinessModel();
        $project_meta_bm = $this->getProjectMetaBusinessModel();
        // load project by project id
        $project = $project_bm->loadById($project_id);
        // load similar projects by id and type
        $similar_projects = $project_bm->loadSimilarProjects($project->getId(), $project->getType()) ? $project_bm->loadSimilarProjects($project->getId(), $project->getType()) : null;
        // load project images
        $images = $project_meta_bm->loadByProjectAndType($project, ProjectMetaType::image);
        // load project amenities
        $amenities = $project_meta_bm->loadByProjectAndType($project, ProjectMetaType::amenities);
        $amenities_array = array();
        foreach ($amenities as $amenity) {
            $amenities_array[] = $amenity['meta_name'];
        }

        return $this->render('AppBundle:Default:single.html.twig', array(
            'user' => $account,
            'project' => $project->convertToArray(),
            'similar_projects' => $similar_projects,
            'images' => $images,
            'amenities' => $amenities_array
        ));
    }

    /**
     * @return JsonResponse
     */
    public function sendEmailAction()
    {
        // get form input information
        $full_name = $this->getRequest()->get('full_name') ? $this->getRequest()->get('full_name') : null;
        $email_address = $this->getRequest()->get('email_address') ? $this->getRequest()->get('email_address') : null;
        $email_subject = $this->getRequest()->get('email_subject') ? $this->getRequest()->get('email_subject') : null;
        $apply_message = $this->getRequest()->get('apply_message') ? $this->getRequest()->get('apply_message') : null;
        $receiver = $this->getRequest()->get('receiver');
        $project_title = $this->getRequest()->get('project_title');

        try {
            // verify email is valid
            if (!$this->isValidEmail($email_address)) {
                throw new EmailFormatErrorException();
            }
            // verify message length
            if (strlen($apply_message) < 10) {
                throw new EmailMessageTooShortException();
            }
            //create email template and send email
            $message = \Swift_Message::newInstance()
                ->setSubject($email_subject)
                ->setFrom('info@iprex.net')// my email info
                ->setTo($receiver)// my email info
                ->setBody(
                    "Applied Message from Sales of IPX.net"
                    . "\r\n project title: " . $project_title
                    . "\r\n name: " . $full_name
                    . "\r\n email: " . $email_address
                    . "\r\n message: " . $apply_message
                );
            // send email
            $this->get('mailer')->send($message);
        } catch (\Exception $e) {
            return new JsonResponse(array('msg' => $e->getMessage()));
        }
        $success_msg = "Email Sent Successfully. ";
        return new JsonResponse(array('msg' => $success_msg));
    }

    /**
     * valid email format
     */
    public function isValidEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match('/@.+\./', $email);
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