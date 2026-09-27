<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260826225314 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fiche CHANGE heures_normal_mensuel heures_normal_mensuel INT NOT NULL, CHANGE montant_deduction_periode_abs montant_deduction_periode_abs DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE ligne_fiche ADD heure_compl_jour VARCHAR(100) NOT NULL, ADD heure_majorees_jour VARCHAR(100) NOT NULL, ADD fiche_id INT DEFAULT NULL, DROP heure_compl_jour, DROP heure_majorees_jour');
        $this->addSql('ALTER TABLE ligne_fiche ADD CONSTRAINT FK_4FBF2648DF522508 FOREIGN KEY (fiche_id) REFERENCES fiche (id)');
        $this->addSql('CREATE INDEX IDX_4FBF2648DF522508 ON ligne_fiche (fiche_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fiche CHANGE heures_normal_mensuel heures_normal_mensuel INT NOT NULL, CHANGE montant_deduction_periode_abs montant_deduction_periode_abs DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE ligne_fiche DROP FOREIGN KEY FK_4FBF2648DF522508');
        $this->addSql('DROP INDEX IDX_4FBF2648DF522508 ON ligne_fiche');
        $this->addSql('ALTER TABLE ligne_fiche ADD heure_compl_jour VARCHAR(100) NOT NULL, ADD heure_majorees_jour VARCHAR(100) NOT NULL, DROP heure_compl_jour, DROP heure_majorees_jour, DROP fiche_id');
    }
}
