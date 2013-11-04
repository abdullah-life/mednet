<?php
App::uses('AppModel', 'Model');
/**
 * Resubmission Model
 *
 * @property Claim $Claim
 */
class Resubmission extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'id';

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Claim' => array(
			'className' => 'Claim',
			'foreignKey' => 'claim_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
