<?php
namespace Codeception\Module;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class ApiHelper extends \Codeception\Module
{
    public function seeResponseCodeIsValid()
    {
        $response = $this->getModule('REST')->response;
        var_dump($response);exit;
        \PHPUnit_Framework_Assert::assertRegex('~^<!DOCTYPE HTML(.*?)<html>.*?<\/html>~m', $response);
    }
}
