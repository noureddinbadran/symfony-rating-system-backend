<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220408233328 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `member` (`id` int(11) NOT NULL AUTO_INCREMENT,`username` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,PRIMARY KEY (`id`))');
        $this->addSql('CREATE TABLE `client` (`id` int(11) NOT NULL AUTO_INCREMENT,`username` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT \'Email as the username\',`password` varchar(96) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT \'Use password hash with BCRYPT\',`created` datetime NOT NULL,`first_name` varchar(96) COLLATE utf8mb4_unicode_ci NOT NULL,`last_name` varchar(96) COLLATE utf8mb4_unicode_ci NOT NULL,PRIMARY KEY (`id`),UNIQUE KEY `UNIQ_70E4FA78F85E0677` (`username`),KEY `username_idx` (`username`))');
        $this->addSql('CREATE TABLE `vico` (`id` int(11) NOT NULL AUTO_INCREMENT,`name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,`created` datetime NOT NULL,PRIMARY KEY (`id`),KEY `name_idx` (`name`))');
        $this->addSql('CREATE TABLE `project` (`id` int(11) NOT NULL AUTO_INCREMENT,`creator_id` int(11) NOT NULL,`vico_id` int(11) DEFAULT NULL,`created` datetime NOT NULL,`title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,PRIMARY KEY (`id`),KEY `IDX_2FB3D0EE19F89217` (`vico_id`),KEY `creator_idx` (`creator_id`),KEY `created_idx` (`created`),CONSTRAINT `FK_2FB3D0EE19F89217` FOREIGN KEY (`vico_id`) REFERENCES `vico` (`id`) ON DELETE CASCADE,CONSTRAINT `FK_2FB3D0EE61220EA6` FOREIGN KEY (`creator_id`) REFERENCES `member` (`id`) ON DELETE CASCADE) ENGINE=InnoDB');
        $this->addSql('CREATE TABLE rating (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, project_id INT NOT NULL, score FLOAT NOT NULL, comment VARCHAR(255) NOT NULL, INDEX IDX_D8892622166D1F9C (project_id), INDEX IDX_D889262219EB6921 (client_id), PRIMARY KEY(id), UNIQUE KEY `UNIQ_70E4FA78CV5678EH` (`client_id`, `project_id`), CONSTRAINT FK_D8892622166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE, CONSTRAINT FK_D889262219EB6921 FOREIGN KEY (client_id) REFERENCES client (id) ON DELETE CASCADE) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rating_aspect (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(64) NOT NULL, code VARCHAR(64) NOT NULL, description VARCHAR(255) NOT NULL, KEY `IDX_2FB3D0EE19F87854` (`code`), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rating_detail (id INT AUTO_INCREMENT NOT NULL, rating_id INT NOT NULL, rating_aspect_id INT NOT NULL, score FLOAT NOT NULL,INDEX IDX_D8892622166D1F9C (rating_id), INDEX IDX_D889262219EB6921 (rating_aspect_id), PRIMARY KEY(id), UNIQUE KEY `UNIQ_70E4FA78F8a23wDF` (`rating_id`, `rating_aspect_id`), CONSTRAINT FK_D8892622166W45T3 FOREIGN KEY (rating_id) REFERENCES rating (id) ON DELETE CASCADE, CONSTRAINT FK_D889262219EHT65F FOREIGN KEY (rating_aspect_id) REFERENCES rating_aspect (id) ON DELETE CASCADE) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE member');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE vico');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE rating');
        $this->addSql('DROP TABLE rating_aspect');
        $this->addSql('DROP TABLE rating_detail');
    }
}
