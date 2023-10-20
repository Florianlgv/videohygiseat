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

    public function uninstall()
    {
        $this->unregisterHook('displayVideoLink');
        $this->unregisterHook('header');

        return parent::uninstall();
    }

    public function hookDisplayHeader()
    {
        $this->context->controller->addCSS($this->_path . 'views/css/need-update.css', 'all');

        if ($this->context->controller->php_self == 'category' && (int)Tools::getValue('id_category') == 3) {
            $this->context->controller->addCSS($this->_path . 'views/css/hookvideoplayer.css', 'all');
        }
    }

    public function hookDisplayVideoLink()
    {
        $langIso = $this->context->language->iso_code;
        $videoUrl = $this->getVideoUrl($langIso);
        $planPath = $this->getPlanPath($langIso);

        $this->context->smarty->assign([
            'videoUrl' => $videoUrl,
            'planPath' => $planPath
        ]);

        return $this->display(__FILE__, 'hook_videoplayer.tpl');
    }

    private function getVideoUrl($langIso)
    {
        $defaultVideoUrl = "FpsmVe1jlb4?si=DAk7BZZxtkdTgLiQ&rel=0&noad=1";
        $videoLanguageMapping = [
            'fr' => "82qHLOWQaJc?si=GuPD77RFQEXZohBd&rel=0&noad=1",
            'en' => "FpsmVe1jlb4?si=DAk7BZZxtkdTgLiQ&rel=0&noad=1"
        ];
        $videoUrl = $videoLanguageMapping[$langIso] ?? $defaultVideoUrl;

        return "https://www.youtube.com/embed/$videoUrl";
    }

    private function getPlanPath($langIso)
    {
        $defaultPathImg = "SANIAIR_web_EN.PNG";
        $planLanguageMapping = [
            'fr' => "SANIAIR_web_FR.PNG",
            'en' => "SANIAIR_web_EN.PNG"
        ];
        $planPath = $planLanguageMapping[$langIso] ?? $defaultPathImg;

        return $this->_path . "img/{$planPath}";
    }

    public function getContent()
    {
    }
}
