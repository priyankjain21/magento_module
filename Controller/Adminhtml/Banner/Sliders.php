<?php
/**
 * 
 *  @category  Priyank Jain
 *  @package   Neosoft_BannerSlider
 *  @copyright Copyright (c) 2018
 *  @license   priyank.jain@wwindia.com
 * 
 */

namespace Neosoft\BannerSlider\Controller\Adminhtml\Banner;

class Sliders extends \Neosoft\BannerSlider\Controller\Adminhtml\Banner
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
     * @param \Neosoft\BannerSlider\Model\BannerFactory $sliderFactory
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory,
        \Neosoft\BannerSlider\Model\BannerFactory $sliderFactory,
        \Magento\Framework\Registry $registry,
        \Magento\Backend\App\Action\Context $context
    )
    {
        $this->resultLayoutFactory = $resultLayoutFactory;
        parent::__construct($sliderFactory, $registry, $context);
    }

    /**
     * @return \Magento\Framework\View\Result\Layout
     */
    public function execute()
    {
        $this->initBanner();
        $resultLayout = $this->resultLayoutFactory->create();
        /** @var \Neosoft\BannerSlider\Block\Adminhtml\Banner\Edit\Tab\Slider $slidersBlock */
        $slidersBlock = $resultLayout->getLayout()->getBlock('banner.edit.tab.slider');
        if ($slidersBlock) {
            $slidersBlock->setBannerSliders($this->getRequest()->getPost('banner_sliders', null));
        }
        return $resultLayout;
    }
}
