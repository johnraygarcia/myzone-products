<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191107093036 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE variation_value DROP FOREIGN KEY FK_E70337F15182BFD8');
        $this->addSql('DROP INDEX IDX_E70337F15182BFD8 ON variation_value');
        $this->addSql('ALTER TABLE variation_value DROP variation_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE variation_value ADD variation_id INT NOT NULL');
        $this->addSql('ALTER TABLE variation_value ADD CONSTRAINT FK_E70337F15182BFD8 FOREIGN KEY (variation_id) REFERENCES variation (id)');
        $this->addSql('CREATE INDEX IDX_E70337F15182BFD8 ON variation_value (variation_id)');
    }
}
