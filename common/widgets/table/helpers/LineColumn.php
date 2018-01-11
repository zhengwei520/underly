<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2018/1/8
 * Time: 下午1:37
 */

namespace common\widgets\table\helpers;


class LineColumn extends Column
{
    public $header = '#';

    /**
     * @inheritdoc
     */
    protected function renderDataCellContent()
    {
        if (empty($this->list->pages)) {
            $index = $this->index;
        }else{
            $index = $this->list->pages->page * $this->list->pages->pageSize + $this->index;
        }
        return $index + 1;
    }

}