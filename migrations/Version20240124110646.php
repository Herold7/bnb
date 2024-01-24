<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240124110646 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE booking_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE equipment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE favorite_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE review_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE room_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE booking (id INT NOT NULL, traveler_id INT NOT NULL, review_id INT DEFAULT NULL, room_id INT NOT NULL, number VARCHAR(50) NOT NULL, check_in TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, check_out TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, occupants INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E00CEDDE59BBE8A3 ON booking (traveler_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E00CEDDE3E2E969B ON booking (review_id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDE54177093 ON booking (room_id)');
        $this->addSql('CREATE TABLE equipment (id INT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE equipment_room (equipment_id INT NOT NULL, room_id INT NOT NULL, PRIMARY KEY(equipment_id, room_id))');
        $this->addSql('CREATE INDEX IDX_481B809D517FE9FE ON equipment_room (equipment_id)');
        $this->addSql('CREATE INDEX IDX_481B809D54177093 ON equipment_room (room_id)');
        $this->addSql('CREATE TABLE favorite (id INT NOT NULL, traveler_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_68C58ED959BBE8A3 ON favorite (traveler_id)');
        $this->addSql('CREATE TABLE favorite_room (favorite_id INT NOT NULL, room_id INT NOT NULL, PRIMARY KEY(favorite_id, room_id))');
        $this->addSql('CREATE INDEX IDX_9C9948A4AA17481D ON favorite_room (favorite_id)');
        $this->addSql('CREATE INDEX IDX_9C9948A454177093 ON favorite_room (room_id)');
        $this->addSql('CREATE TABLE review (id INT NOT NULL, traveler_id INT NOT NULL, rooms_id INT NOT NULL, title VARCHAR(50) NOT NULL, comment TEXT NOT NULL, rating INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_794381C659BBE8A3 ON review (traveler_id)');
        $this->addSql('CREATE INDEX IDX_794381C68E2368AB ON review (rooms_id)');
        $this->addSql('CREATE TABLE room (id INT NOT NULL, host_id INT NOT NULL, title VARCHAR(50) NOT NULL, description TEXT DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, city VARCHAR(50) DEFAULT NULL, country VARCHAR(50) DEFAULT NULL, price INT NOT NULL, cover VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_729F519B1FB8D185 ON room (host_id)');
        $this->addSql('CREATE TABLE user (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(50) DEFAULT NULL, lastname VARCHAR(50) DEFAULT NULL, birthyear INT DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, city VARCHAR(50) DEFAULT NULL, country VARCHAR(50) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, job VARCHAR(50) DEFAULT NULL, is_verified BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE59BBE8A3 FOREIGN KEY (traveler_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE3E2E969B FOREIGN KEY (review_id) REFERENCES review (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE54177093 FOREIGN KEY (room_id) REFERENCES room (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE equipment_room ADD CONSTRAINT FK_481B809D517FE9FE FOREIGN KEY (equipment_id) REFERENCES equipment (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE equipment_room ADD CONSTRAINT FK_481B809D54177093 FOREIGN KEY (room_id) REFERENCES room (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE favorite ADD CONSTRAINT FK_68C58ED959BBE8A3 FOREIGN KEY (traveler_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE favorite_room ADD CONSTRAINT FK_9C9948A4AA17481D FOREIGN KEY (favorite_id) REFERENCES favorite (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE favorite_room ADD CONSTRAINT FK_9C9948A454177093 FOREIGN KEY (room_id) REFERENCES room (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C659BBE8A3 FOREIGN KEY (traveler_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C68E2368AB FOREIGN KEY (rooms_id) REFERENCES room (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE room ADD CONSTRAINT FK_729F519B1FB8D185 FOREIGN KEY (host_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE booking_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE equipment_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE favorite_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE review_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE room_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_id_seq CASCADE');
        $this->addSql('ALTER TABLE booking DROP CONSTRAINT FK_E00CEDDE59BBE8A3');
        $this->addSql('ALTER TABLE booking DROP CONSTRAINT FK_E00CEDDE3E2E969B');
        $this->addSql('ALTER TABLE booking DROP CONSTRAINT FK_E00CEDDE54177093');
        $this->addSql('ALTER TABLE equipment_room DROP CONSTRAINT FK_481B809D517FE9FE');
        $this->addSql('ALTER TABLE equipment_room DROP CONSTRAINT FK_481B809D54177093');
        $this->addSql('ALTER TABLE favorite DROP CONSTRAINT FK_68C58ED959BBE8A3');
        $this->addSql('ALTER TABLE favorite_room DROP CONSTRAINT FK_9C9948A4AA17481D');
        $this->addSql('ALTER TABLE favorite_room DROP CONSTRAINT FK_9C9948A454177093');
        $this->addSql('ALTER TABLE review DROP CONSTRAINT FK_794381C659BBE8A3');
        $this->addSql('ALTER TABLE review DROP CONSTRAINT FK_794381C68E2368AB');
        $this->addSql('ALTER TABLE room DROP CONSTRAINT FK_729F519B1FB8D185');
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
