<?php

declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240626122412 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE JUN_Models (id INT AUTO_INCREMENT NOT NULL, application_id INT DEFAULT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, deleted_by_id INT DEFAULT NULL, number VARCHAR(8) NOT NULL, name VARCHAR(64) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_E9E5263B3E030ACD (application_id), INDEX IDX_E9E5263BB03A8386 (created_by_id), INDEX IDX_E9E5263B896DBBDE (updated_by_id), INDEX IDX_E9E5263BC76F1F52 (deleted_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE JUN_Operations (id INT AUTO_INCREMENT NOT NULL, model_id INT NOT NULL, application_id INT DEFAULT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, deleted_by_id INT DEFAULT NULL, operation_id INT DEFAULT 0 NOT NULL, operation_name VARCHAR(255) NOT NULL, minutes DOUBLE PRECISION NOT NULL, price DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_E047A52D7975B7E7 (model_id), INDEX IDX_E047A52D3E030ACD (application_id), INDEX IDX_E047A52DB03A8386 (created_by_id), INDEX IDX_E047A52D896DBBDE (updated_by_id), INDEX IDX_E047A52DC76F1F52 (deleted_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE JUN_Operators (id INT AUTO_INCREMENT NOT NULL, group_id INT DEFAULT NULL, application_id INT DEFAULT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, deleted_by_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_5C13F28FE54D947 (group_id), INDEX IDX_5C13F283E030ACD (application_id), INDEX IDX_5C13F28B03A8386 (created_by_id), INDEX IDX_5C13F28896DBBDE (updated_by_id), INDEX IDX_5C13F28C76F1F52 (deleted_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE JUN_OperatorsGroups (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, application_id INT DEFAULT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, deleted_by_id INT DEFAULT NULL, taxon_id INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_F775DFC2727ACA70 (parent_id), INDEX IDX_F775DFC23E030ACD (application_id), INDEX IDX_F775DFC2B03A8386 (created_by_id), INDEX IDX_F775DFC2896DBBDE (updated_by_id), INDEX IDX_F775DFC2C76F1F52 (deleted_by_id), UNIQUE INDEX UNIQ_F775DFC2DE13F470 (taxon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE JUN_OperatorsWork (id INT AUTO_INCREMENT NOT NULL, operator_id INT NOT NULL, operation_id INT NOT NULL, application_id INT DEFAULT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, deleted_by_id INT DEFAULT NULL, date DATE NOT NULL, count INT NOT NULL, price NUMERIC(10, 4) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_1B46F042584598A3 (operator_id), INDEX IDX_1B46F04244AC3583 (operation_id), INDEX IDX_1B46F0423E030ACD (application_id), INDEX IDX_1B46F042B03A8386 (created_by_id), INDEX IDX_1B46F042896DBBDE (updated_by_id), INDEX IDX_1B46F042C76F1F52 (deleted_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE JUN_Settings (var_name VARCHAR(64) NOT NULL, application_id INT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, deleted_by_id INT DEFAULT NULL, var_value VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_FCE14CD63E030ACD (application_id), INDEX IDX_FCE14CD6B03A8386 (created_by_id), INDEX IDX_FCE14CD6896DBBDE (updated_by_id), INDEX IDX_FCE14CD6C76F1F52 (deleted_by_id), PRIMARY KEY(application_id, var_name)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE JUN_Models ADD CONSTRAINT FK_E9E5263B3E030ACD FOREIGN KEY (application_id) REFERENCES VSAPP_Applications (id)');
        $this->addSql('ALTER TABLE JUN_Models ADD CONSTRAINT FK_E9E5263BB03A8386 FOREIGN KEY (created_by_id) REFERENCES VSUM_Users (id)');
        $this->addSql('ALTER TABLE JUN_Models ADD CONSTRAINT FK_E9E5263B896DBBDE FOREIGN KEY (updated_by_id) REFERENCES VSUM_Users (id)');
        $this->addSql('ALTER TABLE JUN_Models ADD CONSTRAINT FK_E9E5263BC76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES VSUM_Users (id)');
        $this->addSql('ALTER TABLE JUN_Operations ADD CONSTRAINT FK_E047A52D7975B7E7 FOREIGN KEY (model_id) REFERENCES JUN_Models (id)');
        $this->addSql('ALTER TABLE JUN_Operations ADD CONSTRAINT FK_E047A52D3E030ACD FOREIGN KEY (application_id) REFERENCES VSAPP_Applications (id)');
        $this->addSql('ALTER TABLE JUN_Operations ADD CONSTRAINT FK_E047A52DB03A8386 FOREIGN KEY (created_by_id) REFERENCES VSUM_Users (id)');
        $this->addSql('ALTER TABLE JUN_Operations ADD CONSTRAINT FK_E047A52D896DBBDE FOREIGN KEY (updated_by_id) REFERENCES VSUM_Users (id)');
        $this->addSql('ALTER TABLE JUN_Operations ADD CONSTRAINT FK_E047A52DC76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES VSUM_Users (id)');
        $this->addSql('ALTER TABLE JUN_Operators ADD CONSTRAINT FK_5C13F28FE54D947 FOREIGN KEY (group_id) REFERENCES JUN_OperatorsGroups (id)');
        $this->addSql('ALTER TABLE JUN_Operators ADD CONSTRAINT FK_5C13F283E030ACD FOREIGN KEY (application_id) REFERENCES VSAPP_Applications (id)');
        $this->addSql('ALTER TABLE JUN_Operators ADD CONSTRAINT FK_5C13F28B03A8386 FOREIGN KEY (created_by_id) REFERENCES VSUM_Users (id)');
        $this->addSql('ALTER TABLE JUN_Operators ADD CONSTRAINT FK_5C13F28896DBBDE FOREIGN KEY (updated_by_id) REFERENCES VSUM_Users (id)');
        $this->addSql('ALTER TABLE JUN_Operators ADD CONSTRAINT FK_5C13F28C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES VSUM_Users (id)');
        $this->addSql('ALTER TABLE JUN_OperatorsGroups ADD CONSTRAINT FK_F775DFC2727ACA70 FOREIGN KEY (parent_id) REFERENCES JUN_OperatorsGroups (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE JUN_OperatorsGroups ADD CONSTRAINT FK_F775DFC23E030ACD FOREIGN KEY (application_id) REFERENCES VSAPP_Applications (id)');
        $this->addSql('ALTER TABLE JUN_OperatorsGroups ADD CONSTRAINT FK_F775DFC2B03A8386 FOREIGN KEY (created_by_id) REFERENCES VSUM_Users (id)');
        $this->addSql('ALTER TABLE JUN_OperatorsGroups ADD CONSTRAINT FK_F775DFC2896DBBDE FOREIGN KEY (updated_by_id) REFERENCES VSUM_Users (id)');
        $this->addSql('ALTER TABLE JUN_OperatorsGroups ADD CONSTRAINT FK_F775DFC2C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES VSUM_Users (id)');
        $this->addSql('ALTER TABLE JUN_OperatorsGroups ADD CONSTRAINT FK_F775DFC2DE13F470 FOREIGN KEY (taxon_id) REFERENCES VSAPP_Taxons (id)');
        $this->addSql('ALTER TABLE JUN_OperatorsWork ADD CONSTRAINT FK_1B46F042584598A3 FOREIGN KEY (operator_id) REFERENCES JUN_Operators (id)');
        $this->addSql('ALTER TABLE JUN_OperatorsWork ADD CONSTRAINT FK_1B46F04244AC3583 FOREIGN KEY (operation_id) REFERENCES JUN_Operations (id)');
        $this->addSql('ALTER TABLE JUN_OperatorsWork ADD CONSTRAINT FK_1B46F0423E030ACD FOREIGN KEY (application_id) REFERENCES VSAPP_Applications (id)');
        $this->addSql('ALTER TABLE JUN_OperatorsWork ADD CONSTRAINT FK_1B46F042B03A8386 FOREIGN KEY (created_by_id) REFERENCES VSUM_Users (id)');
        $this->addSql('ALTER TABLE JUN_OperatorsWork ADD CONSTRAINT FK_1B46F042896DBBDE FOREIGN KEY (updated_by_id) REFERENCES VSUM_Users (id)');
        $this->addSql('ALTER TABLE JUN_OperatorsWork ADD CONSTRAINT FK_1B46F042C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES VSUM_Users (id)');
        $this->addSql('ALTER TABLE JUN_Settings ADD CONSTRAINT FK_FCE14CD63E030ACD FOREIGN KEY (application_id) REFERENCES VSAPP_Applications (id)');
        $this->addSql('ALTER TABLE JUN_Settings ADD CONSTRAINT FK_FCE14CD6B03A8386 FOREIGN KEY (created_by_id) REFERENCES VSUM_Users (id)');
        $this->addSql('ALTER TABLE JUN_Settings ADD CONSTRAINT FK_FCE14CD6896DBBDE FOREIGN KEY (updated_by_id) REFERENCES VSUM_Users (id)');
        $this->addSql('ALTER TABLE JUN_Settings ADD CONSTRAINT FK_FCE14CD6C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES VSUM_Users (id)');
        $this->addSql('ALTER TABLE VSAPP_Settings DROP FOREIGN KEY FK_4A491FD507FAB6A');
        $this->addSql('DROP INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings');
        $this->addSql('ALTER TABLE VSAPP_Settings CHANGE maintenance_page_id maintenance_page_id  INT DEFAULT NULL');
        $this->addSql('ALTER TABLE VSAPP_Settings ADD CONSTRAINT FK_4A491FD507FAB6A FOREIGN KEY (maintenance_page_id ) REFERENCES VSCMS_Pages (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings (maintenance_page_id )');
        $this->addSql('ALTER TABLE VSUM_UsersInfo CHANGE title title ENUM(\'mr\', \'mrs\', \'miss\')');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE JUN_Models DROP FOREIGN KEY FK_E9E5263B3E030ACD');
        $this->addSql('ALTER TABLE JUN_Models DROP FOREIGN KEY FK_E9E5263BB03A8386');
        $this->addSql('ALTER TABLE JUN_Models DROP FOREIGN KEY FK_E9E5263B896DBBDE');
        $this->addSql('ALTER TABLE JUN_Models DROP FOREIGN KEY FK_E9E5263BC76F1F52');
        $this->addSql('ALTER TABLE JUN_Operations DROP FOREIGN KEY FK_E047A52D7975B7E7');
        $this->addSql('ALTER TABLE JUN_Operations DROP FOREIGN KEY FK_E047A52D3E030ACD');
        $this->addSql('ALTER TABLE JUN_Operations DROP FOREIGN KEY FK_E047A52DB03A8386');
        $this->addSql('ALTER TABLE JUN_Operations DROP FOREIGN KEY FK_E047A52D896DBBDE');
        $this->addSql('ALTER TABLE JUN_Operations DROP FOREIGN KEY FK_E047A52DC76F1F52');
        $this->addSql('ALTER TABLE JUN_Operators DROP FOREIGN KEY FK_5C13F28FE54D947');
        $this->addSql('ALTER TABLE JUN_Operators DROP FOREIGN KEY FK_5C13F283E030ACD');
        $this->addSql('ALTER TABLE JUN_Operators DROP FOREIGN KEY FK_5C13F28B03A8386');
        $this->addSql('ALTER TABLE JUN_Operators DROP FOREIGN KEY FK_5C13F28896DBBDE');
        $this->addSql('ALTER TABLE JUN_Operators DROP FOREIGN KEY FK_5C13F28C76F1F52');
        $this->addSql('ALTER TABLE JUN_OperatorsGroups DROP FOREIGN KEY FK_F775DFC2727ACA70');
        $this->addSql('ALTER TABLE JUN_OperatorsGroups DROP FOREIGN KEY FK_F775DFC23E030ACD');
        $this->addSql('ALTER TABLE JUN_OperatorsGroups DROP FOREIGN KEY FK_F775DFC2B03A8386');
        $this->addSql('ALTER TABLE JUN_OperatorsGroups DROP FOREIGN KEY FK_F775DFC2896DBBDE');
        $this->addSql('ALTER TABLE JUN_OperatorsGroups DROP FOREIGN KEY FK_F775DFC2C76F1F52');
        $this->addSql('ALTER TABLE JUN_OperatorsGroups DROP FOREIGN KEY FK_F775DFC2DE13F470');
        $this->addSql('ALTER TABLE JUN_OperatorsWork DROP FOREIGN KEY FK_1B46F042584598A3');
        $this->addSql('ALTER TABLE JUN_OperatorsWork DROP FOREIGN KEY FK_1B46F04244AC3583');
        $this->addSql('ALTER TABLE JUN_OperatorsWork DROP FOREIGN KEY FK_1B46F0423E030ACD');
        $this->addSql('ALTER TABLE JUN_OperatorsWork DROP FOREIGN KEY FK_1B46F042B03A8386');
        $this->addSql('ALTER TABLE JUN_OperatorsWork DROP FOREIGN KEY FK_1B46F042896DBBDE');
        $this->addSql('ALTER TABLE JUN_OperatorsWork DROP FOREIGN KEY FK_1B46F042C76F1F52');
        $this->addSql('ALTER TABLE JUN_Settings DROP FOREIGN KEY FK_FCE14CD63E030ACD');
        $this->addSql('ALTER TABLE JUN_Settings DROP FOREIGN KEY FK_FCE14CD6B03A8386');
        $this->addSql('ALTER TABLE JUN_Settings DROP FOREIGN KEY FK_FCE14CD6896DBBDE');
        $this->addSql('ALTER TABLE JUN_Settings DROP FOREIGN KEY FK_FCE14CD6C76F1F52');
        $this->addSql('DROP TABLE JUN_Models');
        $this->addSql('DROP TABLE JUN_Operations');
        $this->addSql('DROP TABLE JUN_Operators');
        $this->addSql('DROP TABLE JUN_OperatorsGroups');
        $this->addSql('DROP TABLE JUN_OperatorsWork');
        $this->addSql('DROP TABLE JUN_Settings');
        $this->addSql('ALTER TABLE VSAPP_Settings DROP FOREIGN KEY FK_4A491FD507FAB6A');
        $this->addSql('DROP INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings');
        $this->addSql('ALTER TABLE VSAPP_Settings CHANGE maintenance_page_id  maintenance_page_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE VSAPP_Settings ADD CONSTRAINT FK_4A491FD507FAB6A FOREIGN KEY (maintenance_page_id) REFERENCES VSCMS_Pages (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings (maintenance_page_id)');
        $this->addSql('ALTER TABLE VSUM_UsersInfo CHANGE title title VARCHAR(255) DEFAULT NULL');
    }
}
