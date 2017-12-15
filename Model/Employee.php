<?php

namespace Astralweb\ORM\Model;

use \Magento\Framework\Model\AbstractModel;

class Employee extends AbstractModel
{


    /**
     * Initialize resource model
     * @return void
     */
    public function _construct()
    {
        $this->_init('Astralweb\ORM\Model\ResourceModel\Employee');
    }


}

