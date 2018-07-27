<?php
/**
 * 
 *  @category  Priyank Jain
 *  @package   Neosoft_BannerSlider
 *  @copyright Copyright (c) 2018
 *  @license   priyank.jain@wwindia.com
 * 
 */

namespace Neosoft\BannerSlider\Model\Slider\Source;

class Status implements \Magento\Framework\Option\ArrayInterface
{
    const ENABLED = 1;
    const DISABLE = 2;


    /**
     * to option array
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = [
            [
                'value' => self::ENABLED,
                'label' => __('Enabled')
            ],
            [
                'value' => self::DISABLE,
                'label' => __('Disable')
            ],
        ];
        return $options;

    }
}
