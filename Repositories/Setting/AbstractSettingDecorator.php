<?php namespace App\Repositories\Setting;

use App\Repositories\Setting\SettingInterface;

/**
 * Class AbstractSettingDecorator
 * @package App\Repositories\Setting
 * @author Phillip Madsen
 */
abstract class AbstractSettingDecorator implements SettingInterface
{

    /**
     * @var SettingInterface
     */
    protected $setting;

    /**
     * @param SettingInterface $setting
     */
    public function __construct(SettingInterface $setting)
    {

        $this->setting = $setting;
    }

    /**
     * @return mixed
     */
    public function getSettings()
    {

        return $this->setting->getSettings();
    }
}
