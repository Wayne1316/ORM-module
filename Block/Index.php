<?php

namespace Astralweb\ORM\Block;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\View\Element\Template;
use Astralweb\Post\Model\ResourceModel\Post\CollectionFactory;
use Magento\Framework\View\Element\Template\Context;

/**
 * Class Index
 * @package Astralweb\ORM\Block
 */
class Index extends Template
{
    public function __construct(
        Context $context,
        array $data = []
    )
    {
        parent::__construct($context, $data);
    }


    /**
     * @throws \Exception
     */
    public function getEmployee()
    {
        /*
         * Object Manager 是為了示範上較為方便
         * 官方是較不建議這麼做的
         * 在實作過程中，應該使用 DI 的方式注入
         * */
        /* @var $employeeCollection \Astralweb\ORM\Model\ResourceModel\Employee\Collection */
        $objectManager = ObjectManager::getInstance();
        $employeeCollection = $objectManager->get('Astralweb\ORM\Model\ResourceModel\Employee\Collection');

        /*選擇全部欄位*/
        $employeeCollection->addFieldToSelec('*');

        /*選擇單一欄位*/
        $employeeCollection->addFieldToSelec('entity_id');

        /*選擇單一欄位，給予別名*/
        $employeeCollection->addFieldToSelec('entity_id as id');


        /*查詢 entity_id 等於 (Equals) 1 的資料*/
        $employeeCollection->addFieldToFilter('entity_id', 1);

        /*查詢 entity_id  Not Equals 1 的資料 */
        $employeeCollection->addFieldToFilter('entity_id', ['neq' => '1']);

        /*查詢 entity_id 存在陣列中的資料*/
        $array = [1, 2, 3, 4, 5];
        $employeeCollection->addFieldToFilter('entity_id', ['in' => $array]);

        /*查詢 entity_id  Not In  陣列中的資料 */
        $array = [1, 2, 3, 4, 5];
        $employeeCollection->addFieldToFilter('entity_id', ['nin' => $array]);

        /*查詢 name  Not null 的資料 */
        $employeeCollection->addFieldToFilter('name', ['notnull' => true]);

        /*查詢 entity_id  Greater Than 5 的資料 */
        $employeeCollection->addFieldToFilter('entity_id', ['gt' => 5]);

        /*查詢 entity_id  Less Than  5 的資料 */
        $employeeCollection->addFieldToFilter('entity_id', ['lt' => 5]);

        /*設定 每頁顯示幾筆 */
        $employeeCollection->setPageSize(3);

        /*設定 每頁顯示幾筆 */
        $employeeCollection->setCurPage(1);


        /* 排序 entity_id  做排序 */
        $employeeCollection->setOrder('entity_id');

        /* 排序 entity_id  做倒序 */
        $employeeCollection->setOrder('entity_id', 'desc');

        /**
         * 取得 Collection
         * 若是不使用此方法也可以直接取得 Collection
         **/
        $employeeCollection->getItems();

        /**
         *  取得 Entity 物件
         * 以本篇為例，會回傳 employee 的 model Entity
         **/
        $employeeCollection->getFirstItem();

        /* 取得 全部的 ID */
        $employeeCollection->getAllIds();


        /*
         * 查詢條件：
         * 性別：男
         * 年齡：大於30
         * 部門別：行銷部
         * 排序：員工id 倒續
         * 每頁數量： 10 筆
         * 當前頁面：第 1 頁
         * */
        $employees = $employeeCollection
            ->addFieldToSelect('*')
            ->addFieldToSelect('gender', '男')
            ->addFieldToSelect('age', ['gt' => 30])
            ->addFieldToSelect('department', 'marketing')
            ->setOrder('entity_id', 'desc')
            ->setPageSize('10')
            ->setCurPage(1)
            ->getItems();


        /* 取得資料*/
        /* @var $employees \Astralweb\ORM\Model\Employee[] */
        $employees = $employeeCollection
            ->addFieldToSelect('*')
            ->addFieldToSelect('gender', '男')
            ->getItems();

        /* 使用 for 迴圈取得 每個 entity 的資料 */
        foreach ($employees as $employee) {

            /*
             * 除了getEntityId 的方法之外
             * 其餘的方法，都是Magento自動從資料表中欄位生成
             * 轉換原則：
             * 1. get+欄位名稱
             * 2.字首改大寫
             * 3.底線移除
             * 4.底線移除後第一個字首也為大寫
             *
             * ex:
             * name => getName();
             * sec_department => getSecDepartment();
             * */
            $employee->getEntityId();
            $employee->getName();
            $employee->getAge();
            $employee->getDepartment();
            $employee->getGender();

        }


        /* @var $employeeEntity \Astralweb\ORM\Model\Employee */
        $objectManager = ObjectManager::getInstance();

        /*
         * 新增 (Insert) 資料
         * */
        $employeeEntity = $objectManager->get('Astralweb\ORM\Model\Employee');
        $employeeEntity->addData([
            'name' => '歐斯瑞',
            'department' => '工程部',
            'age' => '18',
            'gender' => '男',
            'id' => 'A123456789',
            'phone' => '02-27926381',
        ])->save();

        /*
        * 刪除 (delete) 資料
        * */
        $employeeEntity = $objectManager->get('Astralweb\ORM\Model\Employee');
        $employeeEntity->load(1)->delete();


        /* 使用collection 方法刪除*/
        /* @var $employees \Astralweb\ORM\Model\Employee[] */
        $employees = $employeeCollection
            ->addFieldToSelect('*')
            ->addFieldToSelect('gender', '男')
            ->getItems();

        foreach ($employees as $employee) {
            $employee->delete();
        }


        /*
         * 更新（update）資料
         * */
        $employeeEntity = $objectManager->get('Astralweb\ORM\Model\Employee');
        $employeeEntity
            ->load(1)
            ->setData([
                'name' => '歐斯瑞',
                'department' => '工程部',
            ])->save();


    }


}
