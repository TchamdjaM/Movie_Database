<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221007134446 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE films DROP FOREIGN KEY FK_CEECCA514296D31F');
        $this->addSql('ALTER TABLE films DROP FOREIGN KEY FK_CEECCA5171A27AFC');
        $this->addSql('DROP INDEX IDX_CEECCA514296D31F ON films');
        $this->addSql('DROP INDEX IDX_CEECCA5171A27AFC ON films');
        $this->addSql('ALTER TABLE films DROP acteurs_id, DROP genre_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE films ADD acteurs_id INT DEFAULT NULL, ADD genre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE films ADD CONSTRAINT FK_CEECCA514296D31F FOREIGN KEY (genre_id) REFERENCES genres (id)');
        $this->addSql('ALTER TABLE films ADD CONSTRAINT FK_CEECCA5171A27AFC FOREIGN KEY (acteurs_id) REFERENCES acteurs (id)');
        $this->addSql('CREATE INDEX IDX_CEECCA514296D31F ON films (genre_id)');
        $this->addSql('CREATE INDEX IDX_CEECCA5171A27AFC ON films (acteurs_id)');
    }
}
