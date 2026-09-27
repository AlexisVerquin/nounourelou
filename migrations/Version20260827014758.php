<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260827014758 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ligne_fiche CHANGE heure_normal_jour heure_normal_jour VARCHAR(100) DEFAULT NULL, CHANGE heure_compl_jour heure_compl_jour VARCHAR(100) DEFAULT NULL, CHANGE heure_majorees_jour heure_majorees_jour VARCHAR(100) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ligne_fiche CHANGE heure_normal_jour heure_normal_jour VARCHAR(100) NOT NULL, CHANGE heure_compl_jour heure_compl_jour VARCHAR(100) NOT NULL, CHANGE heure_majorees_jour heure_majorees_jour VARCHAR(100) NOT NULL');
    }
}
