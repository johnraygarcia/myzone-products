<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191107060144 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE products_variations (product_id INT NOT NULL, variation_id INT NOT NULL, INDEX IDX_89ECA7404584665A (product_id), INDEX IDX_89ECA7405182BFD8 (variation_id), PRIMARY KEY(product_id, variation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE products_variations ADD CONSTRAINT FK_89ECA7404584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE products_variations ADD CONSTRAINT FK_89ECA7405182BFD8 FOREIGN KEY (variation_id) REFERENCES variation (id)');
        $this->addSql('DROP TABLE products_varaitions');
        $this->addSql('ALTER TABLE variation_value ADD CONSTRAINT FK_E70337F15182BFD8 FOREIGN KEY (variation_id) REFERENCES variation (id)');
        $this->addSql('CREATE INDEX IDX_E70337F15182BFD8 ON variation_value (variation_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE products_varaitions (product_id INT NOT NULL, variation_id INT NOT NULL, INDEX IDX_56506B4A5182BFD8 (variation_id), INDEX IDX_56506B4A4584665A (product_id), PRIMARY KEY(product_id, variation_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE products_varaitions ADD CONSTRAINT FK_56506B4A4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE products_varaitions ADD CONSTRAINT FK_56506B4A5182BFD8 FOREIGN KEY (variation_id) REFERENCES variation (id)');
        $this->addSql('DROP TABLE products_variations');
        $this->addSql('ALTER TABLE variation_value DROP FOREIGN KEY FK_E70337F15182BFD8');
        $this->addSql('DROP INDEX IDX_E70337F15182BFD8 ON variation_value');
    }
}
