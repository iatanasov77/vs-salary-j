<?php

declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210928155130 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE VSCMS_MultiPageToc DROP FOREIGN KEY FK_69A01BB5B4CE9742');
        $this->addSql('ALTER TABLE VSCMS_TocPage DROP FOREIGN KEY FK_F8BA64CA727ACA70');
        $this->addSql('ALTER TABLE VSCMS_TocPage DROP FOREIGN KEY FK_F8BA64CAA977936C');
        $this->addSql('CREATE TABLE JUN_Models (id INT AUTO_INCREMENT NOT NULL, number VARCHAR(8) NOT NULL, name VARCHAR(64) NOT NULL, added_by INT NOT NULL, updated_by INT NOT NULL, removed TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE JUN_Operations (id INT AUTO_INCREMENT NOT NULL, model_id INT NOT NULL, operation_id VARCHAR(4) NOT NULL, operation_name VARCHAR(64) NOT NULL, minutes DOUBLE PRECISION NOT NULL, added_by INT NOT NULL, updated_by INT NOT NULL, updated_at DATETIME NOT NULL, removed TINYINT(1) NOT NULL, INDEX model_id (model_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE JUN_Operators (id INT AUTO_INCREMENT NOT NULL, groups_id INT NOT NULL, name VARCHAR(64) NOT NULL, added_by INT NOT NULL, updated_by INT DEFAULT NULL, updated_at DATETIME DEFAULT NULL, removed TINYINT(1) NOT NULL, INDEX groups_id (groups_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE JUN_OperatorsGroups (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(64) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE JUN_OperatorWork (id INT AUTO_INCREMENT NOT NULL, operators_id INT NOT NULL, operations_id INT NOT NULL, date DATE NOT NULL, count INT NOT NULL, price DOUBLE PRECISION NOT NULL, added_by INT NOT NULL, updated_by INT NOT NULL, added_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE JUN_Operations ADD CONSTRAINT FK_E047A52D7975B7E7 FOREIGN KEY (model_id) REFERENCES JUN_Models (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE VSCMS_MultiPageToc');
        $this->addSql('DROP TABLE VSCMS_TocPage');
        $this->addSql('ALTER TABLE VSAPP_Settings DROP FOREIGN KEY FK_4A491FD507FAB6A');
        $this->addSql('ALTER TABLE VSAPP_Settings DROP FOREIGN KEY FK_4A491FD762596F6');
        $this->addSql('DROP INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings');
        $this->addSql('DROP INDEX IDX_4A491FD762596F6 ON VSAPP_Settings');
        $this->addSql('ALTER TABLE VSAPP_Settings ADD site_id  INT DEFAULT NULL, ADD maintenance_page_id  INT DEFAULT NULL, DROP site_id, DROP maintenance_page_id');
        $this->addSql('ALTER TABLE VSAPP_Settings ADD CONSTRAINT FK_4A491FD507FAB6A FOREIGN KEY (maintenance_page_id ) REFERENCES VSCMS_Pages (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE VSAPP_Settings ADD CONSTRAINT FK_4A491FD762596F6 FOREIGN KEY (site_id ) REFERENCES VSAPP_Sites (id)');
        $this->addSql('CREATE INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings (maintenance_page_id )');
        $this->addSql('CREATE INDEX IDX_4A491FD762596F6 ON VSAPP_Settings (site_id )');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE JUN_Operations DROP FOREIGN KEY FK_E047A52D7975B7E7');
        $this->addSql('CREATE TABLE VSCMS_MultiPageToc (id INT AUTO_INCREMENT NOT NULL, toc_root_page_id INT NOT NULL, main_page_id INT NOT NULL, toc_title VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, INDEX IDX_69A01BB5B4CE9742 (toc_root_page_id), INDEX IDX_B262621CB4CE9742 (toc_root_page_id), INDEX IDX_B262621CF80DCA0D (main_page_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE VSCMS_TocPage (id INT AUTO_INCREMENT NOT NULL, page_id INT DEFAULT NULL, tree_root INT DEFAULT NULL, parent_id INT DEFAULT NULL, title VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, lft INT NOT NULL, rgt INT NOT NULL, lvl INT NOT NULL, INDEX IDX_6B1FF241727ACA70 (parent_id), INDEX IDX_6B1FF241A977936C (tree_root), INDEX IDX_6B1FF241C4663E4 (page_id), INDEX IDX_F8BA64CAA977936C (tree_root), INDEX IDX_F8BA64CAC4663E4 (page_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE VSCMS_MultiPageToc ADD CONSTRAINT FK_69A01BB5B4CE9742 FOREIGN KEY (toc_root_page_id) REFERENCES VSCMS_TocPage (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE VSCMS_MultiPageToc ADD CONSTRAINT FK_B262621CF80DCA0D FOREIGN KEY (main_page_id) REFERENCES VSCMS_Pages (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE VSCMS_TocPage ADD CONSTRAINT FK_F8BA64CA727ACA70 FOREIGN KEY (parent_id) REFERENCES VSCMS_TocPage (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE VSCMS_TocPage ADD CONSTRAINT FK_F8BA64CAA977936C FOREIGN KEY (tree_root) REFERENCES VSCMS_TocPage (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE VSCMS_TocPage ADD CONSTRAINT FK_F8BA64CAC4663E4 FOREIGN KEY (page_id) REFERENCES VSCMS_Pages (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('DROP TABLE JUN_Models');
        $this->addSql('DROP TABLE JUN_Operations');
        $this->addSql('DROP TABLE JUN_Operators');
        $this->addSql('DROP TABLE JUN_OperatorsGroups');
        $this->addSql('DROP TABLE JUN_OperatorsWork');
        $this->addSql('ALTER TABLE VSAPP_Settings DROP FOREIGN KEY FK_4A491FD762596F6');
        $this->addSql('ALTER TABLE VSAPP_Settings DROP FOREIGN KEY FK_4A491FD507FAB6A');
        $this->addSql('DROP INDEX IDX_4A491FD762596F6 ON VSAPP_Settings');
        $this->addSql('DROP INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings');
        $this->addSql('ALTER TABLE VSAPP_Settings ADD site_id INT DEFAULT NULL, ADD maintenance_page_id INT DEFAULT NULL, DROP site_id , DROP maintenance_page_id ');
        $this->addSql('ALTER TABLE VSAPP_Settings ADD CONSTRAINT FK_4A491FD762596F6 FOREIGN KEY (site_id) REFERENCES VSAPP_Sites (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE VSAPP_Settings ADD CONSTRAINT FK_4A491FD507FAB6A FOREIGN KEY (maintenance_page_id) REFERENCES VSCMS_Pages (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_4A491FD762596F6 ON VSAPP_Settings (site_id)');
        $this->addSql('CREATE INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings (maintenance_page_id)');
    }
}
