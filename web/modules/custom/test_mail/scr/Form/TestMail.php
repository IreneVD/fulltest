<?php

namespace Drupal\test_mail\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Mail\MailManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class TestMailForm extends FormBase {

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
    $params = [
      'subject' => 'Test Email',
      'message' => 'This is a test email.',
    ];
    $langcode = \Drupal::currentUser()->getPreferredLangcode();
    $send = $this->mailManager->mail('test_mail', 'test_message', $email, $langcode, $params);

    if ($send['result']) {
      \Drupal::messenger()->addMessage($this->t('Test email sent successfully.'));
    } else {
      \Drupal::messenger()->addMessage($this->t('There was a problem sending the test email.'));
    }
  }
}
