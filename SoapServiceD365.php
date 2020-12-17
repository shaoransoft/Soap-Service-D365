<?php
/* Microsoft Dynamics365 SOAP Service 1.1 */
/* -- Shaoransoft Develop -- */

class SoapServiceD365 {
  private $authentication = SOAP_AUTHENTICATION_BASIC;
  private $user;
  private $pwd;
  private $trace = 1;
  private $exception = 0;
  private $uri;

  public function setUsername($user) {
    if (isset($user)) $this->user = $user;
    return $this;
  }

  public function setPassword($pwd) {
    if (isset($pwd)) $this->pwd = $pwd;
    return $this;
  }

  public function setAuth($user, $pwd) {
    setUsername($user)->setPassword($pwd);
    return $this;
  }

  public function setUri($uri) {
    if (isset($uri)) $this->uri = $uri;
    return $this;
  }

  private function getOptions() {
    return [
      'authentication' => $this->authentication,
      'login' => $this->user,
      'password' => $this->pwd,
      'trace' => $this->trace,
      'exception' => $this->exception,
    ];
  }

  public function callMethod($method, $params = false) {
    if (extension_loaded('soap')) {
      try {
        $soapClient = new SoapClient($this->uri, $this->getOptions());
        $res = $soapClient->__soapCall($method, ['parameters' => $params]);
        if (isset($res))
          return ['status' => 'ok', 'value' => $res->return_value];
        else
          return ['status' => 'failed', 'error' => 'not response'];
      }
      catch (Exception $e) {
        return ['status' => 'failed', 'error' => $e->getMessage()];
      }
    }
    else {
      echo 'Php SOAP extention is not available. Please enable/install it to handle SOAP communication.';
      exit;
    }
  }
}
?>
