<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230327001538 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE appointment (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, type_service_id INT NOT NULL, sent_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', status TINYINT(1) NOT NULL, description VARCHAR(255) DEFAULT NULL, INDEX IDX_FE38F84419EB6921 (client_id), INDEX IDX_FE38F844F05F7FC3 (type_service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, administrateur_id INT NOT NULL, type_article_id INT NOT NULL, title VARCHAR(50) NOT NULL, description VARCHAR(50) NOT NULL, content LONGTEXT NOT NULL, create_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', upload_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_23A0E667EE5403C (administrateur_id), INDEX IDX_23A0E666F9750B9 (type_article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE avis (id INT AUTO_INCREMENT NOT NULL, type_service_id INT NOT NULL, title VARCHAR(50) NOT NULL, content LONGTEXT NOT NULL, create_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_8F91ABF0F05F7FC3 (type_service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, type_service_id INT NOT NULL, title VARCHAR(80) NOT NULL, amount DOUBLE PRECISION NOT NULL, INDEX IDX_E19D9AD2F05F7FC3 (type_service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE souscription (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, service_id INT NOT NULL, amount DOUBLE PRECISION NOT NULL, sent_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', cancel_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', status TINYINT(1) NOT NULL, statut_paiement TINYINT(1) NOT NULL, INDEX IDX_2AED620D19EB6921 (client_id), INDEX IDX_2AED620DED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_article (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_service (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, avis_id INT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, name VARCHAR(50) NOT NULL, first_name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, country VARCHAR(50) NOT NULL, status TINYINT(1) NOT NULL, create_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', uploat_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', entreprise VARCHAR(50) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649197E709F (avis_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F84419EB6921 FOREIGN KEY (client_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F844F05F7FC3 FOREIGN KEY (type_service_id) REFERENCES type_service (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E667EE5403C FOREIGN KEY (administrateur_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E666F9750B9 FOREIGN KEY (type_article_id) REFERENCES type_article (id)');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0F05F7FC3 FOREIGN KEY (type_service_id) REFERENCES type_service (id)');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD2F05F7FC3 FOREIGN KEY (type_service_id) REFERENCES type_service (id)');
        $this->addSql('ALTER TABLE souscription ADD CONSTRAINT FK_2AED620D19EB6921 FOREIGN KEY (client_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE souscription ADD CONSTRAINT FK_2AED620DED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D649197E709F FOREIGN KEY (avis_id) REFERENCES avis (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appointment DROP FOREIGN KEY FK_FE38F84419EB6921');
        $this->addSql('ALTER TABLE appointment DROP FOREIGN KEY FK_FE38F844F05F7FC3');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E667EE5403C');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E666F9750B9');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF0F05F7FC3');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD2F05F7FC3');
        $this->addSql('ALTER TABLE souscription DROP FOREIGN KEY FK_2AED620D19EB6921');
        $this->addSql('ALTER TABLE souscription DROP FOREIGN KEY FK_2AED620DED5CA9E6');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649197E709F');
        $this->addSql('DROP TABLE appointment');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE avis');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE souscription');
        $this->addSql('DROP TABLE type_article');
        $this->addSql('DROP TABLE type_service');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
