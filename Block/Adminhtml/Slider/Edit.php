<?php
/**
 * 
 *  @category  Priyank Jain
 *  @package   Neosoft_BannerSlider
 *  @copyright Copyright (c) 2018
 *  @license   priyank.jain@wwindia.com
 * 
 */

namespace Neosoft\BannerSlider\Block\Adminhtml\Slider;

class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    /**
     * Core registry
     * 
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry;

    /**
     * constructor
     * 
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Backend\Block\Widget\Context $context,
        array $data = []
    )
    {
        $this->coreRegistry = $coreRegistry;
        parent::__construct($context, $data);
    }

    /**
     * Initialize Slider edit block
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId = 'slider_id';
        $this->_blockGroup = 'Neosoft_BannerSlider';
        $this->_controller = 'adminhtml_slider';
        parent::_construct();
        $this->buttonList->update('save', 'label', __('Save Slider'));
        $this->buttonList->add(
            'save-and-continue',
            [
                'label' => __('Save and Continue Edit'),
                'class' => 'save',
                'data_attribute' => [
                    'mage-init' => [
                        'button' => [
                            'event' => 'saveAndContinueEdit',
                            'target' => '#edit_form'
                        ]
                    ]
                ]
            ],
            -100
        );
        $this->buttonList->update('delete', 'label', __('Delete Slider'));
    }
    /**
     * Retrieve text for header element depending on loaded Slider
     *
     * @return string
     */
    public function getHeaderText()
    {
        /** @var \Neosoft\BannerSlider\Model\Slider $slider */
        $slider = $this->coreRegistry->registry('neosoft_bannerslider_slider');
        if ($slider->getId()) {
            return __("Edit Slider '%1'", $this->escapeHtml($slider->getName()));
        }
        return __('New Slider');
    }
}
