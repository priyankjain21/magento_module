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

class Save extends \Neosoft\BannerSlider\Controller\Adminhtml\Banner
{
    /**
     * Upload model
     * 
     * @var \Neosoft\BannerSlider\Model\Upload
     */
    protected $uploadModel;

    /**
     * Image model
     * 
     * @var \Neosoft\BannerSlider\Model\Banner\Image
     */
    protected $imageModel;

    /**
     * JS helper
     * 
     * @var \Magento\Backend\Helper\Js
     */
    protected $jsHelper;

    /**
     * constructor
     * 
     * @param \Neosoft\BannerSlider\Model\Upload $uploadModel
     * @param \Neosoft\BannerSlider\Model\Banner\Image $imageModel
     * @param \Magento\Backend\Helper\Js $jsHelper
     * @param \Neosoft\BannerSlider\Model\BannerFactory $bannerFactory
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Neosoft\BannerSlider\Model\Upload $uploadModel,
        \Neosoft\BannerSlider\Model\Banner\Image $imageModel,
        \Magento\Backend\Helper\Js $jsHelper,
        \Neosoft\BannerSlider\Model\BannerFactory $bannerFactory,
        \Magento\Framework\Registry $registry,
        \Magento\Backend\App\Action\Context $context
    )
    {
        $this->uploadModel    = $uploadModel;
        $this->imageModel     = $imageModel;
        $this->jsHelper       = $jsHelper;
        parent::__construct($bannerFactory, $registry, $context);
    }

    /**
     * run the action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $data = $this->getRequest()->getPost('banner');
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $data = $this->filterData($data);
            $banner = $this->initBanner();
            $banner->setData($data);

            $uploadFile = $this->uploadModel->uploadFileAndGetName('upload_file', $this->imageModel->getBaseDir(), $data);

            $banner->setUploadFile($uploadFile);
            $sliders = $this->getRequest()->getPost('sliders', -1);
            if ($sliders != -1) {
                $banner->setSlidersData($this->jsHelper->decodeGridSerializedInput($sliders));
            }
            $this->_eventManager->dispatch(
                'neosoft_bannerslider_banner_prepare_save',
                [
                    'banner' => $banner,
                    'request' => $this->getRequest()
                ]
            );
            try {
                $banner->save();
                $this->messageManager->addSuccess(__('The Banner has been saved.'));
                $this->_session->setNeosoftBannerSliderBannerData(false);
                if ($this->getRequest()->getParam('back')) {
                    $resultRedirect->setPath(
                        'neosoft_bannerslider/*/edit',
                        [
                            'banner_id' => $banner->getId(),
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
                $this->messageManager->addException($e, __('Something went wrong while saving the Banner.'));
            }
            $this->_getSession()->setNeosoftBannerSliderBannerData($data);
            $resultRedirect->setPath(
                'neosoft_bannerslider/*/edit',
                [
                    'banner_id' => $banner->getId(),
                    '_current' => true
                ]
            );
            return $resultRedirect;
        }
        $resultRedirect->setPath('neosoft_bannerslider/*/');
        return $resultRedirect;
    }

    /**
     * filter values
     *
     * @param array $data
     * @return array
     */
    protected function filterData($data)
    {
        if (isset($data['status'])) {
            if (is_array($data['status'])) {
                $data['status'] = implode(',', $data['status']);
            }
        }
        return $data;
    }
}
