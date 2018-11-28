<?php
namespace app\components;
use yii\base\Exception;
class Bitcoin implements PaymentInterface
{
    public $ipnPassword;
    public $guid;
    public $password;
    public $secondPassword;
    public $error;
    public $address;
    public $amount;
    public $txid;
    function __construct($ipnPassword, $guid, $password, $secondPassword)
    {
        $this->ipnPassword = $ipnPassword;
        $this->guid = $guid;
        $this->password = $password;
        $this->secondPassword = $secondPassword;
    }
    public function printForm($params = [])
    {
        return "";
    }
    public function validate($params = [])
    {
        $this->error = "";
        if ($_SERVER['REMOTE_ADDR'] != "37.187.136.15") {
            $this->error = "Invalid IP, allowed: 37.187.136.15 != ".$_SERVER['REMOTE_ADDR'];
            return false;
        }
        if ($_GET['pass'] != $this->ipnPassword) {
            $this->error = "Invalid password != ".$_GET['pass'];
            return false;
        }
        $value_in_btc = $_GET['value'] / 100000000;
        $this->amount = $value_in_btc;
        $this->address = $_GET['address'];
        echo "*ok*";
        return true;
    }
    public function send($params = [])
    {
        $address = $params['wallet'];
        $amount = $params['amount'] * 100000000;
        $url = "https://blockchain.info/merchant/".$this->guid."/payment?password=".$this->password."&second_password=".$this->secondPassword."&to=$address&amount=$amount";
        $json_data = @file_get_contents($url);
        $json_feed = json_decode($json_data);
        if (isset($json_feed->error)) {
            return $json_feed->error;
        }
        if (isset($json_feed->tx_hash)) {
            $this->txid = $json_feed->tx_hash;
        } else {
            return 'Invalid TXID';
        }
        return '';
    }
    public function generateAddress()
    {
        $label = "order-".time();
        $url = "https://blockchain.info/merchant/".$this->guid."/new_address?password=".$this->password."&second_password=".$this->secondPassword."&label=$label&param=123";
        $json_data = @file_get_contents($url);
        $json_feed = json_decode($json_data);
        if (isset($json_feed->address)) {
            return (string)$json_feed->address;
        } else {
            throw new Exception('Error creating address: '.$json_feed->error);
        }
    }
}