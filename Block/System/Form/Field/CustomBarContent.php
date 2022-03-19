<?php

namespace Wdevs\CustomBar\Block\System\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\LocalizedException;
use Wdevs\CustomBar\Block\Adminhtml\Form\Field\CustomerGroupColumn;

/**
 * Class CustomBarContent
 *
 * Render dynamic rows in the system configuration
 */
class CustomBarContent extends AbstractFieldArray
{

    /**
     * @var CustomerGroupColumn
     */
    private $customerGroupRenderer;

    /**
     * Prepare to render
     *
     * @throws LocalizedException
     */
    protected function _prepareToRender()
    {
        $this->addColumn('customer_group', [
            'label' => __('Customer Group'),
            'renderer' => $this->getRenderer()
        ]);

        $this->addColumn('content', [
            'label' => __('Content'),
            'class' => 'required-entry'
        ]);

        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add bar content');
    }

    /**
     * Prepare existing row data object
     *
     * @param DataObject $row
     * @throws LocalizedException
     */
    protected function _prepareArrayRow(DataObject $row)
    {
        $options = [];

        $customerGroup = $row->getApplyTo();
        if ($customerGroup !== null) {
            $options['option_' . $this->getRenderer()->calcOptionHash($customerGroup)] = 'selected="selected"';
        }

        $row->setData('option_extra_attrs', $options);
    }

    /**
     * Get customer group renderer
     *
     * @return CustomerGroupColumn
     * @throws LocalizedException
     */
    private function getRenderer()
    {
        if (!$this->customerGroupRenderer) {
            $this->customerGroupRenderer = $this->getLayout()->createBlock(
                CustomerGroupColumn::class,
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }
        return $this->customerGroupRenderer;
    }
}
