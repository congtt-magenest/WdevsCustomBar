<?php


namespace Wdevs\CustomBar\ViewModel;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;

/**
 * Class CustomBar
 *
 * Render content base on customer group
 */
class CustomBar implements ArgumentInterface
{
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var Session
     */
    protected $session;

    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * CustomBar constructor.
     * @param ScopeConfigInterface $scopeConfig
     * @param SerializerInterface $serializer
     * @param Session $session
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        SerializerInterface $serializer,
        Session $session
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->serializer = $serializer;
        $this->session = $session;
    }

    /**
     * Return custom content base on the customer group
     *
     * @return bool|string
     */
    public function getCustomerBarContent()
    {
        $options = $this->scopeConfig->getValue('custom_bar/general/options');
        if ($options) {
            try {
                $options = $this->serializer->unserialize($options);
                // We can use Magento\Framework\App\Http\Context to retrieve customer group.
                $currentCustomerGroup = $this->session->getCustomerGroupId();
                foreach ($options as $option) {
                    if ($option['customer_group'] == $currentCustomerGroup) {
                        return $option['content'];
                    }
                }
            } catch (\Exception $exception) {
                return false;
            }
        }
        return false;
    }
}
