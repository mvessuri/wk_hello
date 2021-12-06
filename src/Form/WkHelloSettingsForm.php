<?php

namespace Drupal\wk_hello\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * weKnow Hello settings.
 */
class WkHelloSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'wk_hello_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Form constructor.
    $form = parent::buildForm($form, $form_state);
    // Default settings.
    $config = $this->config('wk_hello.settings');

    // Source text field.
    if (isset($config->get('wk_hello.text')['value'])) {
      $default_value = $config->get('wk_hello.text')['value'];
    }

    $form['source_text'] = [
      '#type' => 'text_format',
      '#title' => $this->t('Hello Text:'),
      '#base_type' => 'textarea',
      '#default_value' => $default_value,
      '#description' => $this->t('The message you want to display in your hello page.'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('wk_hello.settings');
    $config->set('wk_hello.text', $form_state->getValue('source_text'));
    $config->save();
    return parent::submitForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'wk_hello.settings',
    ];
  }

}
