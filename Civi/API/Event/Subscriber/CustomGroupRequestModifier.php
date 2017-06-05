<?php

namespace Civi\API\Event\Subscriber;

use Civi\API\V4\Action\Create;

class CustomGroupRequestModifier extends ApiRequestModifier {
  /**
   * @param Create $request
   */
  protected function modify(Create $request) {
    $isTargetEntity = $request->getEntity() === 'CustomGroup';
    $extends = $request->getValue('extends');
    $isString = is_string($request->getValue('extends'));

    if ($isTargetEntity && $isString) {
      $request->setValue('extends', array($extends));
    }
  }
}
