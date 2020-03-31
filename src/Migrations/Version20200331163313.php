<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200331163313 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE companies (id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE products (id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, price INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE company_products (product_id VARCHAR(255) NOT NULL, company_id VARCHAR(255) NOT NULL, PRIMARY KEY(product_id, company_id))');
        $this->addSql('CREATE INDEX IDX_AB2D4F374584665A ON company_products (product_id)');
        $this->addSql('CREATE INDEX IDX_AB2D4F37979B1AD6 ON company_products (company_id)');
        $this->addSql('ALTER TABLE company_products ADD CONSTRAINT FK_AB2D4F374584665A FOREIGN KEY (product_id) REFERENCES products (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE company_products ADD CONSTRAINT FK_AB2D4F37979B1AD6 FOREIGN KEY (company_id) REFERENCES companies (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE company_products DROP CONSTRAINT FK_AB2D4F37979B1AD6');
        $this->addSql('ALTER TABLE company_products DROP CONSTRAINT FK_AB2D4F374584665A');
        $this->addSql('DROP TABLE companies');
        $this->addSql('DROP TABLE products');
        $this->addSql('DROP TABLE company_products');
    }
}
