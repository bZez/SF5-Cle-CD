<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200210143445 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE code DROP FOREIGN KEY FK_77153098F6985D08');
        $this->addSql('DROP TABLE `key`');
        $this->addSql('DROP INDEX UNIQ_77153098F6985D08 ON code');
        $this->addSql('ALTER TABLE code DROP cle_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE `key` (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE code ADD cle_id INT NOT NULL');
        $this->addSql('ALTER TABLE code ADD CONSTRAINT FK_77153098F6985D08 FOREIGN KEY (cle_id) REFERENCES `key` (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_77153098F6985D08 ON code (cle_id)');
    }
}
