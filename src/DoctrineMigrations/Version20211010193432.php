<?php

declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211010193432 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE JUN_OperatorsWork (id INT AUTO_INCREMENT NOT NULL, application_id INT DEFAULT NULL, operators_id INT NOT NULL, operations_id INT NOT NULL, date DATE NOT NULL, count INT NOT NULL, price DOUBLE PRECISION NOT NULL, added_by INT NOT NULL, updated_by INT NOT NULL, added_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_1B46F0423E030ACD (application_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE JUN_OperatorsWork ADD CONSTRAINT FK_1B46F0423E030ACD FOREIGN KEY (application_id) REFERENCES VSAPP_Applications (id)');
        $this->addSql('DROP TABLE JUN_OperatorWork');
        $this->addSql('ALTER TABLE JUN_Models ADD application_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE JUN_Models ADD CONSTRAINT FK_E9E5263B3E030ACD FOREIGN KEY (application_id) REFERENCES VSAPP_Applications (id)');
        $this->addSql('CREATE INDEX IDX_E9E5263B3E030ACD ON JUN_Models (application_id)');
        $this->addSql('ALTER TABLE JUN_Operations ADD application_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE JUN_Operations ADD CONSTRAINT FK_E047A52D3E030ACD FOREIGN KEY (application_id) REFERENCES VSAPP_Applications (id)');
        $this->addSql('CREATE INDEX IDX_E047A52D3E030ACD ON JUN_Operations (application_id)');
        $this->addSql('ALTER TABLE JUN_Operators ADD application_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE JUN_Operators ADD CONSTRAINT FK_5C13F283E030ACD FOREIGN KEY (application_id) REFERENCES VSAPP_Applications (id)');
        $this->addSql('CREATE INDEX IDX_5C13F283E030ACD ON JUN_Operators (application_id)');
        $this->addSql('ALTER TABLE VSAPP_Settings DROP FOREIGN KEY FK_4A491FD507FAB6A');
        $this->addSql('DROP INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings');
        $this->addSql('ALTER TABLE VSAPP_Settings CHANGE maintenance_page_id maintenance_page_id  INT DEFAULT NULL');
        $this->addSql('ALTER TABLE VSAPP_Settings ADD CONSTRAINT FK_4A491FD507FAB6A FOREIGN KEY (maintenance_page_id ) REFERENCES VSCMS_Pages (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings (maintenance_page_id )');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE JUN_OperatorWork (id INT AUTO_INCREMENT NOT NULL, operators_id INT NOT NULL, operations_id INT NOT NULL, date DATE NOT NULL, count INT NOT NULL, price DOUBLE PRECISION NOT NULL, added_by INT NOT NULL, updated_by INT NOT NULL, added_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE JUN_OperatorsWork');
        $this->addSql('ALTER TABLE JUN_Models DROP FOREIGN KEY FK_E9E5263B3E030ACD');
        $this->addSql('DROP INDEX IDX_E9E5263B3E030ACD ON JUN_Models');
        $this->addSql('ALTER TABLE JUN_Models DROP application_id');
        $this->addSql('ALTER TABLE JUN_Operations DROP FOREIGN KEY FK_E047A52D3E030ACD');
        $this->addSql('DROP INDEX IDX_E047A52D3E030ACD ON JUN_Operations');
        $this->addSql('ALTER TABLE JUN_Operations DROP application_id');
        $this->addSql('ALTER TABLE JUN_Operators DROP FOREIGN KEY FK_5C13F283E030ACD');
        $this->addSql('DROP INDEX IDX_5C13F283E030ACD ON JUN_Operators');
        $this->addSql('ALTER TABLE JUN_Operators DROP application_id');
        $this->addSql('ALTER TABLE VSAPP_Settings DROP FOREIGN KEY FK_4A491FD507FAB6A');
        $this->addSql('DROP INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings');
        $this->addSql('ALTER TABLE VSAPP_Settings CHANGE maintenance_page_id  maintenance_page_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE VSAPP_Settings ADD CONSTRAINT FK_4A491FD507FAB6A FOREIGN KEY (maintenance_page_id) REFERENCES VSCMS_Pages (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings (maintenance_page_id)');
    }
}
