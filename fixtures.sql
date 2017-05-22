
-- nette commits - initial data

INSERT IGNORE INTO `project` (`id`, `name`) VALUES
('b82r4gf7',	'Framework'),
('xbgtp7ww',	'Documentation'),
('xnjpn0du',	'Promo'),
('6qbku3rw',	'Tools'),
('955svzgv',	'Tester');


INSERT IGNORE INTO `repository` (`id`, `name`, `project_id`) VALUES

-- Framework
('98263d86',	'nette/application',	'b82r4gf7'),
('9826468c',	'nette/bootstrap',	'b82r4gf7'),
('98264747',	'nette/caching',	'b82r4gf7'),
('9826493d',	'nette/component-model',	'b82r4gf7'),
('982649be',	'nette/database',	'b82r4gf7'),
('98264a27',	'nette/deprecated',	'b82r4gf7'),
('98264a99',	'nette/di',	'b82r4gf7'),
('98264bd8',	'nette/finder',	'b82r4gf7'),
('98264c3e',	'nette/forms',	'b82r4gf7'),
('98264ca6',	'nette/http',	'b82r4gf7'),
('98264d0b',	'nette/latte',	'b82r4gf7'),
('98264d68',	'nette/mail',	'b82r4gf7'),
('98264e3a',	'nette/neon',	'b82r4gf7'),
('98264ea4',	'nette/nette',	'b82r4gf7'),
('98264f09',	'nette/php-generator',	'b82r4gf7'),
('98264f75',	'nette/reflection',	'b82r4gf7'),
('98264fe0',	'nette/robot-loader',	'b82r4gf7'),
('9826504e',	'nette/routing',	'b82r4gf7'),
('98265113',	'nette/safe-stream',	'b82r4gf7'),
('982651e9',	'nette/schema',	'b82r4gf7'),
('98265247',	'nette/security',	'b82r4gf7'),
('98265316',	'nette/tokenizer',	'b82r4gf7'),
('98265381',	'nette/tracy',	'b82r4gf7'),
('982654c0',	'nette/utils',	'b82r4gf7'),

-- Documentation
('98264b0d',	'nette/docs',	'xbgtp7ww'),

-- Promo
('98264b77',	'nette/examples',	'xnjpn0du'),
('9826517f',	'nette/sandbox',	'xnjpn0du'),
('982653e5',	'nette/tutorial-quickstart',	'xnjpn0du'),
('9826552b',	'nette/web-project',	'xnjpn0du'),

-- Tools
('982647c7',	'nette/code-checker',	'6qbku3rw'),
('98264840',	'nette/coding-standard',	'6qbku3rw'),
('982648c1',	'nette/command-line',	'6qbku3rw'),
('98265455',	'nette/type-fixer',	'6qbku3rw'),

-- Tester
('982652b0',	'nette/tester',	'955svzgv')

;
