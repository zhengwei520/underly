<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/2/28
 * Time: 下午3:31
 */

namespace common\core\base;


use common\helpers\CodeHelper;
use yii\base\UserException;

trait Controller
{
    // pages 处理
    protected function getList(array $result, array $params = [])
    {
        $page = $result['pages'];
        $offset = isset($_GET['page']) ? $_GET['page'] : '1';
        $totalPage = ceil($page->totalCount / $page->pageSize);
        $list = ($totalPage >= $offset) ? $result['models'] : [];
        if (isset($params['access_token'])) {
            unset($params['access_token']);
        }
        return array_merge($params, [
            'list'        => $list,
            'currentPage' => $offset,
            'pageSize'    => $page->pageSize,
            'totalPage'   => $totalPage,
            'totalCount'  => $page->totalCount,
        ]);
    }

    /**
     * 验证请求参数字段
     * 支持别名
     *
     * @param array $requests      请求参数
     * @param array $validateField 验证字段，支持别名  ['别名' => 字段， 0 => 字段]
     * @param       string         /array $default       字段默认值
     *
     * @return array
     * @author lengbin(lengbin0@gmail.com)
     * @throws UserException
     */
    public function validateRequestParams($requests, $validateField, $default = '')
    {
        $data = [];
        foreach ($validateField as $key => $field) {
            $param = (isset($requests[$field]) && !empty($requests[$field])) ? $requests[$field] : null;
            if ($default !== '' && $param === null) {
                if (is_array($default)) {
                    $param = (isset($default[$field])) ? $default[$field] : null;
                } else {
                    $param = $default;
                }
            }
            if (is_int($key)) {
                $data[$field] = $param;
            } else {
                $data[$key] = $param;
            }
        }
        if (array_filter($data)) {
            $this->invalidParamException();
        }
        return $data;
    }
}