<?php
/**
 * 
 *  @category  Priyank Jain
 *  @package   Neosoft_BannerSlider
 *  @copyright Copyright (c) 2018
 *  @license   priyank.jain@wwindia.com
 * 
 */

namespace Neosoft\BannerSlider\Block\Adminhtml\Banner\Edit;

class Form extends \Magento\Backend\Block\Widget\Form\Generic
{
    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            [
                'data' => [
                    'id' => 'edit_form',
                    'action' => $this->getData('action'),
                    'method' => 'post',
                    'enctype' => 'multipart/form-data'
                ]
            ]
        );
        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
