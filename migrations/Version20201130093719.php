<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201130093719 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE movie (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, slug VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, note INT NOT NULL, nb_note INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        /*
        $this->addSql('CREATE TABLE Favoris (user_id INT NOT NULL, movie_id INT NOT NULL, INDEX IDX_468EFDAEA76ED395 (user_id), INDEX IDX_468EFDAE8F93B6FC (movie_id), PRIMARY KEY(user_id, movie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Favoris ADD CONSTRAINT FK_468EFDAEA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE Favoris ADD CONSTRAINT FK_468EFDAE8F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id) ON DELETE CASCADE');
        */
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        // $this->addSql('ALTER TABLE Favoris DROP FOREIGN KEY FK_468EFDAE8F93B6FC');
        // $this->addSql('DROP TABLE movie');
        $this->addSql('DROP TABLE Favoris');
    }
}
