<?php
/**
 * 
 *  @category  Priyank Jain
 *  @package   Neosoft_BannerSlider
 *  @copyright Copyright (c) 2018
 *  @license   priyank.jain@wwindia.com
 * 
 */

namespace Neosoft\BannerSlider\Controller\Adminhtml;

abstract class Slider extends \Magento\Backend\App\Action
{
    /**
     * Slider Factory
     * 
     * @var \Neosoft\BannerSlider\Model\SliderFactory
     */
    protected $sliderFactory;

    /**
     * Core registry
     * 
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry;

    /**
     * Result redirect factory
     * 
     * @var \Magento\Backend\Model\View\Result\RedirectFactory
     */

    /**
     * constructor
     * 
     * @param \Neosoft\BannerSlider\Model\SliderFactory $sliderFactory
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Neosoft\BannerSlider\Model\SliderFactory $sliderFactory,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Backend\App\Action\Context $context
    )
    {
        $this->sliderFactory         = $sliderFactory;
        $this->coreRegistry          = $coreRegistry;
        parent::__construct($context);
    }

    /**
     * Init Slider
     *
     * @return \Neosoft\BannerSlider\Model\Slider
     */
    protected function initSlider()
    {
        $sliderId  = (int) $this->getRequest()->getParam('slider_id');
        /** @var \Neosoft\BannerSlider\Model\Slider $slider */
        $slider    = $this->sliderFactory->create();
        if ($sliderId) {
            $slider->load($sliderId);
        }
        $this->coreRegistry->register('neosoft_bannerslider_slider', $slider);
        return $slider;
    }
}
