<?php
App::uses('AppModel', 'Model');
/**
 * BenefitsTest Model
 *
 */
class BenefitsTest extends AppModel {
/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'benefits_test';
/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'LOCAL_DESCRIPTION_1';
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'CRITERION_NBR';
}
