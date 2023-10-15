<?php
class VideoHygiseat extends Module
{
    public function __construct()
    {
        $this->name = 'videohygiseat';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Florian';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);
        $this->bootstrap = true;
        $this->displayName = $this->l('Video HYGISEAT');
        $this->description = $this->l('Lecteur vidéo youtube et texte à droite');
        $this->confirmUninstall = $this->l('Êtes vous sur de vouloir désinstaller ?');

        parent::__construct();

    }
    public function install()
    {
        return parent::install()  &&
            $this->registerHook('displayVideoLink')
            && $this->registerHook('header');
    }
    public function uninstall() {
        $this->unregisterHook('displayVideoLink');
        $this->unregisterHook('header');
        return parent::uninstall();
    }
    public function hookDisplayHeader()
    {
        $this->context->controller->addCSS($this->_path.'views/css/need-update.css', 'all');
        if ($this->context->controller->php_self == 'category' && (int)Tools::getValue('id_category') == 3) {
            $this->context->controller->addCSS($this->_path.'views/css/hookvideoplayer.css', 'all');
        }
    }
    public function hookDisplayVideoLink(){
        $lang_isocode = $this->context->language->iso_code;
        $video_url = $this->getVideoUrl($lang_isocode);
        $this->context->smarty->assign(
                [
                    'video_url' => $video_url
                    ]
            );
        return $this->display(__FILE__, 'hook_videoplayer.tpl');
    }
    public function getVideoUrl($lang_iso){
        $video_url = "";
        switch ($lang_iso) {
            case "fr":
                $video_url = "https://www.youtube.com/embed/82qHLOWQaJc?si=GuPD77RFQEXZohBd&rel=0&noad=1";
                break;
            case "en":
                $video_url = "https://www.youtube.com/embed/FpsmVe1jlb4?si=DAk7BZZxtkdTgLiQ&rel=0&noad=1";
                break;
            default:
                $video_url = "https://www.youtube.com/embed/FpsmVe1jlb4?si=DAk7BZZxtkdTgLiQ&rel=0&noad=1";
                break;
            } 
        return $video_url;
    }
    public function getContent(){

    }
}