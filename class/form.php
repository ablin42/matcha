<?php

namespace ablin42;

class form
{
    private $data = array();
    public $surroundopen = 'div';
    public $surroundclose = 'div';

    public function __construct($data = array())
    {
        $this->data = $data;
    }

    protected function surround($html)
    {
        return "<{$this->surroundopen}>{$html}</{$this->surroundclose}>";
    }

    public function changeSurr($surropen, $surrclose)
    {
        $this->surroundopen = $surropen;
        $this->surroundclose = $surrclose;
    }

    public function input($name, $id = "", $class = "")
    {
        return $this->surround("<input type=\"text\" name=\"{$name}\" id=\"{$id}\" class=\"{$class}\">");
    }

    public function email($name, $id = "", $class = "")
    {
        return $this->surround("<input type=\"email\" name=\"{$name}\" id=\"{$id}\" class=\"{$class}\">");
    }

    public function password($name, $id = "", $class = "")
    {
        return $this->surround("<input type=\"password\" name=\"{$name}\" id=\"{$id}\" class=\"{$class}\">");
    }

    public function hidden($name, $value, $id = "")
    {
        return $this->surround("<input type=\"hidden\" name=\"{$name}\" id=\"{$id}\" value=\"{$value}\">");
    }

    public function textarea($name, $id = "", $class = "", $rows = "4", $cols = "50", $placeholder = "", $maxlength = "")
    {
        return $this->surround("<textarea name=\"{$name}\" id=\"{$id}\" class=\"{$class}\" rows=\"{$rows}\" cols=\"{$cols}\" placeholder=\"{$placeholder}\" maxlength=\"$maxlength\" required></textarea>");
    }

    public function file($name, $id = "", $class = "")
    {
        return $this->surround("<input type=\"file\" name=\"{$name}\" id=\"{$id}\" class=\"{$class}\">");
    }

    public function submit($name, $id = "", $class = "", $value = "OK")
    {
        return $this->surround("<button type=\"submit\" name=\"{$name}\" id=\"{$id}\" class=\"{$class}\">{$value}</button>");
    }
}