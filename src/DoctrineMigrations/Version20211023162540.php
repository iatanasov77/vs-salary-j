<?php

declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211023162540 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE JUN_OperatorsGroups DROP FOREIGN KEY FK_F775DFC2DE13F470');
        $this->addSql('ALTER TABLE JUN_OperatorsGroups ADD application_id INT DEFAULT NULL, CHANGE taxon_id taxon_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE JUN_OperatorsGroups ADD CONSTRAINT FK_F775DFC23E030ACD FOREIGN KEY (application_id) REFERENCES VSAPP_Applications (id)');
        $this->addSql('CREATE INDEX IDX_F775DFC23E030ACD ON JUN_OperatorsGroups (application_id)');
        $this->addSql('ALTER TABLE VSAPP_Settings DROP FOREIGN KEY FK_4A491FD507FAB6A');
        $this->addSql('DROP INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings');
        $this->addSql('ALTER TABLE VSAPP_Settings CHANGE maintenance_page_id maintenance_page_id  INT DEFAULT NULL');
        $this->addSql('ALTER TABLE VSAPP_Settings ADD CONSTRAINT FK_4A491FD507FAB6A FOREIGN KEY (maintenance_page_id ) REFERENCES VSCMS_Pages (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings (maintenance_page_id )');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE JUN_OperatorsGroups DROP FOREIGN KEY FK_F775DFC23E030ACD');
        $this->addSql('DROP INDEX IDX_F775DFC23E030ACD ON JUN_OperatorsGroups');
        $this->addSql('ALTER TABLE JUN_OperatorsGroups DROP application_id, CHANGE taxon_id taxon_id INT NOT NULL');
        $this->addSql('ALTER TABLE JUN_OperatorsGroups ADD CONSTRAINT FK_F775DFC2DE13F470 FOREIGN KEY (taxon_id) REFERENCES VSAPP_Taxons (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE VSAPP_Settings DROP FOREIGN KEY FK_4A491FD507FAB6A');
        $this->addSql('DROP INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings');
        $this->addSql('ALTER TABLE VSAPP_Settings CHANGE maintenance_page_id  maintenance_page_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE VSAPP_Settings ADD CONSTRAINT FK_4A491FD507FAB6A FOREIGN KEY (maintenance_page_id) REFERENCES VSCMS_Pages (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings (maintenance_page_id)');
    }
}
