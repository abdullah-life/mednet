<?php
App::uses('AppModel', 'Model');
/**
 * Providerpricing Model
 *
 * @property Providerpricingfile $Providerpricingfile
 * @property Providerdetail $Providerdetail
 */
class Providerpricing extends AppModel {
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
		'providerpricingfile_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'providerdetail_id' => array(
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
		'Providerpricingfile' => array(
			'className' => 'Providerpricingfile',
			'foreignKey' => 'providerpricingfile_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Providerdetail' => array(
			'className' => 'Providerdetail',
			'foreignKey' => 'providerdetail_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
