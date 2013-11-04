<?php
App::uses('AppModel', 'Model');
/**
 * Person Model
 *
 * @property Xmllisting $Xmllisting
 * @property Claim $Claim
 */
class Person extends AppModel {
/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'persons';
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'id';
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'xmllisting_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'claim_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Xmllisting' => array(
			'className' => 'Xmllisting',
			'foreignKey' => 'xmllisting_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Claim' => array(
			'className' => 'Claim',
			'foreignKey' => 'claim_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
