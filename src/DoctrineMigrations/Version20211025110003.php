<?php

declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211025110003 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE JUN_Settings (var_name VARCHAR(64) NOT NULL, application_id INT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, deleted_by_id INT DEFAULT NULL, var_value VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_FCE14CD63E030ACD (application_id), INDEX IDX_FCE14CD6B03A8386 (created_by_id), INDEX IDX_FCE14CD6896DBBDE (updated_by_id), INDEX IDX_FCE14CD6C76F1F52 (deleted_by_id), PRIMARY KEY(application_id, var_name)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE JUN_Settings ADD CONSTRAINT FK_FCE14CD63E030ACD FOREIGN KEY (application_id) REFERENCES VSAPP_Applications (id)');
        $this->addSql('ALTER TABLE JUN_Settings ADD CONSTRAINT FK_FCE14CD6B03A8386 FOREIGN KEY (created_by_id) REFERENCES VSUM_Users (id)');
        $this->addSql('ALTER TABLE JUN_Settings ADD CONSTRAINT FK_FCE14CD6896DBBDE FOREIGN KEY (updated_by_id) REFERENCES VSUM_Users (id)');
        $this->addSql('ALTER TABLE JUN_Settings ADD CONSTRAINT FK_FCE14CD6C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES VSUM_Users (id)');
        $this->addSql('ALTER TABLE VSAPP_Settings DROP FOREIGN KEY FK_4A491FD507FAB6A');
        $this->addSql('DROP INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings');
        $this->addSql('ALTER TABLE VSAPP_Settings CHANGE maintenance_page_id maintenance_page_id  INT DEFAULT NULL');
        $this->addSql('ALTER TABLE VSAPP_Settings ADD CONSTRAINT FK_4A491FD507FAB6A FOREIGN KEY (maintenance_page_id ) REFERENCES VSCMS_Pages (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings (maintenance_page_id )');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE JUN_Settings');
        $this->addSql('ALTER TABLE VSAPP_Settings DROP FOREIGN KEY FK_4A491FD507FAB6A');
        $this->addSql('DROP INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings');
        $this->addSql('ALTER TABLE VSAPP_Settings CHANGE maintenance_page_id  maintenance_page_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE VSAPP_Settings ADD CONSTRAINT FK_4A491FD507FAB6A FOREIGN KEY (maintenance_page_id) REFERENCES VSCMS_Pages (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings (maintenance_page_id)');
    }
}
