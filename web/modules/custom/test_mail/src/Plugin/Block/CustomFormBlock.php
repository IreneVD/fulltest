<?php

namespace Drupal\test_mail\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Annotation\Translation;

/**
 * @Block(
 *   id = "test_mail_block",
 *   admin_label = @Translation("Test Mail Form Block"),
 *   category = @Translation("Test Mail Form Block")
 * )
 */
class TestMailBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      'form' => \Drupal::formBuilder()->getForm('\Drupal\test_mail\Form\TestMail'),
      '#cache' => [
        'max-age' => 0,
      ],
    ];
  }
}
