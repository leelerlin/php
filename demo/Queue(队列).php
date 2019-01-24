<?php

/**
 * @Author: leeler
 * @Date: 2018-08-01 12:10:45
 * @Last modified by: leeler
 * @Last modified time: 2019-01-24 16:58:24
 * @Eamil: 690447824@qq.com
 */

interface QueueI {
    function getSize();
    function isEmpty();
    function inQueue($data);
    function outQueue();
    function getFront();
}
class Queue implements QueueI {
    private $queue = array();
    function __construct() {
    }
    //获取长度
    public function getSize() {
        return count($this->queue);
    }
    //是否为空
    public function isEmpty() {
        return empty($this->queue);
    }
    //入队
    public function inQueue($data) {
        array_push($this->queue, $data);
    }
    //出队
    public function outQueue() {
        if ($this->isEmpty()) {
            echo '队列未空';
        } else {
            return array_shift($this->queue);
        }
    }
    //查看队首值
    public function getFront() {
        return $this->queue[0];
    }
    public function __toString() {
        $str  = '';
        $size = $this->getSize();
        for ($i = 0; $i < $size; ++$i) {
            $str .= $this->queue[$i];
            if ($i != $size - 1) {
                $str .= ',';
            } else {
                $str .= '<br/>';
            }
        }
        return $str;
    }
}
$q = new Queue;
echo $q->getSize();
echo '<br/>';
var_dump($q->outQueue());
echo '<br/>';
$q->inQueue('1');
$q->inQueue('2');
$q->inQueue('3');
echo $q;
echo $q->outQueue();
echo '<br/>';
echo $q;
echo $q->outQueue();
echo '<br/>';
echo $q->outQueue();
echo '<br/>';
echo $q->outQueue();
echo '<br/>';
