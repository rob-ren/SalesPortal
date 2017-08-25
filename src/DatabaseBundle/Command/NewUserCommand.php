<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 10/8/17
 * Time: 3:45 PM
 */

namespace DatabaseBundle\Command;

use DatabaseBundle\Business\AccountBusinessModel;
use DatabaseBundle\Common\StringHelper;
use DatabaseBundle\Entity\Account;
use DatabaseBundle\Exceptions\AccountTypeErrorException;
use DatabaseBundle\Exceptions\EmailFormatErrorException;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class NewUserCommand extends ContainerAwareCommand
{
    /**
     * set up configure information
     */
    protected function configure()
    {
        $this->setName('user:new')->setDescription('create new user and add it into database.')->addArgument('email', InputArgument::REQUIRED, 'Input a valid email address.')->addArgument('password', InputArgument::REQUIRED, 'Input your password.')->addArgument('account_type', InputArgument::REQUIRED, 'Define your account type.');
    }

    /**
     * valid email format
     */
    protected function isValidEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match('/@.+\./', $email);
    }

    /**
     * valid account type
     */
    protected function isValidAccountType($account_type)
    {
        $pattern = StringHelper::EnumToArray("DatabaseBundle\Enum\AccountType");
        if (!in_array($account_type, $pattern)) {
            return false;
        }
        return $account_type;
    }

    /**
     * valid password
     */
    protected function isValidPassword($password, $re_password)
    {
        if ($password != $re_password) {
            return false;
        }
        return $password;
    }

    /**
     * get account business model
     *
     * @return AccountBusinessModel
     */
    public function getAccountBusinessModel()
    {
        return $this->getContainer()->get("account_business");
    }

    /**
     * execute command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            // get input user info
            $email = $input->getArgument('email');
            $password = $input->getArgument('password');
            $account_type = $input->getArgument('account_type');

            // check input info
            if (!$this->isValidEmail($email)) {
                throw new EmailFormatErrorException();
            }
            if (!$this->isValidAccountType($account_type)) {
                throw new AccountTypeErrorException();
            }

            // create user action
            $account_bm = $this->getAccountBusinessModel();
            $account = new Account ();
            $account->setFirstName("test");
            $account->setLastName("test");
            $account->setEmail($email);
            $account->setPassword($password);
            $account->setStatus(1);
            $account->setProfileImage("/images/default_profile.jpg");
            $account->setUserType($account_type);
            $account_bm->newUser($account);
            $output->writeln('You have create a new user successfully!');
        } catch (\Exception $e) {
            $output->writeln("Fail create." . $e->getMessage());
        }
    }
}