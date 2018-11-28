<?php
namespace app\components;
interface PaymentInterface
{
    public function printForm($params=[]);
    public function validate($params=[]);
    public function send($params=[]);
}