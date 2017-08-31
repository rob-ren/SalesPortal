<?php

namespace AppBundle\Controller;

use AppBundle\Exceptions\PasswordNotSameException;
use DatabaseBundle\Business\AccountBusinessModel;
use DatabaseBundle\Business\ProjectSearchBusinessModel;
use DatabaseBundle\Common\StringHelper;
use DatabaseBundle\Entity\Account;
use DatabaseBundle\Enum\AccountType;
use DatabaseBundle\Exceptions\EmailFormatErrorException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends Controller
{
    /**
     * @return Response
     */
    public function indexAction()
    {
        $account = $this->getUser() ? $this->getUser() : null;
        if ($account != null) {
            $account = $account->convertToArray();
        }
        // get ad projects
        $recent_projects = $this->getRecentProjects(8) ? $this->getRecentProjects(8) : null;

        return $this->render('AppBundle:Default:index.html.twig', array(
            'user' => $account,
            'recent_projects' => $recent_projects
        ));
    }

    /**
     * register action
     *
     * @return JsonResponse
     */
    public function registerAction()
    {
        $first_name = $this->getRequest()->get("first_name") ? $this->getRequest()->get("first_name") : null;
        $last_name = $this->getRequest()->get("last_name") ? $this->getRequest()->get("last_name") : null;
        $email = $this->getRequest()->get("email") ? $this->getRequest()->get("email") : null;
        $password = $this->getRequest()->get("password");
        $confirm_password = $this->getRequest()->get("confirm_password");
        $account_bm = $this->getAccountBusinessModel();
        try {
            // check input info
            if (!$this->isValidEmail($email)) {
                throw new EmailFormatErrorException();
            }
            if ($password != $confirm_password) {
                throw new PasswordNotSameException();
            }

            // create user action
            $account = new Account();
            $account->setFirstName($first_name);
            $account->setLastName($last_name);
            $account->setEmail($email);
            $account->setPassword($password);
            $account->setStatus(1);
            $account->setProfileImage("/images/default_profile.jpg");
            $account->setUserType(AccountType::sales);
            $account_bm->newUser($account);

        } catch (\Exception $e) {
            return new JsonResponse(array('msg' => $e->getMessage()));
        }
        $success_msg = "User Created Successfully. ";
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
     * get recent projects by input number
     */
    public function getRecentProjects($number)
    {
        $project_search_bm = $this->getProjectSearchBusinessModel();
        $recent_projects = $project_search_bm->find(array(), 8);
        $projects_array = array();
        foreach ($recent_projects as $recent_project) {
            $projects_array[] = $recent_project->convertToArray();
        }
        return $projects_array;
    }

    /**
     * @Route("/login", name="login_route")
     */
    public function loginAction()
    {
        $email = $this->getRequest()->get("email") ? $this->getRequest()->get("email") : null;
        $password = $this->getRequest()->get("password") ? $this->getRequest()->get("password") : null;
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('AppBundle:Default:index.html.twig');
    }

    /**
     */
    public function adminAction()
    {
        return new Response ();
    }

    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction()
    {
        // this controller will not be executed,
        // as the route is handled by the Security system
    }

    /**
     * get account business model
     *
     * @return AccountBusinessModel
     */
    public function getAccountBusinessModel()
    {
        return $this->get("account_business");
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
