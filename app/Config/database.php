<?php
class DATABASE_CONFIG {

	public  $default= array(
                       'datasource' => 'Mongodb.MongodbSource',
                       'host' => 'localhost',
                       'database' => 'mednet',
                       'port' => 27017,
                       'prefix' => '',
                       'persistent' => 'true',
                       'login' => 'admin',        
                       'password' => 'admin',
//                        'replicaset' => array('host' => 'mongodb://hoge:hogehoge@localhost:27021,localhost:27022/blog',
//                                              'options' => array('replicaSet' => 'myRepl')
//                                             ),
                       
               );
	public  $test= array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host' => 'localhost',
		'login' => 'root',
		'password' => 'root',
		'database' => 'mednet',
	);
}

