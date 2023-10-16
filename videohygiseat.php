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
        $langIso = $this->context->language->iso_code;
        $videoUrl = $this->getVideoUrl($langIso);
        $planPath = $this->getPlanPath($langIso);
        $this->context->smarty->assign(
                [
                    'videoUrl' => $videoUrl,
                    'planPath' => $planPath
                    ]
            );
        return $this->display(__FILE__, 'hook_videoplayer.tpl');
    }
    public function getVideoUrl($langIso){
        $videoUrl = "";
        switch ($langIso) {
            case "fr":
                $videoUrl = "https://www.youtube.com/embed/82qHLOWQaJc?si=GuPD77RFQEXZohBd&rel=0&noad=1";
                break;
            case "en":
                $videoUrl = "https://www.youtube.com/embed/FpsmVe1jlb4?si=DAk7BZZxtkdTgLiQ&rel=0&noad=1";
                break;
            default:
                $videoUrl = "https://www.youtube.com/embed/FpsmVe1jlb4?si=DAk7BZZxtkdTgLiQ&rel=0&noad=1";
                break;
            } 
        return $videoUrl;
    }
    public function getPlanPath($langIso){
        switch ($langIso) {
            case "fr":
                $planPath = $this->_path."\img\SANIAIR_web_FR.PNG";
                break;
            case "en":
                $planPath = $this->_path."\img\SANIAIR_web_EN.PNG";
                break;
            default:
                $planPath = $this->_path."\img\SANIAIR_web_EN.PNG";
                break;
            }
        return $planPath;
    }
    public function getContent(){

    }
}