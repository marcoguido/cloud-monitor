SELECT 'CREATE DATABASE infrastructure_manager_db'
WHERE NOT EXISTS (SELECT FROM pg_database WHERE datname = 'infrastructure_manager_db')\gexec
