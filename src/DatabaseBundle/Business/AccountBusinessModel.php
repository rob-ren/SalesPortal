<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 10/8/17
 * Time: 3:32 PM
 */

namespace DatabaseBundle\Business;

use DatabaseBundle\Common\SHAEncoder;
use DatabaseBundle\Common\StringHelper;
use DatabaseBundle\Entity\Account;

class AccountBusinessModel extends AbstractBusinessModel
{
    protected $encoder;

    public function __construct($doctrine)
    {
        parent::__construct($doctrine);
        $this->entity = new Account ();
        $this->encoder = new SHAEncoder();
    }

    /**
     * create a new User
     *
     * @param Account $account
     * @return Account
     */
    public function newUser(Account $account)
    {
        $salt = StringHelper::generateRandomString("10");
        $account->setUsername($account->getEmail());
        $account->setPassword($this->encoder->encodePassword($account->getPassword(), $salt));
        $account->setSalt($salt);
        $this->persistEntity($account);
        return $account;
    }

    /**
     * update User Password
     *
     * @param Account $account
     * @return Account
     */
    public function updatePassword(Account $account)
    {
        $account->setPassword($this->encoder->encodePassword($account->getPassword(), $account->getSalt()));
        $this->persistEntity($account);
        return $account;
    }

    /**
     * get All User by pagination
     *
     * @param int $max_result_size
     * @param int $page
     * @return array
     */
    public function getAllUser($max_result_size = 3, $page = 0)
    {
        $qb = $this->getQueryBuilder("DatabaseBundle:Account", "account");
        $dql = "account.id >= :id";
        $qb->where($dql)->setParameter(":id", 1);
        $qb->setFirstResult($page * $max_result_size);
        $qb->setMaxResults($max_result_size);
        $query = $qb->getQuery();
        return $query->getResult();
    }

}