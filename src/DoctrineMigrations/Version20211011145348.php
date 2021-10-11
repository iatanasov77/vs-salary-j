<?php

declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211011145348 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE JUN_Models ADD created_by_id INT DEFAULT NULL, ADD updated_by_id INT DEFAULT NULL, ADD deleted_by_id INT DEFAULT NULL, ADD deleted_at DATETIME DEFAULT NULL, DROP added_by, DROP updated_by, DROP removed');
        $this->addSql('ALTER TABLE JUN_Models ADD CONSTRAINT FK_E9E5263BB03A8386 FOREIGN KEY (created_by_id) REFERENCES VSUM_Users (id)');
        $this->addSql('ALTER TABLE JUN_Models ADD CONSTRAINT FK_E9E5263B896DBBDE FOREIGN KEY (updated_by_id) REFERENCES VSUM_Users (id)');
        $this->addSql('ALTER TABLE JUN_Models ADD CONSTRAINT FK_E9E5263BC76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES VSUM_Users (id)');
        $this->addSql('CREATE INDEX IDX_E9E5263BB03A8386 ON JUN_Models (created_by_id)');
        $this->addSql('CREATE INDEX IDX_E9E5263B896DBBDE ON JUN_Models (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_E9E5263BC76F1F52 ON JUN_Models (deleted_by_id)');
        $this->addSql('ALTER TABLE JUN_Operations ADD created_by_id INT DEFAULT NULL, ADD updated_by_id INT DEFAULT NULL, ADD deleted_by_id INT DEFAULT NULL, ADD created_at DATETIME NOT NULL, ADD deleted_at DATETIME DEFAULT NULL, DROP added_by, DROP updated_by, DROP removed');
        $this->addSql('ALTER TABLE JUN_Operations ADD CONSTRAINT FK_E047A52DB03A8386 FOREIGN KEY (created_by_id) REFERENCES VSUM_Users (id)');
        $this->addSql('ALTER TABLE JUN_Operations ADD CONSTRAINT FK_E047A52D896DBBDE FOREIGN KEY (updated_by_id) REFERENCES VSUM_Users (id)');
        $this->addSql('ALTER TABLE JUN_Operations ADD CONSTRAINT FK_E047A52DC76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES VSUM_Users (id)');
        $this->addSql('CREATE INDEX IDX_E047A52DB03A8386 ON JUN_Operations (created_by_id)');
        $this->addSql('CREATE INDEX IDX_E047A52D896DBBDE ON JUN_Operations (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_E047A52DC76F1F52 ON JUN_Operations (deleted_by_id)');
        $this->addSql('ALTER TABLE JUN_Operators ADD updated_by_id INT DEFAULT NULL, ADD deleted_by_id INT DEFAULT NULL, ADD created_at DATETIME NOT NULL, ADD deleted_at DATETIME DEFAULT NULL, DROP added_by, DROP removed, CHANGE updated_at updated_at DATETIME NOT NULL, CHANGE updated_by created_by_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE JUN_Operators ADD CONSTRAINT FK_5C13F28B03A8386 FOREIGN KEY (created_by_id) REFERENCES VSUM_Users (id)');
        $this->addSql('ALTER TABLE JUN_Operators ADD CONSTRAINT FK_5C13F28896DBBDE FOREIGN KEY (updated_by_id) REFERENCES VSUM_Users (id)');
        $this->addSql('ALTER TABLE JUN_Operators ADD CONSTRAINT FK_5C13F28C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES VSUM_Users (id)');
        $this->addSql('CREATE INDEX IDX_5C13F28B03A8386 ON JUN_Operators (created_by_id)');
        $this->addSql('CREATE INDEX IDX_5C13F28896DBBDE ON JUN_Operators (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_5C13F28C76F1F52 ON JUN_Operators (deleted_by_id)');
        $this->addSql('ALTER TABLE JUN_OperatorsGroups ADD taxon_id INT NOT NULL');
        $this->addSql('ALTER TABLE JUN_OperatorsGroups ADD CONSTRAINT FK_F775DFC2DE13F470 FOREIGN KEY (taxon_id) REFERENCES VSAPP_Taxons (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_F775DFC2DE13F470 ON JUN_OperatorsGroups (taxon_id)');
        $this->addSql('ALTER TABLE JUN_OperatorsWork ADD created_by_id INT DEFAULT NULL, ADD updated_by_id INT DEFAULT NULL, ADD deleted_by_id INT DEFAULT NULL, DROP added_by, DROP updated_by, CHANGE added_at created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE JUN_OperatorsWork ADD CONSTRAINT FK_1B46F042B03A8386 FOREIGN KEY (created_by_id) REFERENCES VSUM_Users (id)');
        $this->addSql('ALTER TABLE JUN_OperatorsWork ADD CONSTRAINT FK_1B46F042896DBBDE FOREIGN KEY (updated_by_id) REFERENCES VSUM_Users (id)');
        $this->addSql('ALTER TABLE JUN_OperatorsWork ADD CONSTRAINT FK_1B46F042C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES VSUM_Users (id)');
        $this->addSql('CREATE INDEX IDX_1B46F042B03A8386 ON JUN_OperatorsWork (created_by_id)');
        $this->addSql('CREATE INDEX IDX_1B46F042896DBBDE ON JUN_OperatorsWork (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_1B46F042C76F1F52 ON JUN_OperatorsWork (deleted_by_id)');
        $this->addSql('ALTER TABLE VSAPP_Settings DROP FOREIGN KEY FK_4A491FD507FAB6A');
        $this->addSql('DROP INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings');
        $this->addSql('ALTER TABLE VSAPP_Settings CHANGE maintenance_page_id maintenance_page_id  INT DEFAULT NULL');
        $this->addSql('ALTER TABLE VSAPP_Settings ADD CONSTRAINT FK_4A491FD507FAB6A FOREIGN KEY (maintenance_page_id ) REFERENCES VSCMS_Pages (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings (maintenance_page_id )');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE JUN_Models DROP FOREIGN KEY FK_E9E5263BB03A8386');
        $this->addSql('ALTER TABLE JUN_Models DROP FOREIGN KEY FK_E9E5263B896DBBDE');
        $this->addSql('ALTER TABLE JUN_Models DROP FOREIGN KEY FK_E9E5263BC76F1F52');
        $this->addSql('DROP INDEX IDX_E9E5263BB03A8386 ON JUN_Models');
        $this->addSql('DROP INDEX IDX_E9E5263B896DBBDE ON JUN_Models');
        $this->addSql('DROP INDEX IDX_E9E5263BC76F1F52 ON JUN_Models');
        $this->addSql('ALTER TABLE JUN_Models ADD added_by INT NOT NULL, ADD updated_by INT NOT NULL, ADD removed TINYINT(1) NOT NULL, DROP created_by_id, DROP updated_by_id, DROP deleted_by_id, DROP deleted_at');
        $this->addSql('ALTER TABLE JUN_Operations DROP FOREIGN KEY FK_E047A52DB03A8386');
        $this->addSql('ALTER TABLE JUN_Operations DROP FOREIGN KEY FK_E047A52D896DBBDE');
        $this->addSql('ALTER TABLE JUN_Operations DROP FOREIGN KEY FK_E047A52DC76F1F52');
        $this->addSql('DROP INDEX IDX_E047A52DB03A8386 ON JUN_Operations');
        $this->addSql('DROP INDEX IDX_E047A52D896DBBDE ON JUN_Operations');
        $this->addSql('DROP INDEX IDX_E047A52DC76F1F52 ON JUN_Operations');
        $this->addSql('ALTER TABLE JUN_Operations ADD added_by INT NOT NULL, ADD updated_by INT NOT NULL, ADD removed TINYINT(1) NOT NULL, DROP created_by_id, DROP updated_by_id, DROP deleted_by_id, DROP created_at, DROP deleted_at');
        $this->addSql('ALTER TABLE JUN_Operators DROP FOREIGN KEY FK_5C13F28B03A8386');
        $this->addSql('ALTER TABLE JUN_Operators DROP FOREIGN KEY FK_5C13F28896DBBDE');
        $this->addSql('ALTER TABLE JUN_Operators DROP FOREIGN KEY FK_5C13F28C76F1F52');
        $this->addSql('DROP INDEX IDX_5C13F28B03A8386 ON JUN_Operators');
        $this->addSql('DROP INDEX IDX_5C13F28896DBBDE ON JUN_Operators');
        $this->addSql('DROP INDEX IDX_5C13F28C76F1F52 ON JUN_Operators');
        $this->addSql('ALTER TABLE JUN_Operators ADD added_by INT NOT NULL, ADD updated_by INT DEFAULT NULL, ADD removed TINYINT(1) NOT NULL, DROP created_by_id, DROP updated_by_id, DROP deleted_by_id, DROP created_at, DROP deleted_at, CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE JUN_OperatorsGroups DROP FOREIGN KEY FK_F775DFC2DE13F470');
        $this->addSql('DROP INDEX IDX_F775DFC2DE13F470 ON JUN_OperatorsGroups');
        $this->addSql('ALTER TABLE JUN_OperatorsGroups DROP taxon_id');
        $this->addSql('ALTER TABLE JUN_OperatorsWork DROP FOREIGN KEY FK_1B46F042B03A8386');
        $this->addSql('ALTER TABLE JUN_OperatorsWork DROP FOREIGN KEY FK_1B46F042896DBBDE');
        $this->addSql('ALTER TABLE JUN_OperatorsWork DROP FOREIGN KEY FK_1B46F042C76F1F52');
        $this->addSql('DROP INDEX IDX_1B46F042B03A8386 ON JUN_OperatorsWork');
        $this->addSql('DROP INDEX IDX_1B46F042896DBBDE ON JUN_OperatorsWork');
        $this->addSql('DROP INDEX IDX_1B46F042C76F1F52 ON JUN_OperatorsWork');
        $this->addSql('ALTER TABLE JUN_OperatorsWork ADD added_by INT NOT NULL, ADD updated_by INT NOT NULL, DROP created_by_id, DROP updated_by_id, DROP deleted_by_id, CHANGE created_at added_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE VSAPP_Settings DROP FOREIGN KEY FK_4A491FD507FAB6A');
        $this->addSql('DROP INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings');
        $this->addSql('ALTER TABLE VSAPP_Settings CHANGE maintenance_page_id  maintenance_page_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE VSAPP_Settings ADD CONSTRAINT FK_4A491FD507FAB6A FOREIGN KEY (maintenance_page_id) REFERENCES VSCMS_Pages (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings (maintenance_page_id)');
    }
}
