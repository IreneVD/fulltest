<?php

namespace Drupal\custom_form\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Annotation\Translation;

/**
 * @Block(
 *   id = "custom_form_block",
 *   admin_label = @Translation("Custom Form Block"),
 *   category = @Translation("Custom Form Block")
 * )
 */
class CustomFormBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      'form' => \Drupal::formBuilder()->getForm('\Drupal\custom_form\Form\CustomForm'),
      '#cache' => [
        'max-age' => 0,
      ],
    ];
  }
}
