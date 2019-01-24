<?php

/**
 * @Author: leeler
 * @Date: 2018-07-30 17:08:23
 * @Last modified by: leeler
 * @Last modified time: 2018-08-01 12:10:04
 * @Eamil: 690447824@qq.com
 */
interface StackI {
    public function isEmpty();
    public function isFull();
    public function getSize();
    public function push($data);
    public function pop();
    public function top();
    public function __toString();
}

class data {
    //数据
    private $data;
    public function __construct($data) {
        $this->data = $data;
        echo $data . ":哥入栈了！<br>";
    }
    public function getData() {
        return $this->data;
    }
    public function __destruct() {
        echo $this->data . "：哥走了！<br>";
    }
}
class stack implements StackI {
    private $size;
    private $top;
    private $stack = array();
    public function __construct($size = 10) {
        $this->size = $size;
        $this->top  = -1;
    }
    //判断栈是否为空
    public function isEmpty() {
        if ($this->top == -1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    //判断栈是否已满
    public function isFull() {
        if ($this->top < $this->size - 1) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    //获取栈的大小
    public function getSize() {
        return $this->size;
    }
    //入栈
    public function push($data) {
        if ($this->isFull()) {
            echo "栈满了<br />";
        } else {
            $this->stack[++$this->top] = new data($data);
        }
    }
    //出栈
    public function pop() {
        if ($this->isEmpty()) {
            echo "栈空着呢<br />";
        } else {
            unset($this->stack[$this->top--]);
        }
    }
    //读取栈顶元素
    public function top() {
        return $this->isEmpty() ? "栈空无数据！" : $this->stack[$this->top]->getData();
    }
    public function __toString() {
        $str = '';
        for ($i = 0; $i <= $this->top; ++$i) {
            $str .= $this->stack[$i]->getData();
            if ($i != $this->top) {
                $str .= ',';
            } else {
                $str .= '<br/>';
            }
        }
        return $str;
    }
}
$stack = new stack(4);
var_dump($stack->isFull(), $stack->isEmpty());
$stack->pop();
$stack->push("aa");
$stack->push("aa1");
echo $stack;
$stack->pop();
$stack->push("aa2");
$stack->push("aa3");
$stack->push("aa4");
echo $stack->top(), '<br />';
var_dump($stack->isFull(), $stack->isEmpty());
$stack->push("aa5");
$stack->push("aa6");
$stack->pop();
$stack->pop();
$stack->pop();
$stack->pop();
$stack->pop();
$stack->pop();
