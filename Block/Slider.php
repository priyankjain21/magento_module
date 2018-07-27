<?php
/**
 * 
 *  @category  Priyank Jain
 *  @package   Neosoft_BannerSlider
 *  @copyright Copyright (c) 2018
 *  @license   priyank.jain@wwindia.com
 * 
 */

namespace Neosoft\BannerSlider\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\ObjectManagerInterface;
use \Magento\Framework\View\Element\Template\Context;
use Neosoft\BannerSlider\Model\SliderFactory as SliderModelFactory;
use Neosoft\BannerSlider\Model\BannerFactory as BannerModelFactory;


class Slider extends \Magento\Framework\View\Element\Template
{
	protected $sliderFactory;
	protected $bannerFactory;

	public function __construct(
		Context $context,
		SliderModelFactory $sliderFactory,
		BannerModelFactory $bannerFactory
	)
	{
		$this->sliderFactory = $sliderFactory;
		$this->bannerFactory = $bannerFactory;
		parent::__construct($context);
	}

	protected function _prepareLayout()
	{
	}

	public function getSliders()
	{
		$sliderId = $this->getBannerId();
		$model = $this->sliderFactory->create()->load($sliderId);
		if($model && $model->getStatus()==1){
			$banners = $model->getSelectedBannersCollection()->addOrder('position','asc')->addFieldToFilter('status','1');
			return $banners;
		} else{
			return null;
		}

	}

}
