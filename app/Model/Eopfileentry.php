<?php
App::uses('AppModel', 'Model');
/**
 * Eopfileentry Model
 *
 * @property Eopfile $Eopfile
 */
class Eopfileentry extends AppModel {
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
		'Eopfile' => array(
			'className' => 'Eopfile',
			'foreignKey' => 'eopfile_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
            
                'Activity' => array(
                        'className' => 'Activity',
                        'foreignKey' => 'invoice_line_notes',
                        'conditions' => '',
                        'fields' => '',
                        'order' =>''
                ),
            
                'Claim' => array(
                        'className' => 'Claim',
                        'foreignKey' => 'external_invoice_ref',
                        'conditions' => '',
                        'fields' => '',
                        'order' =>''
                ),
            
                'Providerdetail' => array(
                        'className' => 'Providerdetail',
                        'foreignKey' => 'payee_code',
                        'conditions' => '',
                        'fields' => '',
                        'order' =>''
                )
	);
}
