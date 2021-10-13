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
        $this->addSql('CREATE TABLE JUN_Models (id INT AUTO_INCREMENT NOT NULL, number VARCHAR(8) NOT NULL, name VARCHAR(64) NOT NULL, added_by INT NOT NULL, updated_by INT NOT NULL, removed TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE JUN_Operations (id INT AUTO_INCREMENT NOT NULL, model_id INT NOT NULL, operation_id VARCHAR(4) NOT NULL, operation_name VARCHAR(64) NOT NULL, minutes DOUBLE PRECISION NOT NULL, added_by INT NOT NULL, updated_by INT NOT NULL, updated_at DATETIME NOT NULL, removed TINYINT(1) NOT NULL, INDEX model_id (model_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE JUN_Operators (id INT AUTO_INCREMENT NOT NULL, groups_id INT NOT NULL, name VARCHAR(64) NOT NULL, added_by INT NOT NULL, updated_by INT DEFAULT NULL, updated_at DATETIME DEFAULT NULL, removed TINYINT(1) NOT NULL, INDEX groups_id (groups_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE JUN_OperatorsGroups (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(64) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE JUN_OperatorWork (id INT AUTO_INCREMENT NOT NULL, operators_id INT NOT NULL, operations_id INT NOT NULL, date DATE NOT NULL, count INT NOT NULL, price DOUBLE PRECISION NOT NULL, added_by INT NOT NULL, updated_by INT NOT NULL, added_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE JUN_Operations ADD CONSTRAINT FK_E047A52D7975B7E7 FOREIGN KEY (model_id) REFERENCES JUN_Models (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE JUN_Operations DROP FOREIGN KEY FK_E047A52D7975B7E7');
        $this->addSql('DROP TABLE JUN_Models');
        $this->addSql('DROP TABLE JUN_Operations');
        $this->addSql('DROP TABLE JUN_Operators');
        $this->addSql('DROP TABLE JUN_OperatorsGroups');
        $this->addSql('DROP TABLE JUN_OperatorsWork');
    }
}
