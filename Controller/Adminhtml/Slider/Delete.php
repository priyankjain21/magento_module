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

class Delete extends \Neosoft\BannerSlider\Controller\Adminhtml\Slider
{
    /**
     * execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('slider_id');
        if ($id) {
            $name = "";
            try {
                /** @var \Neosoft\BannerSlider\Model\Slider $slider */
                $slider = $this->sliderFactory->create();
                $slider->load($id);
                $name = $slider->getName();
                $slider->delete();
                $this->messageManager->addSuccess(__('The Slider has been deleted.'));
                $this->_eventManager->dispatch(
                    'adminhtml_neosoft_bannerslider_slider_on_delete',
                    ['name' => $name, 'status' => 'success']
                );
                $resultRedirect->setPath('neosoft_bannerslider/*/');
                return $resultRedirect;
            } catch (\Exception $e) {
                $this->_eventManager->dispatch(
                    'adminhtml_neosoft_bannerslider_slider_on_delete',
                    ['name' => $name, 'status' => 'fail']
                );
                // display error message
                $this->messageManager->addError($e->getMessage());
                // go back to edit form
                $resultRedirect->setPath('neosoft_bannerslider/*/edit', ['slider_id' => $id]);
                return $resultRedirect;
            }
        }
        // display error message
        $this->messageManager->addError(__('Slider to delete was not found.'));
        // go to grid
        $resultRedirect->setPath('neosoft_bannerslider/*/');
        return $resultRedirect;
    }
}
