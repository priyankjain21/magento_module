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

abstract class InlineEdit extends \Magento\Backend\App\Action
{
    /**
     * JSON Factory
     * 
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $jsonFactory;

    /**
     * Slider Factory
     * 
     * @var \Neosoft\BannerSlider\Model\SliderFactory
     */
    protected $sliderFactory;

    /**
     * constructor
     * 
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
     * @param \Neosoft\BannerSlider\Model\SliderFactory $sliderFactory
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
        \Neosoft\BannerSlider\Model\SliderFactory $sliderFactory,
        \Magento\Backend\App\Action\Context $context
    )
    {
        $this->jsonFactory   = $jsonFactory;
        $this->sliderFactory = $sliderFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];
        $postItems = $this->getRequest()->getParam('items', []);
        if (!($this->getRequest()->getParam('isAjax') && count($postItems))) {
            return $resultJson->setData([
                'messages' => [__('Please correct the data sent.')],
                'error' => true,
            ]);
        }
        foreach (array_keys($postItems) as $sliderId) {
            /** @var \Neosoft\BannerSlider\Model\Slider $slider */
            $slider = $this->sliderFactory->create()->load($sliderId);
            try {
                $sliderData = $postItems[$sliderId];//todo: handle dates
                $slider->addData($sliderData);
                $slider->save();
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $messages[] = $this->getErrorWithSliderId($slider, $e->getMessage());
                $error = true;
            } catch (\RuntimeException $e) {
                $messages[] = $this->getErrorWithSliderId($slider, $e->getMessage());
                $error = true;
            } catch (\Exception $e) {
                $messages[] = $this->getErrorWithSliderId(
                    $slider,
                    __('Something went wrong while saving the Slider.')
                );
                $error = true;
            }
        }
        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }

    /**
     * Add Slider id to error message
     *
     * @param \Neosoft\BannerSlider\Model\Slider $slider
     * @param string $errorText
     * @return string
     */
    protected function getErrorWithSliderId(\Neosoft\BannerSlider\Model\Slider $slider, $errorText)
    {
        return '[Slider ID: ' . $slider->getId() . '] ' . $errorText;
    }
}
