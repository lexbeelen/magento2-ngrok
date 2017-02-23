<?php

namespace LexBeelen\Ngrok\Plugin\Magento\Store\Model;

/**
 * Class Store
 * @package LexBeelen\Ngrok\Plugin\Magento\Store\Model
 */
class Store
{
    const NGROK_URL = 'ngrok.io';

    /**
     * @var \Magento\Deploy\Model\Mode
     */
    protected $state;

    /**
     * Store constructor.
     * @param \Magento\Framework\App\State $state
     */
    public function __construct(
        \Magento\Framework\App\State $state
    ) {
        $this->state = $state;
    }

    /**
     * Get Protocol
     *
     * @return string
     */
    protected function getProtocol()
    {
        return
            (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            || $_SERVER['SERVER_PORT'] == 443 ? 'https://' : 'http://';
    }

    /**
     * Is Developer Mode
     *
     * @return bool
     */
    protected function isDeveloperMode()
    {
        return $this->state->getMode() === \Magento\Framework\App\State::MODE_DEVELOPER;
    }

    /**
     * @param \Magento\Store\Model\Store $subject
     * @param $result
     * @return string
     */
    public function afterGetBaseUrl(\Magento\Store\Model\Store $subject, $result)
    {
        if(!$this->isDeveloperMode())
        {
            return $result;
        }

        if (isset($_SERVER['HTTP_HOST']) && strpos($_SERVER['HTTP_HOST'], self::NGROK_URL) && in_array($result, array($subject->getConfig($subject::XML_PATH_SECURE_BASE_URL), $subject->getConfig($subject::XML_PATH_UNSECURE_BASE_URL))))
        {
            return $this->getProtocol() . $_SERVER['HTTP_HOST'] . DIRECTORY_SEPARATOR;
        }

        return $result;
    }
}

