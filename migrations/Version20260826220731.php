<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260826220731 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'create tables contrat nounou bebe messenger';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE bebe (id INT AUTO_INCREMENT NOT NULL, fullname_parent VARCHAR(255) NOT NULL, adress LONGTEXT NOT NULL, postalcode VARCHAR(10) NOT NULL, city VARCHAR(10) NOT NULL, num_employeur VARCHAR(100) NOT NULL, fullname_child VARCHAR(255) NOT NULL, birthdate DATETIME NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE contrat (id INT AUTO_INCREMENT NOT NULL, semaine_heures INT NOT NULL, nombre_semaine INT NOT NULL, tarif_horaire_brut_heures_normal DOUBLE PRECISION NOT NULL, tarif_horaire_brut_heures_complementaire DOUBLE PRECISION NOT NULL, tarif_horaire_brut_heures_majorees DOUBLE PRECISION NOT NULL, indemnite_entretien DOUBLE PRECISION NOT NULL, indemnite_dejeuner DOUBLE PRECISION NOT NULL, indemnite_gouter DOUBLE PRECISION NOT NULL, indemnite_rupture DOUBLE PRECISION NOT NULL, indemnite_autre DOUBLE PRECISION NOT NULL, taux_horaire_net_base DOUBLE PRECISION NOT NULL, coef DOUBLE PRECISION NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE nounou (id INT AUTO_INCREMENT NOT NULL, lastname VARCHAR(100) NOT NULL, firstname VARCHAR(100) NOT NULL, adress LONGTEXT NOT NULL, postalcode VARCHAR(10) NOT NULL, city VARCHAR(10) NOT NULL, num_pajeemploi VARCHAR(50) NOT NULL, start_date DATETIME NOT NULL, qualification VARCHAR(100) NOT NULL, contrat_type VARCHAR(10) NOT NULL, num_secu VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE bebe');
        $this->addSql('DROP TABLE contrat');
        $this->addSql('DROP TABLE nounou');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
