<?php

namespace Drupal\user_count_block\Controller;

use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\RemoveCommand;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserBlockController extends ControllerBase
{


  public function changeBlock(Request $request)
  {
    if (!$request->isXmlHttpRequest()) {
      throw new NotFoundHttpException();
    }

    $response = new AjaxResponse();
    $selector = '.block__content';
    $newContent  = '<div>New content goes here</div>';
    $command = new ReplaceCommand($selector,$newContent);
    $response->addCommand($command);
    return $response;
  }

}


