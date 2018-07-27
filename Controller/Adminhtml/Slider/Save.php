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

class Save extends \Neosoft\BannerSlider\Controller\Adminhtml\Slider
{

    /**
     * JS helper
     * 
     * @var \Magento\Backend\Helper\Js
     */
    protected $jsHelper;

    /**
     * constructor
     * 
     * @param \Magento\Backend\Helper\Js $jsHelper
     * @param \Neosoft\BannerSlider\Model\SliderFactory $sliderFactory
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Backend\Helper\Js $jsHelper,
        \Neosoft\BannerSlider\Model\SliderFactory $sliderFactory,
        \Magento\Framework\Registry $registry,
        \Magento\Backend\App\Action\Context $context
    )
    {
        $this->jsHelper       = $jsHelper;
        parent::__construct($sliderFactory, $registry, $context);
    }

    /**
     * run the action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $data = $this->getRequest()->getPost('slider');
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $slider = $this->initSlider();
            $slider->setData($data);
            $banners = $this->getRequest()->getPost('banners', -1);
            if ($banners != -1) {
                $slider->setBannersData($this->jsHelper->decodeGridSerializedInput($banners));
            }
            $this->_eventManager->dispatch(
                'neosoft_bannerslider_slider_prepare_save',
                [
                    'slider' => $slider,
                    'request' => $this->getRequest()
                ]
            );
            try {
                $slider->save();
                $this->messageManager->addSuccess(__('The Slider has been saved.'));
                $this->_session->setNeosoftBannerSliderSliderData(false);
                if ($this->getRequest()->getParam('back')) {
                    $resultRedirect->setPath(
                        'neosoft_bannerslider/*/edit',
                        [
                            'slider_id' => $slider->getId(),
                            '_current' => true
                        ]
                    );
                    return $resultRedirect;
                }
                $resultRedirect->setPath('neosoft_bannerslider/*/');
                return $resultRedirect;
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the Slider.'));
            }
            $this->_getSession()->setNeosoftBannerSliderSliderData($data);
            $resultRedirect->setPath(
                'neosoft_bannerslider/*/edit',
                [
                    'slider_id' => $slider->getId(),
                    '_current' => true
                ]
            );
            return $resultRedirect;
        }
        $resultRedirect->setPath('neosoft_bannerslider/*/');
        return $resultRedirect;
    }
}
