<?php

/**
 * Test: Nette\Forms and toggle.
 */

declare(strict_types=1);

use Nette\Forms\Form;
use Tester\Assert;


require __DIR__ . '/../bootstrap.php';


test(function () { // AND
	$form = new Form;
	$form->addText('1');
	$form->addText('2');
	$form->addText('3')
		->addConditionOn($form['1'], Form::EQUAL, 'x')
			->toggle('a')
			->addConditionOn($form['2'], Form::EQUAL, 'x')
				->toggle('b');

	Assert::same([
		'a' => false,
		'b' => false,
	], $form->getToggles());
});


test(function () {
	$form = new Form;
	$form->addText('1');
	$form->addText('2');
	$form->addText('3')
		->addConditionOn($form['1'], Form::EQUAL, 'x')
			->toggle('a')
			->addConditionOn($form['2'], Form::NOT_EQUAL, 'x')
				->toggle('b');

	Assert::same([
		'a' => false,
		'b' => false,
	], $form->getToggles());
});


test(function () {
	$form = new Form;
	$form->addText('1');
	$form->addText('2');
	$form->addText('3')
		->addConditionOn($form['1'], Form::NOT_EQUAL, 'x')
			->toggle('a')
			->addConditionOn($form['2'], Form::EQUAL, 'x')
				->toggle('b');

	Assert::same([
		'a' => true,
		'b' => false,
	], $form->getToggles());
});


test(function () {
	$form = new Form;
	$form->addText('1');
	$form->addText('2');
	$form->addText('3')
		->addConditionOn($form['1'], Form::NOT_EQUAL, 'x')
			->toggle('a')
			->addConditionOn($form['2'], Form::NOT_EQUAL, 'x')
				->toggle('b');

	Assert::same([
		'a' => true,
		'b' => true,
	], $form->getToggles());
});


test(function () { // OR
	$form = new Form;
	$form->addText('1');
	$form->addText('2');
	$form->addText('3')
		->addConditionOn($form['1'], Form::EQUAL, 'x')
			->toggle('a')
		->endCondition()
		->addConditionOn($form['2'], Form::EQUAL, 'x')
			->toggle('b');

	Assert::same([
		'a' => false,
		'b' => false,
	], $form->getToggles());
});


test(function () {
	$form = new Form;
	$form->addText('1');
	$form->addText('2');
	$form->addText('3')
		->addConditionOn($form['1'], Form::EQUAL, 'x')
			->toggle('a')
		->endCondition()
		->addConditionOn($form['2'], Form::NOT_EQUAL, 'x')
			->toggle('b');

	Assert::same([
		'a' => false,
		'b' => true,
	], $form->getToggles());
});


test(function () {
	$form = new Form;
	$form->addText('1');
	$form->addText('2');
	$form->addText('3')
		->addConditionOn($form['1'], Form::NOT_EQUAL, 'x')
			->toggle('a')
		->endCondition()
		->addConditionOn($form['2'], Form::EQUAL, 'x')
			->toggle('b');

	Assert::same([
		'a' => true,
		'b' => false,
	], $form->getToggles());
});


test(function () {
	$form = new Form;
	$form->addText('1');
	$form->addText('2');
	$form->addText('3')
		->addConditionOn($form['1'], Form::NOT_EQUAL, 'x')
			->toggle('a')
		->endCondition()
		->addConditionOn($form['2'], Form::NOT_EQUAL, 'x')
			->toggle('b');

	Assert::same([
		'a' => true,
		'b' => true,
	], $form->getToggles());
});


test(function () { // OR & two components
	$form = new Form;
	$form->addText('1')
		->addCondition(Form::EQUAL, 'x')
			->toggle('a');
	$form->addText('2')
		->addCondition(Form::EQUAL, 'x')
			->toggle('b');

	Assert::same([
		'a' => false,
		'b' => false,
	], $form->getToggles());
});


test(function () {
	$form = new Form;
	$form->addText('1')
		->addCondition(Form::EQUAL, 'x')
			->toggle('a');
	$form->addText('2')
		->addCondition(Form::NOT_EQUAL, 'x')
			->toggle('b');

	Assert::same([
		'a' => false,
		'b' => true,
	], $form->getToggles());
});


test(function () {
	$form = new Form;
	$form->addText('1')
		->addCondition(Form::NOT_EQUAL, 'x')
			->toggle('a');
	$form->addText('2')
		->addCondition(Form::EQUAL, 'x')
			->toggle('b');

	Assert::same([
		'a' => true,
		'b' => false,
	], $form->getToggles());
});


test(function () {
	$form = new Form;
	$form->addText('1')
		->addCondition(Form::NOT_EQUAL, 'x')
			->toggle('a');
	$form->addText('2')
		->addCondition(Form::NOT_EQUAL, 'x')
			->toggle('b');

	Assert::same([
		'a' => true,
		'b' => true,
	], $form->getToggles());
});


test(function () { // OR & multiple used ID
	$form = new Form;
	$form->addText('1')
		->addCondition(Form::EQUAL, 'x')
			->toggle('a');
	$form->addText('2')
		->addCondition(Form::EQUAL, 'x')
			->toggle('a');

	Assert::same([
		'a' => false,
	], $form->getToggles());
});


test(function () {
	$form = new Form;
	$form->addText('1')
		->addCondition(Form::EQUAL, 'x')
			->toggle('a');
	$form->addText('2')
		->addCondition(Form::NOT_EQUAL, 'x')
			->toggle('a');

	Assert::same([
		'a' => true,
	], $form->getToggles());
});


test(function () {
	$form = new Form;
	$form->addText('1')
		->addCondition(Form::NOT_EQUAL, 'x')
			->toggle('a');
	$form->addText('2')
		->addCondition(Form::EQUAL, 'x')
			->toggle('a');

	Assert::same([
		'a' => true,
	], $form->getToggles());
});


test(function () {
	$form = new Form;
	$form->addText('1')
		->addCondition(Form::NOT_EQUAL, 'x')
			->toggle('a');
	$form->addText('2')
		->addCondition(Form::NOT_EQUAL, 'x')
			->toggle('a');

	Assert::same([
		'a' => true,
	], $form->getToggles());
});


test(function () { // AND & multiple used ID
	$form = new Form;
	$form->addText('1');
	$form->addText('2');
	$form->addText('3')
		->addConditionOn($form['1'], Form::EQUAL, 'x')
			->toggle('a')
			->addConditionOn($form['2'], Form::EQUAL, 'x')
				->toggle('a');

	Assert::same([
		'a' => false,
	], $form->getToggles());
});


test(function () {
	$form = new Form;
	$form->addText('1');
	$form->addText('2');
	$form->addText('3')
		->addConditionOn($form['1'], Form::EQUAL, 'x')
			->toggle('a')
			->addConditionOn($form['2'], Form::NOT_EQUAL, 'x')
				->toggle('a');

	Assert::same([
		'a' => false,
	], $form->getToggles());
});


test(function () {
	$form = new Form;
	$form->addText('1');
	$form->addText('2');
	$form->addText('3')
		->addConditionOn($form['1'], Form::NOT_EQUAL, 'x')
			->toggle('a')
			->addConditionOn($form['2'], Form::EQUAL, 'x')
				->toggle('a');

	Assert::same([
		'a' => true,
	], $form->getToggles());
});


test(function () {
	$form = new Form;
	$form->addText('1');
	$form->addText('2');
	$form->addText('3')
		->addConditionOn($form['1'], Form::NOT_EQUAL, 'x')
			->toggle('a')
			->addConditionOn($form['2'], Form::NOT_EQUAL, 'x')
				->toggle('a');

	Assert::same([
		'a' => true,
	], $form->getToggles());
});


test(function () { // $hide = false
	$form = new Form;
	$form->addText('1');
	$form->addText('2');
	$form->addText('3')
		->addConditionOn($form['1'], Form::EQUAL, 'x')
			->toggle('a', false)
			->addConditionOn($form['2'], Form::NOT_EQUAL, 'x')
				->toggle('b');

	Assert::same([
		'a' => true,
		'b' => false,
	], $form->getToggles());
});


test(function () {
	$form = new Form;
	$form->addText('1');
	$form->addText('2');
	$form->addText('3')
		->addConditionOn($form['1'], Form::EQUAL, 'x')
			->toggle('a', false)
			->addConditionOn($form['2'], Form::NOT_EQUAL, 'x')
				->toggle('b', false);

	Assert::same([
		'a' => true,
		'b' => true,
	], $form->getToggles());
});


test(function () {
	$form = new Form;
	$form->addText('1');
	$form->addText('2');
	$form->addText('3')
		->addConditionOn($form['1'], Form::NOT_EQUAL, 'x')
			->toggle('a', false)
			->addConditionOn($form['2'], Form::EQUAL, 'x')
				->toggle('b', false);

	Assert::same([
		'a' => false,
		'b' => true,
	], $form->getToggles());
});


test(function () {
	$form = new Form;
	$form->addText('1')
		->addCondition(Form::EQUAL, 'x')
			->toggle('a', false);
	$form->addText('2')
		->addCondition(Form::NOT_EQUAL, 'x')
			->toggle('b');

	Assert::same([
		'a' => true,
		'b' => true,
	], $form->getToggles());
});


test(function () {
	$form = new Form;
	$form->addText('1')
		->addCondition(Form::EQUAL, 'x')
			->toggle('a');
	$form->addText('2')
		->addCondition(Form::NOT_EQUAL, 'x')
			->toggle('b', false);

	Assert::same([
		'a' => false,
		'b' => false,
	], $form->getToggles());
});


test(function () {
	$form = new Form;
	$form->addText('1')
		->addCondition(Form::EQUAL, 'x')
			->toggle('a', false);
	$form->addText('2')
		->addCondition(Form::EQUAL, 'x')
			->toggle('b', false);

	Assert::same([
		'a' => true,
		'b' => true,
	], $form->getToggles());
});


test(function () { // $hide = false & multiple used ID
	$form = new Form;
	$form->addText('1');
	$form->addText('2');
	$form->addText('3')
		->addConditionOn($form['1'], Form::EQUAL, 'x')
			->toggle('a', false)
			->addConditionOn($form['2'], Form::NOT_EQUAL, 'x')
				->toggle('a');

	Assert::same([
		'a' => true,
	], $form->getToggles());
});


test(function () {
	$form = new Form;
	$form->addText('1');
	$form->addText('2');
	$form->addText('3')
		->addConditionOn($form['1'], Form::EQUAL, 'x')
			->toggle('a', false)
			->addConditionOn($form['2'], Form::NOT_EQUAL, 'x')
				->toggle('a', false);

	Assert::same([
		'a' => true,
	], $form->getToggles());
});


test(function () {
	$form = new Form;
	$form->addText('1');
	$form->addText('2');
	$form->addText('3')
		->addConditionOn($form['1'], Form::NOT_EQUAL, 'x')
			->toggle('a', false)
			->addConditionOn($form['2'], Form::EQUAL, 'x')
				->toggle('a', false);

	Assert::same([
		'a' => true,
	], $form->getToggles());
});


test(function () {
	$form = new Form;
	$form->addText('1')
		->addCondition(Form::EQUAL, 'x')
			->toggle('a', false);
	$form->addText('2')
		->addCondition(Form::NOT_EQUAL, 'x')
			->toggle('b');

	Assert::same([
		'a' => true,
		'b' => true,
	], $form->getToggles());
});


test(function () {
	$form = new Form;
	$form->addText('1')
		->addCondition(Form::EQUAL, 'x')
			->toggle('a');
	$form->addText('2')
		->addCondition(Form::NOT_EQUAL, 'x')
			->toggle('b', false);

	Assert::same([
		'a' => false,
		'b' => false,
	], $form->getToggles());
});


test(function () {
	$form = new Form;
	$form->addText('1')
		->addCondition(Form::EQUAL, 'x')
			->toggle('a', false);
	$form->addText('2')
		->addCondition(Form::EQUAL, 'x')
			->toggle('a', false);

	Assert::same([
		'a' => true,
	], $form->getToggles());
});


test(function () {
	$form = new Form;
	$form->addText('1')
		->addCondition(Form::EQUAL, 'x')
			->toggle('a', false);
	$form->addText('2')
		->addCondition(Form::NOT_EQUAL, 'x')
			->toggle('a', false);

	Assert::same([
		'a' => true,
	], $form->getToggles());
});


test(function () { // combined with rules
	$form = new Form;
	$form->addText('1');
	$form->addText('2');
	$form->addText('3')
		->setRequired()
		->addConditionOn($form['1'], Form::NOT_EQUAL, 'x')
			->toggle('a')
			->addConditionOn($form['2'], Form::NOT_EQUAL, 'x')
				->toggle('b')
			->endCondition()
		->endCondition();

	Assert::same([
		'a' => false,
		'b' => false,
	], $form->getToggles());
});


test(function () {
	$form = new Form;
	$form->addText('1');
	$form->addText('2');
	$form->addText('3')
		->setRequired()
		->addRule(Form::NOT_EQUAL, null, 'x')
		->addConditionOn($form['1'], Form::EQUAL, 'x')
			->toggle('a')
			->addConditionOn($form['2'], Form::EQUAL, 'x')
				->toggle('b');

	Assert::same([
		'a' => false,
		'b' => false,
	], $form->getToggles());
});


test(function () {
	$form = new Form;
	$form->addText('1');
	$form->addText('2');
	$form->addText('3')
		->setRequired()
		->addRule(Form::EQUAL, null, 'x')
		->addConditionOn($form['1'], Form::NOT_EQUAL, 'x')
			->toggle('a')
			->addConditionOn($form['2'], Form::NOT_EQUAL, 'x')
				->toggle('b');

	Assert::same([
		'a' => false,
		'b' => false,
	], $form->getToggles());
});


test(function () {
	$form = new Form;
	$form->addText('1');
	$form->addText('2');
	$form->addText('3')
		->addConditionOn($form['1'], Form::NOT_EQUAL, 'x')
			->setRequired()
			->addRule(Form::EQUAL, null, 'x')
			->toggle('a')
			->addConditionOn($form['2'], Form::NOT_EQUAL, 'x')
				->toggle('b');

	Assert::same([
		'a' => true,
		'b' => false,
	], $form->getToggles());
});


test(function () {
	$form = new Form;
	$form->addText('1');
	$form->addText('2');
	$form->addText('3')
		->addRule(Form::EQUAL, null, 'x')
		->addConditionOn($form['1'], Form::NOT_EQUAL, 'x')
			->toggle('a')
			->addConditionOn($form['2'], Form::NOT_EQUAL, 'x')
				->toggle('b');

	Assert::same([
		'a' => true,
		'b' => true,
	], $form->getToggles());
});


test(function () {
	$form = new Form;
	$form->addText('1');
	$form->addText('2');
	$form->addText('3')
		->addConditionOn($form['1'], Form::NOT_EQUAL, 'x')
			->addRule(Form::EQUAL, null, 'x')
			->toggle('a')
			->addConditionOn($form['2'], Form::NOT_EQUAL, 'x')
				->toggle('b');

	Assert::same([
		'a' => true,
		'b' => true,
	], $form->getToggles());
});


test(function () {
	$form = new Form;
	$form->addText('1');
	$form->addText('2');
	$form->addText('3')
		->addConditionOn($form['1'], Form::NOT_EQUAL, 'x')
			->addRule(Form::EQUAL, null, 'x')
			->toggle('a')
			->addConditionOn($form['2'], Form::NOT_EQUAL, 'x')
				->toggle('b');

	Assert::same([
		'a' => true,
		'b' => true,
	], $form->getToggles());
});
