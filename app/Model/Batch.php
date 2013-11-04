<?php
App::uses('AppModel', 'Model');
/**
 * Batch Model
 *
 * @property Provider $Provider
 * @property Claim $Claim
 * @property Claimsmanager $Claimsmanager
 * @property Claimsprocessor $Claimsprocessor
 */
class Batch extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';
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
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		 'Providerdetail' => array(
			'className' => 'Providerdetail',
			'foreignKey' => 'provider_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
	);
        
/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
        public $hasMany             =array(
            
            'ClaimsmanagerBatch' => array(
			'className' => 'ClaimsmanagerBatch',
			'joinTable' => 'claimsmanager_batches',
			'foreignKey' => 'batch_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		'ClaimsprocessorBatch' => array(
			'className' => 'ClaimsprocessorBatch',
			'joinTable' => 'claimsprocessor_batches',
			'foreignKey' => 'batch_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		'MedicalmanagerBatch' => array(
			'className' => 'MedicalmanagerBatch',
			'joinTable' => 'medicalmanager_batches',
			'foreignKey' => 'batch_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		'MedicalreceiverBatch' => array(
			'className' => 'MedicalreceiverBatch',
			'joinTable' => 'medicalreceiver_batches',
			'foreignKey' => 'batch_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
                'BatchComment' => array(
                        'className' => 'BatchComment',
			'joinTable' => 'batch_comments',
			'foreignKey' => 'batch_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
                )
            
        );
        
	public $hasAndBelongsToMany = array(
		'Claim' => array(
			'className' => 'Claim',
			'joinTable' => 'batches_Claims',
			'foreignKey' => 'batch_id',
			'associationForeignKey' => 'claim_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		
	);

}
