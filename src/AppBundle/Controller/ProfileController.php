<?php

/**
 * Created by PhpStorm.
 * User: robert
 * Date: 21/8/17
 * Time: 4:32 PM
 */

namespace AppBundle\Controller;


use AppBundle\EventListener\FileUploadedEvent;
use AppBundle\Exceptions\FailToMoveFileException;
use AppBundle\Exceptions\FailToUploadFileException;
use AppBundle\Exceptions\FieldIsNullException;
use DatabaseBundle\Business\AccountBusinessModel;
use DatabaseBundle\Common\StringHelper;
use DatabaseBundle\Entity\Account;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class ProfileController extends Controller
{
    /**
     * render to profile page
     *
     * @return Response
     */
    public function profileAction()
    {
        $account = $this->getUser() ? $this->getUser() : null;
        if ($account != null) {
            $account = $account->convertToArray();
        }
        return $this->render('AppBundle:Default:profile.html.twig', array(
            'user' => $account,
            'result' => array(
                'status' => 'success',
                "type" => "profile",
                'message' => ' '
            )
        ));
    }

    /**
     * update profile details
     *
     * @return Response
     */
    public function updateProfileAction()
    {
        $account = $this->getUser() ? $this->getUser() : null;
        $result = array();

        $first_name = $this->getRequest()->get("first_name");
        $last_name = $this->getRequest()->get("last_name");
        $gender = $this->getRequest()->get("gender");
        $phone_number = $this->getRequest()->get("phone_number");
        $mobile_phone = $this->getRequest()->get("mobile_number");

        try {
            $account->setFirstName($first_name);
            $account->setLastName($last_name);
            $account->setGender($gender);
            $account->setPhone($phone_number);
            $account->setMobilePhone($mobile_phone);
            $account_bm = $this->getAccountBusinessModel();
            $account_bm->persistEntity($account);
            $result = array(
                "status" => "success",
                "type" => "update_profile",
                "message" => "You have updated your profile successfully. "
            );
        } catch (\Exception $e) {
            $result = array(
                "status" => "error",
                "type" => "update_profile",
                "message" => $e->getMessage()
            );
        }
        if ($account != null) {
            $user = $account->convertToArray();
        }
        return $this->render('AppBundle:Default:profile.html.twig', array(
            'user' => $user,
            'result' => $result
        ));
    }

    /**
     * update user password
     */
    public function updatePasswordAction()
    {
        $account = $this->getUser();
        $new_password = $this->getRequest()->get("new_password");
        $re_new_password = $this->getRequest()->get("re_new_password");
        $result = array();
        try {
            if ($new_password != $re_new_password) {
                throw new \Exception ("two password doesn't match");
            }
            $account->setPassword($new_password);
            $account_bm = $this->getAccountBusinessModel();
            $account_bm->updatePassword($account);
            $result = array(
                "status" => "success",
                "type" => "update_password",
                "message" => " "
            );
        } catch (\Exception $e) {
            $result = array(
                "status" => "error",
                "type" => "update_password",
                "message" => $e->getMessage()
            );
        }
        return $this->redirectToRoute("app_logout");
    }

    /**
     * @return mixed
     * @throws FailToMoveFileException
     * @throws FailToUploadFileException
     */
    public function uploadProfileImageAction()
    {
        // check access token is existed
        $account = $this->getUser();
        try {
            // get upload file info, file category & booking id
            $file = $this->getRequest()->files->get("profile_image") ? $this->getRequest()->files->get("profile_image") : null;
            if (!$file) {
                throw new FieldIsNullException();
            }
            // $file_array[1] name,[2]type,[3]size,[4]error,[5]tmp_path
            $file_array = StringHelper::ObjToArray($file);

            // file basic attribute
            $file_name = $file_array [1];
            $image_temp = $file->getPathname(); // path name
            $extension = pathinfo($file_name) ['extension'];

            $relativeFilePath = "uploads" . DIRECTORY_SEPARATOR . hash("md5", $account->getUsername())
                . DIRECTORY_SEPARATOR . "profile" . DIRECTORY_SEPARATOR . uniqid() . ".$extension";
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

            // update booking & contact table, set image field
            $this->saveProfile($account, "/" . $relativeFilePath);

            $dispatcher = $this->get('event_dispatcher');
            $dispatcher->dispatch("iprex.file.uploaded", new FileUploadedEvent($fullFilePath, $relativeFilePath));

            $result = array(
                "status" => "success",
                "type" => "upload_profile_image",
                "message" => "upload_profile_successfully"
            );
        } catch (\Exception $e) {
            $result = array(
                "status" => "error",
                "type" => "upload_profile_image",
                "message" => $e->getMessage()
            );
        }
        if ($account != null) {
            $user = $account->convertToArray();
        }
        return $this->render('AppBundle:Default:profile.html.twig', array(
            'user' => $user,
            'result' => $result
        ));
    }

    /**
     * @param Account $account
     * @param string $relativePath
     * @return void
     */
    protected function saveProfile(Account $account, $relativePath)
    {
        $account->setProfileImage($relativePath);
        $this->getAccountBusinessModel()->persistEntity($account);
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
}