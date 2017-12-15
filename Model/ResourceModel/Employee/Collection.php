<?php
namespace Astralweb\ORM\Model\ResourceModel\Employee;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;


class Collection extends AbstractCollection
{
    /**
     * Initialize resource collection
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('Astralweb\ORM\Model\Employee', 'Astralweb\ORM\Model\ResourceModel\Employee');
    }
}
