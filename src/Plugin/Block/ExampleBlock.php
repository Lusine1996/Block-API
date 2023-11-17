<?php

namespace Drupal\user_count_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides an example block.
 *
 * @Block(
 * id = "user_count_block",
 * admin_label = @Translation("Example"),
 * category = @Translation("User count block")
 * )
 */
class ExampleBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */

  public function build()
  {
    $userStorage = \Drupal::entityTypeManager()->getStorage('user');
    $query = $userStorage->getQuery();
    $uids = $query->accessCheck(FALSE)->execute();


    $build['content'] = [
      '#markup' => $this->t('User count is @count!', ['@count' => count($uids)
      ]),];
    return $build;

  }

  /**
   * {@inheritdoc}
   */
  public function getCacheTags() {
    // Add the user entity cache tag to automatically update the block.
    $cache_tags = parent::getCacheTags();
    $cache_tags[] = 'user_list';

    return $cache_tags;
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration()
  {
    return [
      'block_custom_setting' => $this->t(''),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state)
  {
    $form['block_custom_setting'] = [
      '#type' => 'textfield',
      '#description' => $this->t('Enter a custom setting for the block.'),
      '#default_value' => $this->configuration['block_custom_setting'],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    $this->configuration['block_custom_setting'] = $values['block_custom_setting'];
  }

  /**
   * {@inheritdoc}
   */
  public function blockValidate( $form, FormStateInterface $form_state) {
    $value = $form_state->getValue('block_custom_setting');

    // Perform your custom validation logic here.
    if (strlen($value) < 10) {
      $form_state->setError($form, $this->t('Custom Setting must be at least 10 characters long.'));
    }
  }

}
