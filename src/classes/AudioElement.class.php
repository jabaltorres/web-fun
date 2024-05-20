<?php

/*
 * This class is used to create a new Audio element
 */

class AudioElement
{

    private string $title;
    private string $src;
    private string $type;
    private bool $controls;
    private bool $autoplay;
    private bool $loop;


    public function __construct($title, $src, $type, $controls = true, $autoplay = false, $loop = false)
    {
        $this->title = $title;
        $this->src = $src;
        $this->type = $type;
        $this->controls = $controls;
        $this->autoplay = $autoplay;
        $this->loop = $loop;
    }

    /**
     * Description: This function is used to set the autoplay attribute
     * @param $autoplay
     * @return string
     */
    public function setAutoplay($autoplay): string
    {
        $this->autoplay = $autoplay;

        if ($this->autoplay == true) {
            return "autoplay='{$this->autoplay}'";
        } else {
            return "";
        }
    }

    public function setLoop($loop)
    {
        $this->loop = $loop;
    }

    public function render(): string
    {
        $html = "<h3 class=\"h5 font-weight-bold\">{$this->title}</h3>";
        $html .= "<audio class=\"audio-player\" controls=\"{$this->controls}\" {$this->setAutoplay($this->autoplay)}  loop=\"{$this->loop}\">";
        $html .= "<source src=\"{$this->src}\" type=\"{$this->type}\">";
        $html .= "</audio>";

        return $html;
    }
}