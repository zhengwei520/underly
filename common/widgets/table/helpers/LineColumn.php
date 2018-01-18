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

    protected $i = 0;

    /**
     * @inheritdoc
     */
    protected function renderDataCellContent()
    {
        $this->i ++;
        if (empty($this->list->pages)) {
            $index = $this->i;
        }else{
            $index = $this->list->pages->page * $this->list->pages->pageSize + $this->i;
        }
        return $index;
    }

}