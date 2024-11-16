<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241116213847 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add unique constraint for phone_type and phone_number in the phones table.';
    }

    public function up(Schema $schema): void
    {
        // Criar uma chave única composta pelas colunas phone_type e phone_number
        $this->addSql('CREATE UNIQUE INDEX UNIQ_PHONE_TYPE_NUMBER ON phones (phone_type, phone_number, user_id_id)');
    }

    public function down(Schema $schema): void
    {
        // Reverter a criação da chave única composta
        $this->addSql('DROP INDEX UNIQ_PHONE_TYPE_NUMBER ON phones');
    }
}

