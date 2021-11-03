<?php

declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211031172320 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create View "operators_work_totals"';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE VIEW JUN_OperatorsWorkTotals AS 
            SELECT 
                JUN_OperatorsWork.id AS id, 
                JUN_OperatorsWork.operator_id AS operators_id, 
                JUN_OperatorsWork.operation_id AS operations_id, 
                JUN_OperatorsWork.price AS price, 
                JUN_OperatorsWork.count AS count, 
                round(JUN_OperatorsWork.count * JUN_OperatorsWork.price,2) AS total, 
                JUN_OperatorsWork.date AS date, 

                JUN_Operators.group_id AS group_id, 
                JUN_Operators.name AS operator_name, 
                
                JUN_Operations.operation_id AS operation_id, 
                JUN_Operations.operation_name AS operation_name, 

                JUN_Models.id AS models_id, 
                JUN_Models.number AS model_number, 
                JUN_Models.name AS model_name 

            FROM JUN_OperatorsWork JOIN JUN_Operators JOIN JUN_Operations JOIN JUN_Models
            WHERE JUN_Operators.id = JUN_OperatorsWork.operator_id AND 
                JUN_Operations.id = JUN_OperatorsWork.operation_id AND 
                JUN_Models.id = JUN_Operations.model_id
        ');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP VIEW JUN_OperatorsWorkTotals');
    }
}
