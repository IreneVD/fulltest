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
class CustomBlockForm extends FormBase {

  protected $mailManager;

    /**
   * {@inheritdoc}
   */
  public function __construct(MailManagerInterface $mail_manager) {
    $this->mailManager = $mail_manager;
  }

    /**
   * {@inheritdoc}
   */
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
    $custom_message = 'Patatas con limón';

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
    $config = $this->config('custom_form.settings');

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
            <tr style="background-color: #f2f2f2; color: #ff0447; text-align: center; border-bottom: 1px solid;">
              <td colspan="2" style="padding: 10px;">
                <h2>' . $params['subject'] . '</h2>
              </td>
            </tr>
            <tr style="color:rgb(245, 237, 237);">
              <td style="padding: 10px; width: 100px;"><strong>Name:</strong></td>
              <td style="padding: 10px;">' . $params['name'] . '</td>
            </tr>
            <tr style="color:rgb(245, 237, 237);">
              <td style="padding: 10px; width: 100px;"><strong>Email:</strong></td>
              <td style="padding: 10px;">' . $params['email'] . '</td>
            </tr>
            <tr style="color:rgb(245, 237, 237);">
              <td style="padding: 10px; width: 100px;"><strong>Message:</strong></td>
              <td style="padding: 10px;">' . nl2br($params['message']) . '</td>
            </tr>
          </table>
          <table border="1">
            <tr>
              <th>Encabezado 1</th>
              <th>Encabezado 2</th>
            </tr>
            <tr>
              <td>Celda 1</td>
              <td>Celda 2</td>
            </tr>
            <tr>
              <td>Celda 3</td>
              <td>Celda 4</td>
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
      \Drupal::messenger()->addMessage($config->get('custom_config_message') ?? $this->t('Message sent successfully'));
    } else {
      \Drupal::messenger()->addError($this->t('There was a problem sending your message. Please try again.'));
    }
  }
}
