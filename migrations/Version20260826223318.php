<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260826223318 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fiche (id INT AUTO_INCREMENT NOT NULL, date_debut DATETIME NOT NULL, date_fin VARCHAR(255) NOT NULL, heures_normal_mensuel INT NOT NULL, heures_majorees_mensuel INT NOT NULL, montant_deduction_periode_abs DOUBLE PRECISION NOT NULL, montant_divers DOUBLE PRECISION NOT NULL, montant_conges DOUBLE PRECISION NOT NULL, conge_date_start DATETIME DEFAULT NULL, conge_date_end DATETIME DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE ligne_fiche (id INT AUTO_INCREMENT NOT NULL, date DATETIME NOT NULL, heure_normal_jour VARCHAR(100) NOT NULL, heure_compl_jour VARCHAR(100) NOT NULL, heure_majorees_jour VARCHAR(100) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE fiche');
        $this->addSql('DROP TABLE ligne_fiche');
    }
}
