<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2018/1/2
 * Time: 上午10:25
 */

namespace common\core\rule;

use yii\rbac\Item;
use yii\rbac\Rule;

/**
 *
 * 特殊权限
 *
 * Class AuthorRule
 * @package server\role\rule
 */
class AuthorRule extends Rule
{
    public $name = 'isAuthor';

    /**
     * Executes the rule.
     *
     * @param string|int $user   the user ID. This should be either an integer or a string representing
     *                           the unique identifier of a user. See [[\yii\web\User::id]].
     * @param Item       $item   the role or permission that this rule is associated with
     * @param array      $params parameters passed to [[CheckAccessInterface::checkAccess()]].
     *
     * @return bool a value indicating whether the rule permits the auth item it is associated with.
     */
    public function execute($user, $item, $params)
    {
        return isset($params['post']) ? $params['post']->createdBy == $user : false;
    }
}                                                                                                    