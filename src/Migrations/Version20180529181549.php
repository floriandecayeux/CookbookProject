<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180529181549 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_49BB6390FF7747B4 ON recette');
        $this->addSql('DROP INDEX UNIQ_49BB6390497DD634 ON recette');
        $this->addSql('DROP INDEX UNIQ_49BB63905A93713B ON recette');
        $this->addSql('ALTER TABLE recette CHANGE titre titre VARCHAR(50) NOT NULL, CHANGE temps_preparation temps_preparation INT NOT NULL, CHANGE categorie categorie VARCHAR(25) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE recette CHANGE titre titre VARCHAR(25) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE temps_preparation temps_preparation INT DEFAULT NULL, CHANGE categorie categorie VARCHAR(25) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_49BB6390FF7747B4 ON recette (titre)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_49BB6390497DD634 ON recette (categorie)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_49BB63905A93713B ON recette (keyword)');
    }
}