<?php

namespace Wdevs\CustomBar\Block\Adminhtml\Form\Field;

use Magento\CatalogRule\Model\Rule\CustomerGroupsOptionsProvider;
use Magento\Framework\View\Element\Context;
use Magento\Framework\View\Element\Html\Select;

/**
 * Class CustomerGroupColumn
 *
 * Return customer group options
 */
class CustomerGroupColumn extends Select
{
    /**
     * @var CustomerGroupsOptionsProvider
     */
    protected $customerGroup;

    /**
     * CustomerGroupColumn constructor.
     * @param CustomerGroupsOptionsProvider $customerGroupsOptionsProvider
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        CustomerGroupsOptionsProvider $customerGroupsOptionsProvider,
        Context $context,
        array $data = []
    ) {
        $this->customerGroup = $customerGroupsOptionsProvider;
        parent::__construct($context, $data);
    }

    /**
     * Set "name" for <select> element
     *
     * @param string $value
     * @return $this
     */
    public function setInputName($value)
    {
        return $this->setName($value);
    }

    /**
     * Set "id" for <select> element
     *
     * @param string $value
     * @return $this
     */
    public function setInputId($value)
    {
        return $this->setId($value);
    }

    /**
     * Render block HTML
     *
     * @return string
     */
    public function _toHtml()
    {
        if (!$this->getOptions()) {
            $this->setOptions($this->getSourceOptions());
        }
        return parent::_toHtml();
    }

    /**
     * Return customer group options
     *
     * @return array
     */
    private function getSourceOptions()
    {
        return $this->customerGroup->toOptionArray();
    }
}
