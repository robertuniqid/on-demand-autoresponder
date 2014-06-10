<?php

class Mail_IMAP{

  protected static $_instance;
  
  /**
   * Retrieve singleton instance
   *
   * @return Mail_IMAP
   */
  public static function getInstance()
  {
      if (null === self::$_instance) {
          self::$_instance = new self();
      }
      return self::$_instance;
  }

  /**
   * Reset the singleton instance
   *
   * @return void
   */
  public static function resetInstance()
  {
      self::$_instance = null;
  }

  private $_server;
  private $_username;
  private $_password;
  private $_ssl;
  private $_auth;
  
  private $_config;

  public function __construct(){
    set_include_path(BASE_PATH . get_include_path());

    require_once 'Zend/Mail.php';
    require_once 'Zend/Mail/Transport/Smtp.php';
  }

  /**
   * @param $server
   * @param $username
   * @param $password
   * @param string $ssl
   * @param string $auth
   * @return void
   */
  public function configure($server,
                            $username,
                            $password,
                            $ssl = 'tls',
                            $auth = 'login'){
      $this->_server   = $server;
      $this->_username = $username;
      $this->_password = $password;
      $this->_ssl      = $ssl;
      $this->_auth     = $auth;

      $this->_setConfig();
  }

  /**
   * @return void
   */
  private function _setConfig(){
    $this->_config = array('ssl'      => $this->_ssl,
                           'auth'     => $this->_auth,
                           'username' => $this->_username,
                           'password' => $this->_password);
  }

  /**
   * @throws Exception
   * @param $from_name
   * @param $to
   * @param $to_name
   * @param $subject
   * @param $message
   * @return bool
   */
  public function sendEmail($from_name, $to, $to_name, $subject, $message){
    if(is_null($this->_config))
      throw new Exception("Email system not configured...");
    
    $mail = new Zend_Mail();

    $mail->setFrom($this->_username, $from_name);
    $mail->addTo($to, $to_name);
    $mail->setSubject($subject);
    $mail->setBodyText($message);
    $mail->setBodyHtml($message);

    return $mail->send($this->_getTransport());
  }

  /**
   * @return Zend_Mail_Transport_Smtp
   */
  private function _getTransport(){
    return new Zend_Mail_Transport_Smtp($this->_server, $this->_config);
  }

  /**
   * @return array
   */
  public function getNewEmails(){
    $mail = $this->_getStorage();

    $messages = array();



    foreach ($mail as $message_id => $message) {
      if (!$message->hasFlag(Zend_Mail_Storage::FLAG_SEEN)) {
        $content = $message->getContent();
        if ($message->isMultiPart()) {
          foreach (new RecursiveIteratorIterator($message) as $part) {
            try {
              if (strtok($part->contentType, ';') == 'text/plain') {
                $content = $part->getContent();
                break;
              }
            } catch (Zend_Mail_Exception $e) {
              // ignore
            }
          }
        } else {
          $content = $message->getContent();
        }

        $content = quoted_printable_decode($content);

        $header = imap_rfc822_parse_headers($mail->getRawHeader($message_id));
        $from_email = $header->from[0]->mailbox . "@" . $header->from[0]->host;

        $messages[] = array(
          'id'            =>  $message_id,
          'name'          =>  $message->from,
          'email_address' =>  $from_email,
          'subject'       =>  $message->subject,
          'content'       =>  $content,
          'receive_date'  =>  $message->date
        );

        $mail->setFlags(
          $mail->getNumberByUniqueId($mail->getUniqueId($message_id)),
          array(Zend_Mail_Storage::FLAG_SEEN)
        );
      }
    }

    return $messages;
  }

  /**
   * @throws Exception
   * @return Zend_Mail_Storage_Imap
   */
  private function _getStorage(){
    if(is_null($this->_config))
      throw new Exception("Email system not configured...");

    require_once(BASE_PATH . 'Zend/Mail/Storage/Imap.php');

    $storage = new Zend_Mail_Storage_Imap(array('host'     => $this->_server,
                                                'user'     => $this->_username,
                                                'password' => $this->_password));

    return $storage;
  }
}