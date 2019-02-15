<?php

class Ndigitec_ThisMonthOrders_Block_View extends Mage_Core_Block_Template
{

    public function getCustomerName(){
        $user = Mage::getSingleton('customer/session')->getCustomer();
        $name=$user->getName();
        return $name;
    }

    public function getPopupContent()
    {
        $user = Mage::getSingleton('customer/session')->getCustomer();
        $email = $user->getEmail();
        $customer = Mage::getModel('customer/customer')->load($user->getId());

        $orderCollection = Mage::getModel('sales/order')->getCollection();
        $orderCollection->addFieldToFilter('customer_email', $email);

        //loop through his orders
        $user_spent_money = 0;
        $orders_created_date = [];
        $monthFirstDay = strtotime(date('Y-m-d', strtotime('first day of this month')));
        $monthLastDay = strtotime(date('Y-m-d', strtotime('last day of this month')));
        foreach ($orderCollection as $_order) {


            $orderCreatedDate = strtotime(explode(" ", $_order->getCreatedAt())[0]);
            if ($orderCreatedDate >= $monthFirstDay && $orderCreatedDate <= $monthLastDay) {
                if ($_order->getData()['status'] === 'complete') {

                    $user_spent_money += $_order->getGrandTotal();//$_order->getSubtotal();

                }

            }
        }
        $userId = $user->getId();
        if (!empty($user_spent_money)) {

            if ($user_spent_money >= 1 && $user_spent_money <= 499) {
                $ruleId = 40;
                $coupontypestring = '2.5%';
                $html[]=$user_spent_money;
                $html[]=$coupontypestring;
                return $html;
            }

            if ($user_spent_money >= 500 && $user_spent_money <= 1499) {
                $ruleId = 41;
                $coupontypestring = '5%';
                $html[]=$user_spent_money;
                $html[]=$coupontypestring;
                return $html;
            }

            if ($user_spent_money >= 1500 && $user_spent_money <= 4999) {
                $ruleId = 42;
                $coupontypestring = '7.5%';
                $html[]=$user_spent_money;
                $html[]=$coupontypestring;
                return $html;
            }
            
            if ($user_spent_money > 5000) {
                $ruleId = 43;
                $coupontypestring = '10%';
                $html[]=$user_spent_money;
                $html[]=$coupontypestring;
                return $html;
            }

        }
        else {
            $html[]=0;
            $html[]='0%';
            return $html;
        }

    }
}
