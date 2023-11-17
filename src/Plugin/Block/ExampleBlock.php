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
      'hello_block_name' => $this->t(''),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state)
  {
    $form['hello_block_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Who'),
      '#description' => $this->t('Who do you want to say hello to?'),
      '#default_value' => $this->configuration['hello_block_name'],
    ];

    return $form;
  }



}
