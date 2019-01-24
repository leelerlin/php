<?php

/**
 * @Author: leeler
 * @Date: 2018-08-01 20:15:56
 * @Last modified by: leeler
 * @Last modified time: 2018-08-07 19:51:28
 * @Eamil: 690447824@qq.com
 */

interface LinkedListI {
    //public $demmyHead;//虚拟头节点
    function getSize();
    function isEmpty();
    function addFirst($e); //头部添加节点
    function add($e, $index); //添加节点
    function addLast($e); //尾部添加节点
    function contains($e); //是否存在某个元素
    function remove($index); //删除某个节点
    function removeFirst();
    function removeLast();
    function removeE($e);
    function get($index); //获得
    function getFirst();
    function getLast();
    function set($index, $e); //修改
}
class Node {
    public $e;
    public $next;
    function __construct($e = null, Node $next = null) {
        $this->e    = $e;
        $this->next = $next;
    }
}
class LinkedList implements LinkedListI {
    private $size;
    private $dummyNode;
    public function __construct() {
        $this->dummyNode = new Node();
        $this->size      = 0;
    }
    public function getSize() {
        return $this->size;
    }
    public function isEmpty() {
        return $this->size == 0;
    }
    public function addFirst($e) {

        $this->add($e, 0);
    }
    public function add($e, $index) {
        if ($index < 0 OR $index > $this->size) {
            throw new Exception("Illegal Index", 1);
        }
        $prev = $this->dummyNode;
        for ($i = 0; $i < $index; $i++) {
            $prev = $prev->next;
        }
        $node       = new Node($e, $prev->next);
        $prev->next = $node;
        $this->size++;
    }
    public function addLast($e) {
        $this->add($e, $this->size);
    }
    public function contains($e) {
        $current = $this->dummyNode->next;
        for ($i = 0; $i < $this->size; $i++) {
            if ($current->e == $e) {
                return TRUE;
            }
            $current = $current->next;
        }
        return FALSE;
    }
    public function remove($index) {
        if ($index < 0 OR $index >= $this->size) {
            throw new Exception("Illegal Index", 1);
        }
        $prev = $this->dummyNode;
        for ($i = 0; $i < $index; $i++) {
            $prev = $prev->next;
        }
        $removeNode = $prev->next;
        $prev->next = $removeNode->next;
        $this->size--;
        return $removeNode->e;

    }
    public function removeFirst() {
        return $this->remove(0);
    }
    public function removeLast() {
        return $this->remove($this->size - 1);
    }
    public function removeE($e) {
        $prev = $this->dummyNode;
        while ($prev->next != null) {
            if ($prev->next->e == $e) {
                break;
            }
            $prev = $prev->next;
        }
        if ($prev->next != NULL) {
            $prev->next = $prev->next->next;
        }
        $this->size--;
    }
    //获得元素
    public function get($index) {
        if ($index < 0 OR $index >= $this->size) {
            throw new Exception("Illegal Index", 1);
        }
        $current = $this->dummyNode->next;
        for ($i = 0; $i < $index; $i++) {
            $current = $current->next;
        }
        return $current->e;
    }
    public function getFirst() {
        return $this->get(0);
    }
    public function getLast() {
        return $this->get($this->size - 1);
    }
    public function set($index, $e) {
        if ($index < 0 OR $index >= $this->size) {
            throw new Exception("Illegal Index", 1);
        }
        $current = $this->dummyNode->next;
        for ($i = 0; $i < $index; $i++) {
            $current = $current->next;
        }
        $current->e = $e;
    }
    public function __toString() {
        $current = $this->dummyNode->next;
        $str     = '';
        while ($current != NULL) {
            $str .= $current->e . '->';
            $current = $current->next;
        }
        $str .= 'null<br/>';
        return $str;
    }
}

$list = new LinkedList;

$list->addLast('first');
$list->addLast('first2');
$list->addLast('first2');
$list->addLast('first3');
$list->addLast('first4');
$list->addLast('first5');
echo $list;
$list->remove(5);
echo $list;
$list->removeFirst();
echo $list;
$list->removeLast();
echo $list;
$list->removeE('first2');
echo $list;
$list->set(1, 'lie');
echo $list;
