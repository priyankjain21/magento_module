<?php
/**
 * 
 *  @category  Priyank Jain
 *  @package   Neosoft_BannerSlider
 *  @copyright Copyright (c) 2018
 *  @license   priyank.jain@wwindia.com
 * 
 */

namespace Neosoft\BannerSlider\Controller\Adminhtml\Slider;

class Banners extends \Neosoft\BannerSlider\Controller\Adminhtml\Slider
{
    /**
     * Result layout factory
     * 
     * @var \Magento\Framework\View\Result\LayoutFactory
     */
    protected $resultLayoutFactory;

    /**
     * constructor
     * 
     * @param \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory
     * @param \Neosoft\BannerSlider\Model\SliderFactory $bannerFactory
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory,
        \Neosoft\BannerSlider\Model\SliderFactory $bannerFactory,
        \Magento\Framework\Registry $registry,
        \Magento\Backend\App\Action\Context $context
    )
    {
        $this->resultLayoutFactory = $resultLayoutFactory;
        parent::__construct($bannerFactory, $registry, $context);
    }

    /**
     * @return \Magento\Framework\View\Result\Layout
     */
    public function execute()
    {
        $this->initSlider();
        $resultLayout = $this->resultLayoutFactory->create();
        /** @var \Neosoft\BannerSlider\Block\Adminhtml\Slider\Edit\Tab\Banner $bannersBlock */
        $bannersBlock = $resultLayout->getLayout()->getBlock('slider.edit.tab.banner');
        if ($bannersBlock) {
            $bannersBlock->setSliderBanners($this->getRequest()->getPost('slider_banners', null));
        }
        return $resultLayout;
    }
}
