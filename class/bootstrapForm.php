<?php

namespace ablin42;

class bootstrapForm extends form
{
    private $label_name;
    private $label_class;
    private $info_text;
    private $info_class;
    private $info_use;
    private $info_id;

    public function label($name, $for, $class = "")
    {
        return "<label for=\"{$for}\" class=\"{$class}\">{$name}</label>";
    }

    public function setLabel($label_name, $label_class = "")
    {
        $this->label_name = $label_name;
        $this->label_class = $label_class;
    }

    public function info($text, $id = "", $class = "", $use = "no")
    {
        if ($use === "no")
            return '';
        else
            return "<span id=\"$id\" class=\"$class\">$text</span>";
    }

    public function setInfo($info_text, $info_id = "", $info_class = "", $info_use = "")
    {
        $this->info_text = $info_text;
        $this->info_class = $info_class;
        $this->info_use = $info_use;
        $this->info_id = $info_id;
    }

    public function input($name, $id = "", $class = "", $placeholder = "", $maxlength = "")
    {
        return $this->surround($this->label(ucfirst($this->label_name), $name, $this->label_class)
                . "<input type=\"text\" name=\"{$name}\" placeholder=\"{$placeholder}\" id=\"{$id}\" class=\"{$class}\" maxlength=\"$maxlength\" required>"
                . $this->info($this->info_text, $this->info_id, $this->info_class, $this->info_use));
    }

    public function email($name, $id = "", $class = "", $placeholder = "Email", $maxlength = "")
    {
        return $this->surround($this->label(ucfirst($this->label_name), $name, $this->label_class)
                . "<input type=\"email\" name=\"{$name}\" placeholder=\"{$placeholder}\" id=\"{$id}\" class=\"{$class}\" maxlength=\"$maxlength\" required>"
                . $this->info($this->info_text, $this->info_id, $this->info_class, $this->info_use));
    }

    public function password($name, $id = "", $class = "", $placeholder = "", $maxlength = "")
    {
        return $this->surround($this->label(ucfirst($this->label_name), $name, $this->label_class)
                . "<input type=\"password\" name=\"{$name}\" placeholder=\"{$placeholder}\" id=\"{$id}\" class=\"{$class}\" maxlength=\"$maxlength\" required>"
                . $this->info($this->info_text, $this->info_id, $this->info_class, $this->info_use));
    }

    public function file($name, $id = "", $class = "")
    {
        return $this->surround($this->label(ucfirst($this->label_name), $name, $this->label_class)
            . "<input type=\"file\" name=\"{$name}\" id=\"{$id}\" class=\"{$class}\">");
    }

    public function submit($name, $id = "", $class = "", $value = "OK")
    {
        return $this->surround("<button type=\"submit\" name=\"{$name}\" id=\"{$id}\" class=\"{$class}\">{$value}</button>");
    }

}
