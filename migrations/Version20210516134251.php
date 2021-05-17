<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210516134251 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE approval (id INT AUTO_INCREMENT NOT NULL, approved_by_id INT DEFAULT NULL, is_approved TINYINT(1) DEFAULT NULL, approved_at DATETIME DEFAULT NULL, INDEX IDX_16E0952B2D234F6A (approved_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE approval ADD CONSTRAINT FK_16E0952B2D234F6A FOREIGN KEY (approved_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE post ADD approval_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DFE65F000 FOREIGN KEY (approval_id) REFERENCES approval (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5A8A6C8DFE65F000 ON post (approval_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DFE65F000');
        $this->addSql('DROP TABLE approval');
        $this->addSql('DROP INDEX UNIQ_5A8A6C8DFE65F000 ON post');
        $this->addSql('ALTER TABLE post DROP approval_id');
    }
}
