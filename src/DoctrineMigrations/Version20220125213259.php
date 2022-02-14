<?php

declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220125213259 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE JUN_OperatorsGroups ADD created_by_id INT DEFAULT NULL, ADD updated_by_id INT DEFAULT NULL, ADD deleted_by_id INT DEFAULT NULL, ADD created_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE JUN_OperatorsGroups ADD CONSTRAINT FK_F775DFC2B03A8386 FOREIGN KEY (created_by_id) REFERENCES VSUM_Users (id)');
        $this->addSql('ALTER TABLE JUN_OperatorsGroups ADD CONSTRAINT FK_F775DFC2896DBBDE FOREIGN KEY (updated_by_id) REFERENCES VSUM_Users (id)');
        $this->addSql('ALTER TABLE JUN_OperatorsGroups ADD CONSTRAINT FK_F775DFC2C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES VSUM_Users (id)');
        $this->addSql('CREATE INDEX IDX_F775DFC2B03A8386 ON JUN_OperatorsGroups (created_by_id)');
        $this->addSql('CREATE INDEX IDX_F775DFC2896DBBDE ON JUN_OperatorsGroups (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_F775DFC2C76F1F52 ON JUN_OperatorsGroups (deleted_by_id)');
        $this->addSql('ALTER TABLE JUN_OperatorsWork MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE JUN_OperatorsWork DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE JUN_OperatorsWork CHANGE application_id application_id INT DEFAULT NULL, CHANGE created_by_id created_by_id INT DEFAULT NULL, CHANGE created_at created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE JUN_OperatorsWork ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE VSAPP_Settings DROP FOREIGN KEY FK_4A491FD507FAB6A');
        $this->addSql('DROP INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings');
        $this->addSql('ALTER TABLE VSAPP_Settings CHANGE maintenance_page_id maintenance_page_id  INT DEFAULT NULL');
        $this->addSql('ALTER TABLE VSAPP_Settings ADD CONSTRAINT FK_4A491FD507FAB6A FOREIGN KEY (maintenance_page_id ) REFERENCES VSCMS_Pages (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings (maintenance_page_id )');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE JUN_OperatorsGroups DROP FOREIGN KEY FK_F775DFC2B03A8386');
        $this->addSql('ALTER TABLE JUN_OperatorsGroups DROP FOREIGN KEY FK_F775DFC2896DBBDE');
        $this->addSql('ALTER TABLE JUN_OperatorsGroups DROP FOREIGN KEY FK_F775DFC2C76F1F52');
        $this->addSql('DROP INDEX IDX_F775DFC2B03A8386 ON JUN_OperatorsGroups');
        $this->addSql('DROP INDEX IDX_F775DFC2896DBBDE ON JUN_OperatorsGroups');
        $this->addSql('DROP INDEX IDX_F775DFC2C76F1F52 ON JUN_OperatorsGroups');
        $this->addSql('ALTER TABLE JUN_OperatorsGroups DROP created_by_id, DROP updated_by_id, DROP deleted_by_id, DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE JUN_OperatorsWork MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE JUN_OperatorsWork DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE JUN_OperatorsWork CHANGE application_id application_id INT DEFAULT 2, CHANGE created_by_id created_by_id INT DEFAULT 1, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE JUN_OperatorsWork ADD PRIMARY KEY (id, operator_id, operation_id, date)');
        $this->addSql('ALTER TABLE VSAPP_Settings DROP FOREIGN KEY FK_4A491FD507FAB6A');
        $this->addSql('DROP INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings');
        $this->addSql('ALTER TABLE VSAPP_Settings CHANGE maintenance_page_id  maintenance_page_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE VSAPP_Settings ADD CONSTRAINT FK_4A491FD507FAB6A FOREIGN KEY (maintenance_page_id) REFERENCES VSCMS_Pages (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings (maintenance_page_id)');
    }
}
