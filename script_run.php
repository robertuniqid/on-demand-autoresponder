<?php

require_once('init.php');

if(isset($_POST['email-marker'])) {
  foreach($parsing_map as $k  =>  $parse_information) {
    if(!in_array($parse_information['email'], $_POST['email-marker']))
      unset($parsing_map[$k]);

  }
}

$current_sent = 0;



try {
  foreach($parsing_map as $k => $parse_information) {
    if(!isset($parse_information['currently_sent'])) {
      $parsing_map[$k]['currently_sent'] = 0;
      $parse_information['currently_sent'] = 0;
    }

    $sent_email_content = file_get_contents(BASE_PATH . 'file_storage'. DIRECTORY_SEPARATOR . $parse_information['reply_message_file']);

    $current_emails_sent = array();

    Mail_IMAP::getInstance()->configure($parse_information['host'], $parse_information['email'], $parse_information['password']);

    $ignore_map = Model_Operation_FileStorage::getInstance()->fetchInformation($parse_information['reply_message_track']);

    if(!is_array($ignore_map))
      $ignore_map = array();

    $new_emails = Mail_IMAP::getInstance()->getNewEmails();

    foreach($new_emails as $information) {

      if(in_array($information['email_address'], $current_emails_sent))
        continue;

      if($current_sent % 100 == 0 && $current_sent != 0)
        sleep(900);// The sleep for 15 minutes

      $current_emails_sent[] = $information['email_address'];

      $parsing_map[$k]['currently_sent']++;

      if(in_array($information['id'], $ignore_map))
        continue;

      $this_send_email = $sent_email_content;

      $isReply = strtolower($parse_information['reply_title']) == 'reply' || $parse_information == '';

      if($isReply) {
        $this_send_email .= '<p>On ' . $information['receive_date'] . ', ' . $information['name'] . ' wrote:</p>';

        $to_split = str_replace(array("<br/>", "<br>"), "\n", $information['content']);

        $splitTokens = explode("\n", $to_split);

        foreach($splitTokens as $token)
          $this_send_email .= '<p>>' . $token . '</p>';
      }


      Mail_IMAP::getInstance()->sendEmail($parse_information['reply_name'],
                                          $information['email_address'],
                                          $information['name'],
                                          $isReply ?
                                            (strpos($information['subject'], 'RE :') === 0
                                              ? $information['subject']
                                              : 'RE : ' . $information['subject']) : $information['reply_title'],
                                          $this_send_email
      );

      $ignore_map[] = $information['id'];
      $current_sent++;
    }


    $current_emails_sent = array_merge($current_emails_sent, $new_emails);

    $parsing_map[$k]['total_sent'] = count($ignore_map);
    $parsing_map[$k]['current_sent'] = $new_emails;

    Model_Operation_FileStorage::getInstance()->storeInformation($parse_information['reply_message_track'], $ignore_map);
  }
}catch (Exception $e) {
  echo '<p class="alert-error" style="padding: 0 0 0 20px;border-radius: 5px;margin: 0 auto;">An Error had occured !</p>';
  echo '<p class="text-info">Please Double Check the listing information. Most likey the Incoming Server IMAP Address is wrong</p>';
  echo '<p class="text-info">OR Email Address & Password combination</p>';
  echo '<p class="text-warning">' . $e->getMessage() . '</p>';

  exit;
}

?>

<p class="btn-success" style="padding: 0 0 0 20px;border-radius: 5px;width:100px;margin: 0 auto;">
    Success !
</p>

<table class="table table-striped">
	<thead>
		<tr>
			<th>Email Address</th>
			<th>Current Session Sent</th>
			<th>Total Sent</th>
		</tr>
	</thead>
	<tbody>
	  <?php foreach($parsing_map as $k => $parse_information) : ?>
      <tr class="<?php echo $parse_information['currently_sent'] > 0 ? 'success' : '';?>">
          <td><?php echo $parse_information['email'] ?></td>
          <td><?php echo $parse_information['currently_sent']; ?></td>
          <td><?php echo $parse_information['total_sent'] ?></td>
      </tr>
    <?php endforeach;?>
	</tbody>
</table>

<p style="float:right;"><a href="index.php" class="btn btn-primary btn-large">New &raquo;</a></p>

<a id="show-emails-container" class="btn btn-primary btn-large" href="#">Show Sent Emails »</a>

<div id="sent-emails-container" style="display: none;">
  <h2> Sent Emails On this Run</h2>

  <table class="table table-striped">
      <thead>
      <tr>
          <th>From Email Address</th>
          <th>To</th>
          <th>To Email Address</th>
      </tr>
      </thead>
      <tbody>
      <?php foreach($parsing_map as $k => $parse_information) : ?>
        <?php foreach($parse_information['current_sent'] as $current_sent) : ?>
          <tr>
              <td><?php echo $parse_information['email'] ?></td>
              <td><?php echo $current_sent['name']?></td>
              <td><?php echo $current_sent['email_address']?></td>
          </tr>
        <?php endforeach;?>
      <?php endforeach;?>
      </tbody>
  </table>

  <p style="float:right;"><a href="index.php" class="btn btn-primary btn-large">New &raquo;</a></p>
</div>

