<?php

namespace Drupal\test_mail\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Mail\MailManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class TestMail extends FormBase {

  protected $mailManager;

  public function __construct(MailManagerInterface $mail_manager) {
    $this->mailManager = $mail_manager;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('plugin.manager.mail')
    );
  }

  public function getFormId() {
    return 'test_mail_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email'),
      '#required' => TRUE,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Send Test Email'),
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $email = $form_state->getValue('email');
    if (empty($email)) {
      \Drupal::messenger()->addError($this->t('Email address is required.'));
      return;
    }
    $params = [
      'subject' => 'Test Email',
      'message' => 'This is a test email.',
    ];
    $message_html = '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Vault-Tec / Abandoned Cart</title><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,400&display=swap" em-class="em-font-Mulish-Regular"><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,500&display=swap" em-class="em-font-Mulish-Medium">
	<style type="text/css">
		html {
			-webkit-text-size-adjust: none;
			-ms-text-size-adjust: none;
		}
	</style>
	<style em="styles">
.em-font-Mulish-Medium,.em-font-Mulish-Regular {
    font-family: Mulish,sans-serif!important;
    font-weight: 500!important;
}
.em-font-Mulish-Regular {
    font-weight: 400!important;
}
@media only screen and (max-device-width:640px),only screen and (max-width:640px) {
    .em-narrow-table {
        width: 100%!important;
        max-width: 640px!important;
        min-width: 320px!important;
    }
    .em-mob-height-20px {
        height: 20px!important;
    }
    .em-mob-width-100perc {
        width: 100%!important;
        max-width: 100%!important;
    }
    .em-mob-wrap {
        display: block!important;
    }
    .em-mob-padding_right-20 {
        padding-right: 20px!important;
    }
    .em-mob-padding_left-20 {
        padding-left: 20px!important;
    }
    .em-mob-wrap.em-mob-wrap-cancel,.noresp-em-mob-wrap.em-mob-wrap-cancel {
        display: table-cell!important;
    }
    .em-mob-width-48perc {
        width: 48%!important;
    }
    .em-mob-text_align-center {
        text-align: center!important;
    }
    .em-mob-font_size-24px {
        font-size: 24px!important;
    }
    .em-mob-font_size-16px {
        font-size: 16px!important;
    }
    .em-mob-line_height-20px {
        line-height: 20px!important;
    }
}
@media only screen and (max-device-width:660px),only screen and (max-width:660px) {
    .em-mob-width-100perc {
        width: 100%!important;
        max-width: 100%!important;
    }
}
</style>
	<!--[if gte mso 9]>
	<xml>
		<o:OfficeDocumentSettings>
		<o:AllowPNG></o:AllowPNG>
		<o:PixelsPerInch>96</o:PixelsPerInch>
		</o:OfficeDocumentSettings>
	</xml>
	<![endif]-->
</head>
<body style="margin: 0px; padding: 0px; background-color: #1e4a89;">
	<span class="preheader" style="visibility: hidden; opacity: 0; color: #1e4a89; height: 0px; width: 0px; font-size: 1px; display: none !important;">&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌</span>
	<!--[if !mso]><!-->
	<div style="font-size:0px;color:transparent;opacity:0;">
		⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
	</div>
	<!--<![endif]-->
	<table cellpadding="0" cellspacing="0" border="0" width="100%" style="font-size: 1px; line-height: normal; background-color: #1e4a89;" bgcolor="#1E4A89">
		<tr em="group">
			<td align="center">
				<!--[if (gte mso 9)|(IE)]>
				<table cellpadding="0" cellspacing="0" border="0" width="640"><tr><td>
				<![endif]-->
				<table cellpadding="0" cellspacing="0" width="100%" border="0" style="max-width: 640px; min-width: 640px; width: 640px;" class="em-narrow-table">
<tr em="block" class="em-structure">
  <td align="center" style="padding: 30px 40px 31px;" class="em-mob-padding_left-20 em-mob-padding_right-20">
    <table border="0" cellspacing="0" cellpadding="0" class="em-mob-width-100perc">
      <tr>
        <td width="270" valign="top" class="em-mob-wrap em-mob-wrap-cancel em-mob-width-48perc">
<table cellpadding="0" cellspacing="0" border="0" width="100%" em="atom"><tr><td>
  <img src="https://cdn.useblocks.io/33359/250213_2102_rOjSv9R.png" width="161" border="0" alt="" style="display: block; width: 100%; max-width: 161px;">
</td></tr></table>
</td>
        <td width="20" class="em-mob-wrap em-mob-height-20px em-mob-wrap-cancel"></td>
        <td width="270" valign="middle" class="em-mob-wrap em-mob-wrap-cancel em-mob-width-48perc"><table cellpadding="0" cellspacing="0" border="0" width="100%" em="atom"><tr><td>
  <div style="font-family: Arial, sans-serif, Monaco, monospace; font-size: 16px; line-height: 24px; color: #ffffff;" align="right"><a href="" target="_blank" style="color: #ffeb32; text-decoration: underline;">Web-Version</a></div>
</td></tr></table></td>
      </tr>
    </table>
  </td>
</tr><tr em="block" class="em-structure">
                                    <td align="center" style="padding: 30px 40px;" class="em-mob-padding_left-20 em-mob-padding_right-20">
                                        <table align="center" border="0" cellspacing="0" cellpadding="0" class="em-mob-width-100perc">
                                            <tr>
                                                <td width="560" valign="top" class="em-mob-wrap em-mob-width-100perc">
                                                    <table cellpadding="0" cellspacing="0" border="0" width="100%" em="atom"><tr><td style="padding: 20px 0px;" align="center">
  <div style="font-family: Arial, sans-serif, Monaco, monospace; font-size: 28px; line-height: 34px; color: #ffeb32;" align="center" class="em-mob-font_size-24px"><strong> Error 101: Incomplete Evacuation Process Detected!</strong></div>
</td></tr></table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" em="atom"><tr><td style="padding-bottom: 11px;">
  <div style="font-family: Arial, sans-serif, Monaco, monospace; font-size: 16px; line-height: 24px; color: #ffffff;">Citizen, you added essential survival items to your cart but did not complete your purchase. Your readiness for the bright post-apocalyptic future is now in question.</div>
</td></tr></table>
                                                </td>
                                            </tr></table>
                                    </td>
</tr><tr em="block" class="em-structure">
  <td align="center" style="padding: 0px 40px;" class="em-mob-padding_left-20 em-mob-padding_right-20">
    <table border="0" cellspacing="0" cellpadding="0" class="em-mob-width-100perc">
      <tr>
        <td width="560" valign="top" class="em-mob-wrap em-mob-width-100perc"><table cellpadding="0" cellspacing="0" border="0" width="100%" em="atom"><tr><td style="padding: 20px 0px;" align="center">
  <div style="font-family: Arial, sans-serif, Monaco, monospace; font-size: 28px; line-height: 34px; color: #ffeb32;" align="center" class="em-mob-font_size-24px"><strong> REMEMBER:</strong></div>
</td></tr></table></td>
      </tr>
    </table>
  </td>
</tr><tr em="block" class="em-structure">
                                    <td align="center" style="padding-right: 40px; padding-bottom: 20px; padding-left: 40px;" class="em-mob-padding_left-20 em-mob-padding_right-20">
                                        <table align="center" border="0" cellspacing="0" cellpadding="0" class="em-mob-width-100perc">
                                            <tr>
                                                <td width="260" valign="top" class="em-mob-wrap em-mob-width-100perc">
                                                    <table cellpadding="0" cellspacing="0" border="0" width="100%" em="atom"><tr><td>
  <img src="https://cdn.useblocks.io/33359/250213_2102_8vzEk5q.png" width="260" border="0" alt="" style="display: block; width: 100%; max-width: 260px;">
</td></tr></table>
                                                </td>
                                            <td width="40" class="em-mob-wrap"></td>
                                             <td width="260" valign="middle" class="em-mob-wrap em-mob-width-100perc"><table cellpadding="0" cellspacing="0" border="0" width="100%" em="atom"><tr><td style="padding-bottom: 11px;">
  <div style="font-family: Arial, sans-serif, Monaco, monospace; font-size: 16px; line-height: 24px; color: #ffffff;" class="em-mob-text_align-center">Without the necessary survival gear, your chances of making it are <strong>significantly reduced.</strong></div>
</td></tr></table><table cellpadding="0" cellspacing="0" border="0" width="100%" em="atom"><tr><td style="padding-bottom: 11px;">
  <div style="font-family: Arial, sans-serif, Monaco, monospace; font-size: 16px; line-height: 24px; color: #ffffff;" class="em-mob-text_align-center">Vault-Tec shelters only accept <strong>prepared individuals.</strong></div>
</td></tr></table><table cellpadding="0" cellspacing="0" border="0" width="100%" em="atom"><tr><td>
  <div style="font-family: Arial, sans-serif, Monaco, monospace; font-size: 16px; line-height: 24px; color: #ffffff;" class="em-mob-text_align-center"><strong>We cannot guarantee</strong> your place in the vault without confirmed payment.</div>
</td></tr></table></td></tr></table>
                                    </td>
</tr>
<tr em="block" class="em-structure">
                                    <td align="center" style="padding: 30px 40px;" class="em-mob-padding_left-20 em-mob-padding_right-20">
                                        <table align="center" border="0" cellspacing="0" cellpadding="0" class="em-mob-width-100perc">
                                            <tr>
                                                <td width="560" valign="top" class="em-mob-wrap em-mob-width-100perc">
<table cellpadding="0" cellspacing="0" border="0" width="100%" em="atom"><tr><td style="padding: 20px 0px;" align="center">
  <div style="font-family: Arial, sans-serif, Monaco, monospace; font-size: 28px; line-height: 34px; color: #ffeb32;" align="center" class="em-mob-font_size-24px">  Complete your order now and receive a <strong>15% discount</strong> on the Geiger Counter X300!</div>
</td></tr></table><table cellpadding="0" cellspacing="0" border="0" width="100%" em="atom"><tr><td>
  <img src="https://cdn.useblocks.io/33359/250213_2102_FOpqqVp.jpg" width="560" border="0" alt="" style="display: block; width: 100%; max-width: 560px; border-radius: 45px;">
</td></tr></table>
                                                <table cellpadding="0" cellspacing="0" border="0" width="100%" em="atom"><tr><td align="center" style="padding-top: 21px; padding-bottom: 21px;">
  <div style="font-family: Arial, sans-serif, Monaco, monospace; font-size: 20px; line-height: 28px;" align="center" class="em-mob-font_size-16px em-mob-line_height-20px"><span style="font-style: italic;"><span style="color: #ffeb32;">Limited-time offer</span><span style="color: #ffffff;">.<br>Catastrophe can strike at any moment.</span></span></div>
</td></tr></table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" em="atom"><tr><td style="padding: 10px 0;" align="center">
  <table cellpadding="0" cellspacing="0" border="0" width="80%" class="em-mob-width-100perc" style="width: 80%;">
    <tr>
      <td align="center" valign="middle" height="50" style="background-color: #ffeb32; border-radius: 15px; height: 50px;" bgcolor="#FFEB32">
        <a href="" target="_blank" style="display: block; height: 50px; font-family: Helvetica, Arial, sans-serif; color: #1e4a89; font-size: 18px; line-height: 50px; text-decoration: none; white-space: nowrap;" class="em-font-Mulish-Medium">
          <span style="font-weight: bold;">Finalize Your Survival Plan</span>
        </a>
      </td>
    </tr></table>
</td></tr></table>
</td>
                                            </tr></table>
                                    </td>
</tr><tr em="block" class="em-structure">
  <td align="center" style="padding: 31px 40px 30px; background-color: #ffffff; border-top-left-radius: 25px; border-top-right-radius: 25px; border-bottom-left-radius: 0px;" class="em-mob-padding_left-20 em-mob-padding_right-20" bgcolor="#FFFFFF">
    <table border="0" cellspacing="0" cellpadding="0" class="em-mob-width-100perc">
      <tr>
        <td width="560" valign="top" class="em-mob-wrap em-mob-width-100perc">
<table cellpadding="0" cellspacing="0" border="0" width="100%" em="atom"><tr><td height="20" style="height: 20px; padding-top: 20px; padding-bottom: 20px;" align="center">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr><td width="40" align="center">
        <a href="" target="_blank"><img src="https://cdn.useblocks.io/33359/250213_2102_THRY8l8.png" width="30" border="0" alt="" style="display: block;"></a>
      </td><td width="40" align="center">
        <a href="" target="_blank"><img src="https://cdn.useblocks.io/33359/250213_2102_7g94HcO.png" width="30" border="0" alt="" style="display: block;"></a>
      </td><td width="40" align="center">
        <a href="" target="_blank"><img src="https://cdn.useblocks.io/33359/250213_2102_Em19DB3.png" width="30" border="0" alt="" style="display: block;"></a>
      </td></tr></table>
</td></tr></table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" em="atom"><tr><td style="padding-bottom: 10px;">
  <div style="font-family: Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px; color: #1e4a89;" class="em-font-Mulish-Regular" align="center"><span style="font-weight: bold;">Vault-Tec – because we care about you… more than you do!</span></div>
</td></tr></table><table cellpadding="0" cellspacing="0" border="0" width="100%" em="atom"><tr><td style="padding-bottom: 10px;">
  <div style="font-family: Helvetica, Arial, sans-serif; font-size: 15px; line-height: 18px; color: #90872a;" class="em-font-Mulish-Regular" align="center"><span style="color: #ffeb32;"><a href=" " style="color: #90872a;">Unsubscribe</a></span></div>
</td></tr></table>
</td>
      </tr>
    </table>
  </td>
</tr></table>
				<!--[if (gte mso 9)|(IE)]>
				</td></tr></table>
				<![endif]-->
			</td>
		</tr>
	</table>
</body>
</html>';
 
$mailManager = \Drupal::service('plugin.manager.mail');
$module = 'test_mail';
$key = 'test_mail_key';
$to = $email;
$langcode = \Drupal::currentUser()->getPreferredLangcode();
$send = TRUE;

$result = $mailManager->mail($module, $key, $to, $langcode, $params, NULL, $send);

if ($result['result'] !== TRUE) {
  \Drupal::messenger()->addError($this->t('There was a problem sending your email.'));
} else {
  \Drupal::messenger()->addMessage($this->t('Your email has been sent.'));
}
}
}
