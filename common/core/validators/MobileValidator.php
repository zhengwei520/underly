<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace common\core\validators;

use Yii;
use yii\validators\Validator;

/**
 * MobileValidator validates that the attribute value is a valid mobile
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class MobileValidator extends Validator
{
    /**
     * @var string the regular expression used to validate the attribute value.
     * @see http://www.regular-expressions.info/email.html
     */
    public $pattern = '/^[1][34578][0-9]{9}$/';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->message === null) {
            $this->message = Yii::t('yii', '{attribute}不是有效的手机号码.');
        }
    }

    /**
     * @inheritdoc
     */
    protected function validateValue($value)
    {
        if (!is_string($value)) {
            $valid = false;
        } else {
            $valid = preg_match($this->pattern, $value);
        }

        return $valid ? null : [$this->message, []];
    }
}
