<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240121120132 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE favorite_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE favorite (id INT NOT NULL, traveler_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_68C58ED959BBE8A3 ON favorite (traveler_id)');
        $this->addSql('CREATE TABLE favorite_room (favorite_id INT NOT NULL, room_id INT NOT NULL, PRIMARY KEY(favorite_id, room_id))');
        $this->addSql('CREATE INDEX IDX_9C9948A4AA17481D ON favorite_room (favorite_id)');
        $this->addSql('CREATE INDEX IDX_9C9948A454177093 ON favorite_room (room_id)');
        $this->addSql('ALTER TABLE favorite ADD CONSTRAINT FK_68C58ED959BBE8A3 FOREIGN KEY (traveler_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE favorite_room ADD CONSTRAINT FK_9C9948A4AA17481D FOREIGN KEY (favorite_id) REFERENCES favorite (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE favorite_room ADD CONSTRAINT FK_9C9948A454177093 FOREIGN KEY (room_id) REFERENCES room (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE favorite_id_seq CASCADE');
        $this->addSql('ALTER TABLE favorite DROP CONSTRAINT FK_68C58ED959BBE8A3');
        $this->addSql('ALTER TABLE favorite_room DROP CONSTRAINT FK_9C9948A4AA17481D');
        $this->addSql('ALTER TABLE favorite_room DROP CONSTRAINT FK_9C9948A454177093');
        $this->addSql('DROP TABLE favorite');
        $this->addSql('DROP TABLE favorite_room');
    }
}
