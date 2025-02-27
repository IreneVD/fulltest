<?php

namespace Drupal\custom_form\Form;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Mail\MailManagerInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * @file
 * Form Inscription Form
 */
class CustomForm extends FormBase {

  protected $mailManager;

  public function __construct(MailManagerInterface $mail_manager) {
    $this->mailManager = $mail_manager;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('plugin.manager.mail')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'custom_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['name'] = [
      '#title' => $this->t('Your name'),
      '#type' => 'textfield',
      '#attributes' => [
        'placeholder' => $this->t('Write your name'),
      ],
      '#required' => TRUE,
    ];

    $form['email'] = [
      '#title' => $this->t('Your email'),
      '#type' => 'email',
      '#attributes' => [
        'placeholder' => $this->t('Write your email'),
      ],
      '#required' => TRUE,
    ];

    $form['subject'] = [
      '#title' => $this->t('Subject'),
      '#type' => 'textfield',
      '#attributes' => [
        'placeholder' => $this->t('Write the subject'),
      ],
    ];

    $form['message'] = [
      '#title' => $this->t('Message'),
      '#type' => 'textarea',
      '#attributes' => [
        'placeholder' => $this->t('Write your message'),
      ],
    ];

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Send message'),
      '#button_type' => 'primary',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->messenger()->addStatus($this->t('Your info @name and @subject has been sent', [
      '@name' => $form_state->getValue('name'),
      '@subject' => $form_state->getValue('subject'),
    ]));

    $params = [
      'subject' => $form_state->getValue('subject'),
      'name' => $form_state->getValue('name'),
      'email' => $form_state->getValue('email'),
      'message' => $form_state->getValue('message'),
    ];

    $html_message = '
      <html>
        <body style="font-family: Arial, sans-serif; line-height: 1.6;">
          <table style="width: 100%; border-collapse: collapse;">
            <tr style="background-color: #f2f2f2; color: #ff0447; text-align: center; border-bottom: 1px solid #ddd;">
              <td colspan="2" style="padding: 10px;">
                <h2>' . $params['subject'] . '</h2>
              </td>
            </tr>
            <tr style="color:rgb(245, 237, 237);>
              <td style="padding: 10px; width: 100px;"><strong>Name:</strong></td>
              <td style="padding: 10px;">' . $params['name'] . '</td>
            </tr>
            <tr style="color:rgb(245, 237, 237);>
              <td style="padding: 10px; width: 100px;"><strong>Email:</strong></td>
              <td style="padding: 10px;">' . $params['email'] . '</td>
            </tr>
            <tr style="color:rgb(245, 237, 237);>
              <td style="padding: 10px; width: 100px;"><strong>Message:</strong></td>
              <td style="padding: 10px;">' . nl2br($params['message']) . '</td>
            </tr>
            <tr style="background-color: #f2f2f2; color: #ff0447; text-align: center; border-top: 1px solid #ddd;">
              <td colspan="2" style="padding: 10px; font-size: 0.9em;">
                This message was sent from the contact form on ' . \Drupal::config('system.site')->get('name') . '.
              </td>
            </tr>
          </table>
        </body>
      </html>';

    $langcode = \Drupal::currentUser()->getPreferredLangcode();

    $send = $this->mailManager->mail('custom_form', 'contact_message', $params['email'], $langcode, [
      'subject' => $params['subject'],
      'message' => $html_message,
    ]);

    if ($send['result']) {
      \Drupal::messenger()->addMessage($this->t('Message sent successfully.'));
    } else {
      \Drupal::messenger()->addMessage($this->t('There was a problem sending your message.'));
    }
  }
}
