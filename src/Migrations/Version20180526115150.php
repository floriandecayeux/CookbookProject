<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180526115150 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE recette ADD categorie VARCHAR(25) NOT NULL, ADD keyword VARCHAR(250) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_49BB6390497DD634 ON recette (categorie)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_49BB63905A93713B ON recette (keyword)');
        $this->addSql('ALTER TABLE user DROP roles');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_49BB6390497DD634 ON recette');
        $this->addSql('DROP INDEX UNIQ_49BB63905A93713B ON recette');
        $this->addSql('ALTER TABLE recette DROP categorie, DROP keyword');
        $this->addSql('ALTER TABLE user ADD roles JSON NOT NULL');
    }
}
