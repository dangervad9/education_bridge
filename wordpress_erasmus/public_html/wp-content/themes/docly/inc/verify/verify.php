<?php
require_once('class.verify-purchase.php');
if (isset($_POST['docly_purchase_code'])){
    $purchase_code = htmlspecialchars($_POST['docly_purchase_code']);
    $o = EnvatoApi2::verifyPurchase( $purchase_code );
    if ( is_object($o) ) {
        echo 'verified';
    } else {
      return '';
    }
}