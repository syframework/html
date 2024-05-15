<?php
/**
 * This script is included on every request right after the autoloader is registered.
 * Its purpose is to check if there is a form submission and execute the submit action
 * associated to the right form.
 */

use Sy\Http;

$formId = Http::request('sy-form-action-trigger');

if (empty($formId)) return;

if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

$forms = Http::session('syform');

if (!isset($forms[$formId])) return;

$form = unserialize($forms[$formId]);
$form->initialize();
$res = $form->submitAction();

if (empty($res)) return;

echo $res;
exit;