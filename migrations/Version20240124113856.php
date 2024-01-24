<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240124113856 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, traveler_id INT NOT NULL, review_id INT DEFAULT NULL, room_id INT NOT NULL, number VARCHAR(50) NOT NULL, check_in DATETIME NOT NULL, check_out DATETIME NOT NULL, occupants INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_E00CEDDE59BBE8A3 (traveler_id), UNIQUE INDEX UNIQ_E00CEDDE3E2E969B (review_id), INDEX IDX_E00CEDDE54177093 (room_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipment (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipment_room (equipment_id INT NOT NULL, room_id INT NOT NULL, INDEX IDX_481B809D517FE9FE (equipment_id), INDEX IDX_481B809D54177093 (room_id), PRIMARY KEY(equipment_id, room_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favorite (id INT AUTO_INCREMENT NOT NULL, traveler_id INT NOT NULL, INDEX IDX_68C58ED959BBE8A3 (traveler_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favorite_room (favorite_id INT NOT NULL, room_id INT NOT NULL, INDEX IDX_9C9948A4AA17481D (favorite_id), INDEX IDX_9C9948A454177093 (room_id), PRIMARY KEY(favorite_id, room_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE review (id INT AUTO_INCREMENT NOT NULL, traveler_id INT NOT NULL, rooms_id INT NOT NULL, title VARCHAR(50) NOT NULL, comment LONGTEXT NOT NULL, rating INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_794381C659BBE8A3 (traveler_id), INDEX IDX_794381C68E2368AB (rooms_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE room (id INT AUTO_INCREMENT NOT NULL, host_id INT NOT NULL, title VARCHAR(50) NOT NULL, description LONGTEXT DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, city VARCHAR(50) DEFAULT NULL, country VARCHAR(50) DEFAULT NULL, price INT NOT NULL, cover VARCHAR(255) DEFAULT NULL, INDEX IDX_729F519B1FB8D185 (host_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(50) DEFAULT NULL, lastname VARCHAR(50) DEFAULT NULL, birthyear INT DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, city VARCHAR(50) DEFAULT NULL, country VARCHAR(50) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, job VARCHAR(50) DEFAULT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE59BBE8A3 FOREIGN KEY (traveler_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE3E2E969B FOREIGN KEY (review_id) REFERENCES review (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE54177093 FOREIGN KEY (room_id) REFERENCES room (id)');
        $this->addSql('ALTER TABLE equipment_room ADD CONSTRAINT FK_481B809D517FE9FE FOREIGN KEY (equipment_id) REFERENCES equipment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE equipment_room ADD CONSTRAINT FK_481B809D54177093 FOREIGN KEY (room_id) REFERENCES room (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE favorite ADD CONSTRAINT FK_68C58ED959BBE8A3 FOREIGN KEY (traveler_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE favorite_room ADD CONSTRAINT FK_9C9948A4AA17481D FOREIGN KEY (favorite_id) REFERENCES favorite (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE favorite_room ADD CONSTRAINT FK_9C9948A454177093 FOREIGN KEY (room_id) REFERENCES room (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C659BBE8A3 FOREIGN KEY (traveler_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C68E2368AB FOREIGN KEY (rooms_id) REFERENCES room (id)');
        $this->addSql('ALTER TABLE room ADD CONSTRAINT FK_729F519B1FB8D185 FOREIGN KEY (host_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE59BBE8A3');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE3E2E969B');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE54177093');
        $this->addSql('ALTER TABLE equipment_room DROP FOREIGN KEY FK_481B809D517FE9FE');
        $this->addSql('ALTER TABLE equipment_room DROP FOREIGN KEY FK_481B809D54177093');
        $this->addSql('ALTER TABLE favorite DROP FOREIGN KEY FK_68C58ED959BBE8A3');
        $this->addSql('ALTER TABLE favorite_room DROP FOREIGN KEY FK_9C9948A4AA17481D');
        $this->addSql('ALTER TABLE favorite_room DROP FOREIGN KEY FK_9C9948A454177093');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C659BBE8A3');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C68E2368AB');
        $this->addSql('ALTER TABLE room DROP FOREIGN KEY FK_729F519B1FB8D185');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE equipment');
        $this->addSql('DROP TABLE equipment_room');
        $this->addSql('DROP TABLE favorite');
        $this->addSql('DROP TABLE favorite_room');
        $this->addSql('DROP TABLE review');
        $this->addSql('DROP TABLE room');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
