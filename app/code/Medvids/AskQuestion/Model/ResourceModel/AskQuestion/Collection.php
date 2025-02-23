<?php
declare(strict_types=1);

namespace Medvids\AskQuestion\Model\ResourceModel\AskQuestion;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'question_id';

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var \Magento\Catalog\Helper\Data
     */
    protected $helper;

    /**
     * Collection constructor.
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Catalog\Helper\Data $helper
     * @param \Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy
     * @param \Magento\Framework\Event\ManagerInterface $eventManager
     * @param \Magento\Framework\DB\Adapter\AdapterInterface|null $connection
     * @param \Magento\Framework\Model\ResourceModel\Db\AbstractDb|null $resource
     */
    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Helper\Data $helper,
        \Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\Framework\DB\Adapter\AdapterInterface $connection = null,
        \Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource = null
    ) {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
        $this->storeManager = $storeManager;
        $this->helper = $helper;
    }

    protected function _construct()
    {
        $this->_init(
            \Medvids\AskQuestion\Model\AskQuestion::class,
            \Medvids\AskQuestion\Model\ResourceModel\AskQuestion::class
        );
        //$this->_map['fields']['question_id'] = 'main_table.question_id';
    }

    public function addStoreFilter(int $storeId = 0): self
    {
        if (!$storeId) {
            $storeId = (int) $this->storeManager->getStore()->getId();
        }

        $this->addFilter('store_id', $storeId);

        return $this;
    }

    public function addSkuFilter(string $sku = ''): self
    {
        if (!$sku && $this->helper->getProduct() !== null) {
            $sku = $this->helper->getProduct()->getSku();
        }

        $this->addFilter('product_sku', $sku);

        return $this;
    }
}
