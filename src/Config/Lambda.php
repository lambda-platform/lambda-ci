<?php
namespace Lambda\Config;

use CodeIgniter\Config\BaseConfig;


class Lambda extends BaseConfig{

    public $SYSADMIN_LOGIN;
    public $SYSADMIN_PASSWORD;
    public $SYSADMIN_EMAIL;


    //LAMBDA JSON
    public $schema_load_mode;
    public $theme;
    public $domain;
    public $title;
    public $subTitle;
    public $copyright;
    public $favicon;
    public $bg;
    public $logo;
    public $logoText;
    public $super_url;
    public $app_url;
    public $has_language;
    public $withCrudLog;
    public $languages;
    public $controlPanel;
    public $default_language;
    public $role_redirects;
    public $user_data_fields;
    public $data_form_custom_elements;
    public $password_reset_time_out;
    public $static_words;
    public $notify;

    /**
     * @return mixed
     */
    public static function getJWTSECRETKEY()
    {
        return getenv('JWT_SECRET_KEY');
    }

    /**
     * @return mixed
     */
    public static function getJWTTIMETOLIVE()
    {
        return getenv('JWT_TIME_TO_LIVE');
    }

}
