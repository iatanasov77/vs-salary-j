<?php

declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211030055728 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE JUN_OperatorsWork ADD operator_id INT NOT NULL, ADD operation_id INT NOT NULL, DROP operators_id, DROP operations_id');
        $this->addSql('ALTER TABLE JUN_OperatorsWork ADD CONSTRAINT FK_1B46F042584598A3 FOREIGN KEY (operator_id) REFERENCES JUN_Operators (id)');
        $this->addSql('ALTER TABLE JUN_OperatorsWork ADD CONSTRAINT FK_1B46F04244AC3583 FOREIGN KEY (operation_id) REFERENCES JUN_Operations (id)');
        $this->addSql('CREATE INDEX IDX_1B46F042584598A3 ON JUN_OperatorsWork (operator_id)');
        $this->addSql('CREATE INDEX IDX_1B46F04244AC3583 ON JUN_OperatorsWork (operation_id)');
        $this->addSql('ALTER TABLE VSAPP_Settings DROP FOREIGN KEY FK_4A491FD507FAB6A');
        $this->addSql('DROP INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings');
        $this->addSql('ALTER TABLE VSAPP_Settings CHANGE maintenance_page_id maintenance_page_id  INT DEFAULT NULL');
        $this->addSql('ALTER TABLE VSAPP_Settings ADD CONSTRAINT FK_4A491FD507FAB6A FOREIGN KEY (maintenance_page_id ) REFERENCES VSCMS_Pages (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings (maintenance_page_id )');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE JUN_OperatorsWork DROP FOREIGN KEY FK_1B46F042584598A3');
        $this->addSql('ALTER TABLE JUN_OperatorsWork DROP FOREIGN KEY FK_1B46F04244AC3583');
        $this->addSql('DROP INDEX IDX_1B46F042584598A3 ON JUN_OperatorsWork');
        $this->addSql('DROP INDEX IDX_1B46F04244AC3583 ON JUN_OperatorsWork');
        $this->addSql('ALTER TABLE JUN_OperatorsWork ADD operators_id INT NOT NULL, ADD operations_id INT NOT NULL, DROP operator_id, DROP operation_id');
        $this->addSql('ALTER TABLE VSAPP_Settings DROP FOREIGN KEY FK_4A491FD507FAB6A');
        $this->addSql('DROP INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings');
        $this->addSql('ALTER TABLE VSAPP_Settings CHANGE maintenance_page_id  maintenance_page_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE VSAPP_Settings ADD CONSTRAINT FK_4A491FD507FAB6A FOREIGN KEY (maintenance_page_id) REFERENCES VSCMS_Pages (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings (maintenance_page_id)');
    }
}
