<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * @author Philipp Frenzel <philipp@frenzel.net>
 * generates the mandanten table(s)
 */
class m010101_100001_activity extends Migration
{
    public function up()
    {
        switch (Yii::$app->db->driverName) {
            case 'mysql':
              $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
              break;
            case 'pgsql':
              $tableOptions = null;
              break;
            case 'mssql':
              $tableOptions = null;
              break;
            default:
              throw new RuntimeException('Your database is not supported!');
        }

        $this->createTable('{{%net_frenzel_activity}}',array(
            'id'                    => Schema::TYPE_PK,
            
            //related to which record
            'entity'                => Schema::TYPE_STRING,
            'entity_id'             => Schema::TYPE_INTEGER . ' NOT NULL',
            
            //content and content type
            'text'                  => Schema::TYPE_TEXT,
            'type'                  => Schema::TYPE_INTEGER . ' DEFAULT 1',
            
            //action plan
            'next_type'             => Schema::TYPE_INTEGER . ' DEFAULT 1',
            'next_at'               => Schema::TYPE_INTEGER . ' DEFAULT NULL',
            'next_by'               => Schema::TYPE_INTEGER . ' DEFAULT NULL',
            
            // blamable
            'created_by'            => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_by'            => Schema::TYPE_INTEGER . ' NOT NULL',
            
            // timestamps
            'created_at'            => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at'            => Schema::TYPE_INTEGER . ' NOT NULL',
            'deleted_at'            => Schema::TYPE_INTEGER . ' DEFAULT NULL'
        ),$tableOptions);

        $this->createIndex('IX_net_frenzel_activity_entity', '{{%net_frenzel_activity}}', ['entity','entity_id']);
    }

    public function down()
    {
        $this->dropTable('{{%net_frenzel_activity}}');
    }
    
}