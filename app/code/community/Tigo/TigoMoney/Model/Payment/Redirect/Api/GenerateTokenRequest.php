<?php

/**
 * Class Tigo_TigoMoney_Model_Payment_Redirect_Api_GenerateTokenRequest
 */
class Tigo_TigoMoney_Model_Payment_Redirect_Api_GenerateTokenRequest
    implements Tigo_TigoMoney_Model_Payment_Redirect_Api_RequestInterface
{
    /**
     * Generate Token Enpoint Path
     */
    const ENDPOINT_PATH = 'v1/oauth/mfs/payments/tokens';

    /**
     * Body contents for generate token request
     */
    const REQUEST_BODY = 'grant_type=client_credentials';

    /**
     * Client Id
     * @var null|string
     */
    protected $_clientId = null;

    /**
     * Client Secret
     * @var null
     */
    protected $_clientSecret = null;

    /**
     * @inheritdoc
     */
    public function getBody()
    {
        return self::REQUEST_BODY;
    }

    /**
     * Client ID Getter
     * @return null|string
     */
    public function getClientId()
    {
        return $this->_clientId;
    }

    /**
     * Client Secret Getter
     * @return null
     */
    public function getClientSecret()
    {
        return $this->_clientSecret;
    }

    /**
     * @inheritdoc
     */
    public function getEndpointPath()
    {
        return self::ENDPOINT_PATH;
    }

    /**
     * @inheritdoc
     */
    public function getHeaders()
    {
        return array(
            Varien_Http_Client::CONTENT_TYPE => Varien_Http_Client::ENC_URLENCODED,
            'Authorization' => 'Basic ' . base64_encode($this->getClientId() . ':' . $this->getClientSecret())
        );
    }

    /**
     * @inheritdoc
     */
    public function getMethod()
    {
        return Varien_Http_Client::POST;
    }

    /**
     * Client ID Setter
     * @param null|string $clientId
     */
    public function setClientId($clientId)
    {
        $this->_clientId = trim((string) $clientId);
    }

    /**
     * Client Secret Setter
     * @param null $clientSecret
     */
    public function setClientSecret($clientSecret)
    {
        $this->_clientSecret = trim((string) $clientSecret);
    }

    /**
     * @inheritdoc
     */
    public function validate()
    {
        return ($this->getBody() && $this->getClientId() && $this->getClientSecret());
    }
}