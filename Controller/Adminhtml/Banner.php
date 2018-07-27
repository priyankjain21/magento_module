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

abstract class Banner extends \Magento\Backend\App\Action
{
    /**
     * Banner Factory
     * 
     * @var \Neosoft\BannerSlider\Model\BannerFactory
     */
    protected $bannerFactory;

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
     * @param \Neosoft\BannerSlider\Model\BannerFactory $bannerFactory
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Backend\Model\View\Result\RedirectFactory $resultRedirectFactory
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Neosoft\BannerSlider\Model\BannerFactory $bannerFactory,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Backend\App\Action\Context $context
    )
    {
        $this->bannerFactory         = $bannerFactory;
        $this->coreRegistry          = $coreRegistry;
        parent::__construct($context);
    }

    /**
     * Init Banner
     *
     * @return \Neosoft\BannerSlider\Model\Banner
     */
    protected function initBanner()
    {
        $bannerId  = (int) $this->getRequest()->getParam('banner_id');
        /** @var \Neosoft\BannerSlider\Model\Banner $banner */
        $banner    = $this->bannerFactory->create();
        if ($bannerId) {
            $banner->load($bannerId);
        }
        $this->coreRegistry->register('neosoft_bannerslider_banner', $banner);
        return $banner;
    }
}
