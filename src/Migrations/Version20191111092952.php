<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191111092952 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE user_productratings');
        $this->addSql('ALTER TABLE product DROP rating');
        $this->addSql('ALTER TABLE product_rating DROP INDEX UNIQ_BAF567864584665A, ADD INDEX IDX_BAF567864584665A (product_id)');
        $this->addSql('ALTER TABLE product_rating ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product_rating ADD CONSTRAINT FK_BAF56786A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BAF56786A76ED395 ON product_rating (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_productratings (product_id INT NOT NULL, productrating_id INT NOT NULL, UNIQUE INDEX UNIQ_3E7C7EB7EF42C031 (productrating_id), INDEX IDX_3E7C7EB74584665A (product_id), PRIMARY KEY(product_id, productrating_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user_productratings ADD CONSTRAINT FK_3E7C7EB74584665A FOREIGN KEY (product_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_productratings ADD CONSTRAINT FK_3E7C7EB7EF42C031 FOREIGN KEY (productrating_id) REFERENCES product_rating (id)');
        $this->addSql('ALTER TABLE product ADD rating DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE product_rating DROP INDEX IDX_BAF567864584665A, ADD UNIQUE INDEX UNIQ_BAF567864584665A (product_id)');
        $this->addSql('ALTER TABLE product_rating DROP FOREIGN KEY FK_BAF56786A76ED395');
        $this->addSql('DROP INDEX UNIQ_BAF56786A76ED395 ON product_rating');
        $this->addSql('ALTER TABLE product_rating DROP user_id');
    }
}
