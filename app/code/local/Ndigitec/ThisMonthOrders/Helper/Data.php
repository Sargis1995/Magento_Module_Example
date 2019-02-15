<?php
class Ndigitec_ThisMonthOrders_Helper_Data extends Mage_Core_Helper_Abstract
{
    function ndigitecLog($some_exp) {
        $root_log_file_path = Mage::getBaseDir('var') . DS . 'log' . DS . 'ndigitec_create_order_log';

        if ( ! file_exists( $root_log_file_path ) ) {
            if ( ! mkdir( $root_log_file_path, 0755, true ) ) {
                file_put_contents(Mage::getBaseDir('var') . DS . 'log' . DS . '/ndigitecLogs.txt', "can't create product log file\n", FILE_APPEND);

            }
        }

        $month = date( "F" );
        if ( ! file_exists( $root_log_file_path . '/' . $month ) ) {
            mkdir( $root_log_file_path . '/' . $month, 0755, true );
        }

        $current_log_name = $root_log_file_path . '/' . $month . '/day ' . date( "d---H_m_s" ) . '.log';

        $handle = fopen( $current_log_name, "a+" );
        fwrite( $handle, print_r($some_exp,1)."\n".date( "d---H_m_s" )."\n"  );
        fclose( $handle );
    }
}