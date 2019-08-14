<?php

/**
 * Class Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationResponse
 */
class Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationResponse extends
    Tigo_TigoMoney_Model_Payment_Redirect_Api_AbstractResponse
{
    /**
     * Response data key - Redirect Uri
     */
    const RESPONSE_DATA_KEY_AUTH_CODE = 'auth_code';

    /**
     * Response data key - Redirect Uri
     */
    const RESPONSE_DATA_KEY_REDIRECT_URI = 'redirect_uri';

    /**
     * Gets Auth Code from response data
     * @return string
     */
    public function getAuthCode()
    {
        return $this->getResponseData(self::RESPONSE_DATA_KEY_AUTH_CODE);
    }

    /**
     * Gets Redirect URI from response data
     * @return string
     */
    public function getRedirectUri()
    {
        return $this->getResponseData(self::RESPONSE_DATA_KEY_REDIRECT_URI);
    }

    /**
     * Sets Auth Code to response data
     * @param string $authCode
     * @return $this
     */
    public function setAuthCode($authCode)
    {
        return $this->addResponseData(self::RESPONSE_DATA_KEY_AUTH_CODE, (string) $authCode);
    }

    /**
     * Sets Redirect URI to response data
     * @param string $uri
     * @return $this
     */
    public function setRedirectUri($uri)
    {
        return $this->addResponseData(self::RESPONSE_DATA_KEY_REDIRECT_URI, (string) $uri);
    }
}