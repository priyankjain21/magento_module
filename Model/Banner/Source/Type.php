<?php
/**
 * 
 *  @category  Priyank Jain
 *  @package   Neosoft_BannerSlider
 *  @copyright Copyright (c) 2018
 *  @license   priyank.jain@wwindia.com
 * 
 */

namespace Neosoft\BannerSlider\Model\Banner\Source;

class Type implements \Magento\Framework\Option\ArrayInterface
{
    const IMAGE = '0';
    const VIDEO = '1';


    /**
     * to option array
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = [
            [
                'value' => self::IMAGE,
                'label' => __('Image')
            ],

            [
                'value' => self::VIDEO,
                'label' => __('Video')
            ],

        ];
        return $options;

    }
}
