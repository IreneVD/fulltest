<?php

namespace Drupal\custom_form\Form;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class CustomConfigForm extends ConfigFormBase {
    
    public static function create(ContainerInterface $container) {
        return new static(
            $container->get('config.factory')
        );
    }

    public function __construct(ConfigFactoryInterface $config_factory) {
        $this->configFactory = $config_factory;
    }

    protected function getEditableConfigNames() {
        return ['custom_form.settings'];
    }

    public function getFormId() {
        return 'custom_form';
    }

    public function buildForm(array $form, FormStateInterface $form_state) {
        $config = $this->config('custom_form.settings');

        $form['custom_config_message'] = [
            '#title' => $this->t('Custom message'),
            '#type' => 'textfield',
            '#attributes' => [
                'placeholder' => $this->t('Write your custom message'),
            ],
            '#default_value' => $config->get('custom_config_message') ?? $this->t('Message sent successfully'),
            '#description' => $this->t('This is the message that will be shown when the form is sent successfully'),
        ];

        $form['actions']['submit'] = [
            '#type' => 'submit',
            '#value' => $this->t('Send message'),
            '#button_type' => 'primary',
        ];

        return parent::buildForm($form, $form_state);
    }

    public function submitForm(array &$form, FormStateInterface $form_state) {
        $this->config('custom_form.settings')
            ->set('custom_config_message', $form_state->getValue('custom_config_message'))
            ->save();
        parent::submitForm($form, $form_state);
    }
}
