<?php
/**
 * 
 *  @category  Priyank Jain
 *  @package   Neosoft_BannerSlider
 *  @copyright Copyright (c) 2018
 *  @license   priyank.jain@wwindia.com
 * 
 */

namespace Neosoft\BannerSlider\Model;

/**
 * @method Banner setName($name)
 * @method Banner setUploadFile($uploadFile)
 * @method Banner setUrl($url)
 * @method Banner setType($type)
 * @method Banner setStatus($status)
 * @method mixed getName()
 * @method mixed getUploadFile()
 * @method mixed getUrl()
 * @method mixed getType()
 * @method mixed getStatus()
 * @method Banner setCreatedAt(\string $createdAt)
 * @method string getCreatedAt()
 * @method Banner setUpdatedAt(\string $updatedAt)
 * @method string getUpdatedAt()
 * @method Banner setSlidersData(array $data)
 * @method array getSlidersData()
 * @method Banner setIsChangedSliderList(\bool $flag)
 * @method bool getIsChangedSliderList()
 * @method Banner setAffectedSliderIds(array $ids)
 * @method bool getAffectedSliderIds()
 */
class Banner extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Cache tag
     * 
     * @var string
     */
    const CACHE_TAG = 'neosoft_bannerslider_banner';

    /**
     * Cache tag
     * 
     * @var string
     */
    protected $_cacheTag = 'neosoft_bannerslider_banner';

    /**
     * Event prefix
     * 
     * @var string
     */
    protected $_eventPrefix = 'neosoft_bannerslider_banner';

    /**
     * Slider Collection
     * 
     * @var \Neosoft\BannerSlider\Model\ResourceModel\Slider\Collection
     */
    protected $sliderCollection;

    /**
     * Slider Collection Factory
     * 
     * @var \Neosoft\BannerSlider\Model\ResourceModel\Slider\CollectionFactory
     */

    protected $imageModel;


    /**
     * constructor
     * 
     * @param \Neosoft\BannerSlider\Model\ResourceModel\Slider\CollectionFactory $sliderCollectionFactory
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Neosoft\BannerSlider\Model\ResourceModel\Slider\CollectionFactory $sliderCollectionFactory,
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,


        array $data = []
    )
    {
        $this->sliderCollectionFactory = $sliderCollectionFactory;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }


    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Neosoft\BannerSlider\Model\ResourceModel\Banner');
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * get entity default values
     *
     * @return array
     */
    public function getDefaultValues()
    {
        $values = [];
        $values['type'] = '';
        return $values;
    }
    /**
     * @return array|mixed
     */
    public function getSlidersPosition()
    {
        if (!$this->getId()) {
            return array();
        }
        $array = $this->getData('sliders_position');
        if (is_null($array)) {
            $array = $this->getResource()->getSlidersPosition($this);
            $this->setData('sliders_position', $array);
        }
        return $array;
    }

    /**
     * @return \Neosoft\BannerSlider\Model\ResourceModel\Slider\Collection
     */
    public function getSelectedSlidersCollection()
    {
        if (is_null($this->sliderCollection)) {
            $collection = $this->sliderCollectionFactory->create();
            $collection->join(
                'neosoft_bannerslider_banner_slider',
                'main_table.slider_id=neosoft_bannerslider_banner_slider.slider_id AND neosoft_bannerslider_banner_slider.banner_id='.$this->getId(),
                ['position']
            );
            $collection->addFieldToFilter('status',1);

            $this->sliderCollection = $collection;
        }
        return $this->sliderCollection;
    }

    /**
     * get full banner url
     * @return string
     */
    public function getBannerUrl()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $storeManager = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');
        $baseUrl = $storeManager->getStore()->getBaseUrl();
        return $baseUrl . 'pub/media/neosoft/bannerslider/banner/image' . $this->getUploadFile();

    }
}
