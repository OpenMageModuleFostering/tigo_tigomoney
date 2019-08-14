<?php

/**
 * Class Tigo_TigoMoney_Model_Payment_Redirect_Api_GenerateTokenResponse
 */
class Tigo_TigoMoney_Model_Payment_Redirect_Api_GenerateTokenResponse extends
    Tigo_TigoMoney_Model_Payment_Redirect_Api_AbstractResponse
{
    /**
     * Response data key - Access Token
     */
    const RESPONSE_DATA_KEY_ACCESS_TOKEN = 'access_token';

    /**
     * Gets Access Token from response data
     * @return string
     */
    public function getAccessToken()
    {
        return $this->getResponseData(self::RESPONSE_DATA_KEY_ACCESS_TOKEN);
    }

    /**
     * Sets Access Token to response data
     * @param $token
     * @return $this
     */
    public function setAccessToken($token)
    {
        return $this->addResponseData(self::RESPONSE_DATA_KEY_ACCESS_TOKEN, (string) $token);
    }
}