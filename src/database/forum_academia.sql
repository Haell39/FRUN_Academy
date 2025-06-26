-- src/database/forum_academia.sql

-- --------------------------------------------------------
-- Estrutura da tabela `users`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
                                       `id` INTEGER AUTO_INCREMENT,
                                       `apelido` VARCHAR(30) NOT NULL UNIQUE,
    `nome` VARCHAR(100),
    `email` VARCHAR(80) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL, -- Aumentei para 255 para hashes de senha
    `foto` VARCHAR(255) DEFAULT 'default_profile.png', -- Adicionei um default para não ser NOT NULL e facilitar
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `regiao` VARCHAR(20),
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Estrutura da tabela `posts`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `posts` (
                                       `id` INTEGER AUTO_INCREMENT,
                                       `user_id` INTEGER,
                                       `titulo` VARCHAR(250) NOT NULL,
    `corpo` TEXT NOT NULL, -- Alterei para TEXT, pois VARCHAR(12000) é muito grande e pode dar erro em alguns MySQLs
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Estrutura da tabela `comentarios`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `comentarios` (
                                             `id` INTEGER AUTO_INCREMENT,
                                             `user_id` INTEGER,
                                             `post_id` INTEGER,
                                             `texto` TEXT NOT NULL, -- Alterei para TEXT
                                             `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                             PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`post_id`) REFERENCES `posts`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Dados de exemplo (Opcional, para facilitar testes iniciais)
-- --------------------------------------------------------

-- Senhas para usuários (use BCrypt hash no PHP):
-- 'senha123' -> $2y$10$92hFjD0c2zL3d8xS0yS4.O5G6H7I8J9K0L1M2N3O4P5Q6R7S8T9U0V1W2X3Y4Z5A6B7C8D9E0F1 (exemplo de hash)
-- 'outrasenha' -> $2y$10$AbCdEfGhIjKlMnOpQrStUvWxYz0123456789aBcDeFgHiJkLmNoPqRsTuVwXyZ01234 (exemplo de hash)

INSERT INTO `users` (`apelido`, `nome`, `email`, `password`, `foto`, `regiao`) VALUES
                                                                                   ('joaosilva', 'João Silva', 'joao@example.com', '$2y$10$92hFjD0c2zL3d8xS0yS4.O5G6H7I8J9K0L1M2N3O4P5Q6R7S8T9U0V1W2X3Y4Z5A6B7C8D9E0F1', 'default_profile.png', 'Sudeste'),
                                                                                   ('mariasantos', 'Maria Santos', 'maria@example.com', '$2y$10$AbCdEfGhIjKlMnOpQrStUvWxYz0123456789aBcDeFgHiJkLmNoPqRsTuVwXyZ01234', 'default_profile.png', 'Sul');

INSERT INTO `posts` (`user_id`, `titulo`, `corpo`) VALUES
                                                       (1, 'Primeiro Post de Teste', 'Este é o corpo do primeiro post, escrito por João Silva. Ele fala sobre o início da nossa jornada no desenvolvimento web.'),
                                                       (1, 'Dicas de Produtividade para Desenvolvedores', 'Compartilhando algumas técnicas e ferramentas que me ajudam a ser mais produtivo no dia a dia como desenvolvedor.'),
                                                       (2, 'Minha Experiência com Bootstrap 5', 'Estou adorando as novas funcionalidades do Bootstrap 5! Flexbox e as classes de espaçamento são fantásticas.'),
                                                       (2, 'O que esperar de um Projeto Acadêmico', 'Algumas reflexões sobre os desafios e aprendizados que podemos tirar de projetos como este na faculdade.');

INSERT INTO `comentarios` (`user_id`, `post_id`, `texto`) VALUES
                                                              (2, 1, 'Ótimo post, João! Muito inspirador.'),
                                                              (1, 3, 'Concordo plenamente, Maria! O Bootstrap 5 está incrível.');