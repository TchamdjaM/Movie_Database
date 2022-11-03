<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221007135957 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE films_genres (films_id INT NOT NULL, genres_id INT NOT NULL, INDEX IDX_1FBF6EAF939610EE (films_id), INDEX IDX_1FBF6EAF6A3B2603 (genres_id), PRIMARY KEY(films_id, genres_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE films_genres ADD CONSTRAINT FK_1FBF6EAF939610EE FOREIGN KEY (films_id) REFERENCES films (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE films_genres ADD CONSTRAINT FK_1FBF6EAF6A3B2603 FOREIGN KEY (genres_id) REFERENCES genres (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE films_genres DROP FOREIGN KEY FK_1FBF6EAF939610EE');
        $this->addSql('ALTER TABLE films_genres DROP FOREIGN KEY FK_1FBF6EAF6A3B2603');
        $this->addSql('DROP TABLE films_genres');
    }
}
