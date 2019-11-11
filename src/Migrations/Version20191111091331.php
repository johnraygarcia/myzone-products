<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191111091331 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, status_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, description LONGTEXT NOT NULL, price DOUBLE PRECISION NOT NULL, rating DOUBLE PRECISION NOT NULL, updated_at DATETIME NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_D34A04AD6BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE products_variations (product_id INT NOT NULL, variation_id INT NOT NULL, INDEX IDX_89ECA7404584665A (product_id), INDEX IDX_89ECA7405182BFD8 (variation_id), PRIMARY KEY(product_id, variation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_image (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, INDEX IDX_64617F034584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_rating (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, rating INT NOT NULL, updated_at DATETIME NOT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_BAF567864584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_productratings (product_id INT NOT NULL, productrating_id INT NOT NULL, INDEX IDX_3E7C7EB74584665A (product_id), UNIQUE INDEX UNIQ_3E7C7EB7EF42C031 (productrating_id), PRIMARY KEY(product_id, productrating_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE variation (id INT AUTO_INCREMENT NOT NULL, variation_value_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_629B33EADB492DBE (variation_value_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE variation_value (id INT AUTO_INCREMENT NOT NULL, value VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD6BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE products_variations ADD CONSTRAINT FK_89ECA7404584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE products_variations ADD CONSTRAINT FK_89ECA7405182BFD8 FOREIGN KEY (variation_id) REFERENCES variation (id)');
        $this->addSql('ALTER TABLE product_image ADD CONSTRAINT FK_64617F034584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product_rating ADD CONSTRAINT FK_BAF567864584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE user_productratings ADD CONSTRAINT FK_3E7C7EB74584665A FOREIGN KEY (product_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_productratings ADD CONSTRAINT FK_3E7C7EB7EF42C031 FOREIGN KEY (productrating_id) REFERENCES product_rating (id)');
        $this->addSql('ALTER TABLE variation ADD CONSTRAINT FK_629B33EADB492DBE FOREIGN KEY (variation_value_id) REFERENCES variation_value (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE products_variations DROP FOREIGN KEY FK_89ECA7404584665A');
        $this->addSql('ALTER TABLE product_image DROP FOREIGN KEY FK_64617F034584665A');
        $this->addSql('ALTER TABLE product_rating DROP FOREIGN KEY FK_BAF567864584665A');
        $this->addSql('ALTER TABLE user_productratings DROP FOREIGN KEY FK_3E7C7EB7EF42C031');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD6BF700BD');
        $this->addSql('ALTER TABLE user_productratings DROP FOREIGN KEY FK_3E7C7EB74584665A');
        $this->addSql('ALTER TABLE products_variations DROP FOREIGN KEY FK_89ECA7405182BFD8');
        $this->addSql('ALTER TABLE variation DROP FOREIGN KEY FK_629B33EADB492DBE');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE products_variations');
        $this->addSql('DROP TABLE product_image');
        $this->addSql('DROP TABLE product_rating');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_productratings');
        $this->addSql('DROP TABLE variation');
        $this->addSql('DROP TABLE variation_value');
    }
}
