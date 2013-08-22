-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: 22/08/2013 às 12h30min
-- Versão do Servidor: 5.5.32
-- Versão do PHP: 5.3.10-1ubuntu3.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `curso_loja`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `aparencia`
--

CREATE TABLE IF NOT EXISTS `aparencia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fundo_header_pequeno` varchar(255) NOT NULL,
  `fundo_header_grande` varchar(255) NOT NULL,
  `borda_cor` varchar(10) NOT NULL,
  `extra` varchar(255) NOT NULL,
  `nome` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Extraindo dados da tabela `aparencia`
--

INSERT INTO `aparencia` (`id`, `fundo_header_pequeno`, `fundo_header_grande`, `borda_cor`, `extra`, `nome`) VALUES
(1, 'btn4_amarelo_1.gif', 'btn4_amarelo_m_1.gif', '#F1F3F8', '-', 'Laranja'),
(2, 'btn4_blue_1.gif', 'btn4_blue_m_1.gif', '#99FF00', '-', 'Azul'),
(3, 'btn4_red_1.gif', 'btn4_red_m_1.gif', '#99FF00', '-', 'Vermelho'),
(4, 'btn4_roxo_1.gif', 'btn4_roxo_m_1.gif', '#9900FF', '-', 'Roxo'),
(5, 'btn4_laranja_1.gif', 'btn4_laranja_m_1.gif', '#999999', '-', 'laranja'),
(6, 'btn4_green_1.gif', 'btn4_green_m_1.gif', '#006633', '-', 'Verde');

-- --------------------------------------------------------

--
-- Estrutura da tabela `aparencia_atual`
--

CREATE TABLE IF NOT EXISTS `aparencia_atual` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `header_p` varchar(255) NOT NULL,
  `header_m` varchar(255) NOT NULL,
  `borda` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `aparencia_atual`
--

INSERT INTO `aparencia_atual` (`id`, `header_p`, `header_m`, `borda`) VALUES
(1, 'btn4_blue_1.gif', 'btn4_red_m_1.gif', '#006633');

-- --------------------------------------------------------

--
-- Estrutura da tabela `categorias`
--

CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL DEFAULT '',
  `imagem` varchar(255) DEFAULT NULL,
  `descricao` mediumtext NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Extraindo dados da tabela `categorias`
--

INSERT INTO `categorias` (`id`, `nome`, `imagem`, `descricao`) VALUES
(7, 'Câmeras', '00000001k.jpg', 'Câmeras fotográficas '),
(8, 'Monitores', '20758695[1].jpg', 'Monitores de Computador'),
(9, 'Celulares', '00000004.jpg', 'Telefones celular'),
(10, 'Impressoras', '999001.jpg', 'Impressoras de computador'),
(11, 'Mp3 e Mp4', '00000005M.jpg', 'Mp3 de Mp4'),
(12, 'Webcam', '20262662[2].jpg', 'Webcam para pc'),
(13, 'Notebooks', '22228276[1].jpg', 'Notebooks com varias configurações'),
(14, 'Mouse', '22041242[1].jpg', 'Mouse para pc e notebooks');

-- --------------------------------------------------------

--
-- Estrutura da tabela `contato`
--

CREATE TABLE IF NOT EXISTS `contato` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `mensagem` text NOT NULL,
  `telefone` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `contato`
--

INSERT INTO `contato` (`id`, `nome`, `email`, `mensagem`, `telefone`) VALUES
(1, 'nathan', 'teste@teste.com.b', 'olá , tudo bem ', '(11) 1111-1111'),
(2, 'nathan', 'teste@teste.com.br', 'olá tufo bom ', '(33) 3333-3333'),
(3, 'Nathan', 'gersonnathan@yahoo.com.br', 'olá', '(11) 1111-1111'),
(4, 'nathan', 'teste@teste.com.br', 'olá, tete', '(11) 2121-2212');

-- --------------------------------------------------------

--
-- Estrutura da tabela `conteudo`
--

CREATE TABLE IF NOT EXISTS `conteudo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_menu` int(11) NOT NULL,
  `titulo` text NOT NULL,
  `conteudo` text NOT NULL,
  `saiba_mais` text NOT NULL,
  `data` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `id_menu` (`id_menu`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Extraindo dados da tabela `conteudo`
--

INSERT INTO `conteudo` (`id`, `id_menu`, `titulo`, `conteudo`, `saiba_mais`, `data`) VALUES
(7, 3, 'Lorem isum dolor amet elitr.', '<div align="center"><pre id="line1"><strong><span class="attribute-value">Lorem isum dolor amet elitr.</span></strong></pre></div><p>&nbsp;</p>\r\n<pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.</span></pre><p>&nbsp;</p>\r\n<pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.</span></pre><p>&nbsp;</p>\r\n<pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.</span></pre><p>&nbsp;</p>', '<div align="center">\r\n<pre id="line1"><strong><span class="attribute-value">Lorem isum dolor amet elitr.</span></strong></pre>\r\n</div>\r\n\r\n<pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.</span></pre>\r\n\r\n<pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.</span></pre>\r\n\r\n<pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.</span></pre>\r\n<p>&nbsp;</p>', '2007-12-10'),
(8, 4, 'Lorem isum dolor amet elitr.', '<div align="center"><h2><font color="#000099"><strong><span class="attribute-value">Lorem isum dolor amet elitr.</span></strong></font></h2></div>\r\n\r\n<pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.</span></pre>\r\n\r\n<pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.</span></pre>\r\n\r\n<pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.</span></pre>', '<div align="center">\r\n<pre id="line1"><strong><span class="attribute-value">Lorem isum dolor amet elitr.</span></strong></pre>\r\n</div>\r\n\r\n<pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.</span></pre>\r\n\r\n<pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.</span></pre>\r\n\r\n<pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.</span></pre>\r\n<p>&nbsp;</p>', '2007-12-10');

-- --------------------------------------------------------

--
-- Estrutura da tabela `geral`
--

CREATE TABLE IF NOT EXISTS `geral` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` text NOT NULL,
  `conteudo` text NOT NULL,
  `leia_mais` text NOT NULL,
  `data` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `geral`
--

INSERT INTO `geral` (`id`, `titulo`, `conteudo`, `leia_mais`, `data`) VALUES
(1, 'Lorem isum dolor amet elitr.', '<table border="0" cellpadding="2" cellspacing="2" style="" width="497">\r\n<tbody>\r\n  <tr>\r\n    <td style=""> <img border="0" height="197" src="http://localhost/curso_loja/uploads/media/p1.jpg" width="403"/></td>\r\n    <td style=""> <img border="0" height="197" src="http://localhost/curso_loja/uploads/media/promo.jpg" width="134"/></td>\r\n  </tr>\r\n</tbody>\r\n</table>', '', '0000-00-00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `info`
--

CREATE TABLE IF NOT EXISTS `info` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `smtp` varchar(255) NOT NULL,
  `pop` varchar(255) NOT NULL,
  `usuario` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `info`
--

INSERT INTO `info` (`id`, `nome`, `email`, `smtp`, `pop`, `usuario`, `senha`) VALUES
(0, 'Nathan', 'concretizad@yahoo.com.br', '', '', '', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `logo` varchar(255) NOT NULL DEFAULT '',
  `login` varchar(20) NOT NULL DEFAULT '',
  `senha` varchar(10) NOT NULL DEFAULT '',
  `nivel` char(2) NOT NULL DEFAULT '',
  `ativo` char(2) NOT NULL DEFAULT '',
  `ramdom` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `login`
--

INSERT INTO `login` (`id`, `nome`, `email`, `logo`, `login`, `senha`, `nivel`, `ativo`, `ramdom`) VALUES
(1, 'thiago', 'teste@teste.com.br', '', 'cardoso', '123', '1', '1', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `mensagem`
--

CREATE TABLE IF NOT EXISTS `mensagem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefone` varchar(19) NOT NULL,
  `mensagem` text NOT NULL,
  `resposta` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `menu`
--

INSERT INTO `menu` (`id`, `menu`) VALUES
(3, 'Quem somos'),
(4, 'Local');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pagseguro`
--

CREATE TABLE IF NOT EXISTS `pagseguro` (
  `id` int(11) NOT NULL,
  `email_cobranca` text NOT NULL,
  `tipo` varchar(100) NOT NULL,
  `moeda` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `pagseguro`
--

INSERT INTO `pagseguro` (`id`, `email_cobranca`, `tipo`, `moeda`) VALUES
(1, 'gersonnathan@yahoo.com.br', 'CBR', 'BRL');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE IF NOT EXISTS `produtos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_categ` int(11) NOT NULL,
  `produto` text NOT NULL,
  `descricao` text NOT NULL,
  `imagem` varchar(255) NOT NULL,
  `valor` varchar(100) NOT NULL DEFAULT '0.0000',
  `frete` varchar(100) NOT NULL,
  `promocao` int(11) NOT NULL,
  `exibir` int(11) NOT NULL,
  `qtd_vendas` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_categ` (`id_categ`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=45 ;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`id`, `id_categ`, `produto`, `descricao`, `imagem`, `valor`, `frete`, `promocao`, `exibir`, `qtd_vendas`) VALUES
(1, 7, 'Lorem isum dolor amet elitr', '<p><h1 align="center"><font color="#000099"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></font></h1><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre>  </p>', '00000002k.jpg', '44.35', '05.00', 0, 1, 0),
(2, 7, 'Lorem isum dolor amet elitr', '<p>.Lorem isum dolor amet elitr..Lorem isum dolor amet elitr.</p>\r\n<p>.Lorem isum dolor amet elitr..Lorem isum dolor amet elitr.</p>\r\n<p>.Lorem isum dolor amet elitr..Lorem isum dolor amet elitr.</p>\r\n<p>.Lorem isum dolor amet elitr..Lorem isum dolor amet elitr.</p>', '00000001k_1.jpg', '32.45', '05.40', 0, 1, 0),
(3, 7, '.Lorem isum dolor amet elitr.', '<p> .Lorem isum dolor amet elitr..Lorem isum dolor amet elitr.</p>\r\n<p>.Lorem isum dolor amet elitr..Lorem isum dolor amet elitr.</p>\r\n<p>.Lorem isum dolor amet elitr..Lorem isum dolor amet elitr.</p>\r\n<p><br/></p>', '00000002[1].jpg', '43.76', '05.00', 0, 1, 0),
(4, 7, '.Lorem isum dolor amet elitr.', '<p><h1 align="center"><font color="#000099"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></font></h1><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre>  </p>', '00000003k.jpg', '150.44', '05.00', 0, 1, 0),
(5, 7, '.Lorem isum dolor amet elitr.', '<h1 align="center"> <font color="#000099"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></font></h1><p><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre> </p>', '00000005k.jpg', '88.99', '50.00', 0, 1, 0),
(6, 7, '.Lorem isum dolor amet elitr.', '<p><h1 align="center"><font color="#000099"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></font></h1><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre>  </p>', '00000004k.jpg', '557.60', '20.00', 0, 1, 0),
(7, 7, '.Lorem isum dolor amet elitr.', '<p><h1 align="center"><font color="#000099"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></font></h1><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre>  </p>', '999002.jpg', '442.55', '10.00', 0, 1, 0),
(8, 7, '.Lorem isum dolor amet elitr.', '<p><h1 align="center"><font color="#000099"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></font></h1><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre>  </p>', '00000005k_1.jpg', '999.30', '20.00', 0, 1, 0),
(9, 8, '.Lorem isum dolor amet elitr.', '<p><h1 align="center"><font color="#000099"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></font></h1><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre>  </p>', '20741479[1].jpg', '660.55', '30.00', 0, 1, 0),
(10, 8, '.Lorem isum dolor amet elitr.', '<p><h1 align="center"><font color="#000099"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></font></h1><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre>  </p>', '20758695[1].jpg', '360.55', '38.00', 0, 1, 0),
(11, 8, '.Lorem isum dolor amet elitr.', '<p> <h1 align="center"><font color="#000099"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></font></h1><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre> </p>', '22673338[2].jpg', '334.55', '40.00', 0, 1, 0),
(12, 8, '.Lorem isum dolor amet elitr.', '<p><h1 align="center"><font color="#000099"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></font></h1><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre>  </p>', '22571485[1].jpg', '78.99', '34.55', 0, 1, 0),
(13, 8, '.Lorem isum dolor amet elitr.', '<p><h1 align="center"><font color="#000099"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></font></h1><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre>  </p>', '22035093[2].jpg', '250.55', '33.33', 0, 1, 0),
(14, 9, '.Lorem isum dolor amet elitr.', '<p><h1 align="center"><font color="#000099"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></font></h1><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre>  </p>', '00000001.jpg', '230.33', '10.00', 0, 1, 0),
(15, 9, '.Lorem isum dolor amet elitr.', '<p> <h1 align="center"><font color="#000099"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></font></h1><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre> </p>', '00000002.jpg', '340.00', '20.00', 0, 1, 0),
(16, 9, '.Lorem isum dolor amet elitr.', '<p><h1 align="center"><font color="#000099"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></font></h1><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre>  </p>', '00000003.jpg', '56.99', '79.00', 0, 1, 0),
(17, 9, '.Lorem isum dolor amet elitr.', '<p><h1 align="center"><font color="#000099"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></font></h1><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre>  </p>', '00000004.jpg', '55.66', '10.00', 0, 1, 0),
(18, 10, '.Lorem isum dolor amet elitr.', '<p><h1 align="center"><font color="#000099"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></font></h1><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre>  </p>', '999001.jpg', '230.00', '40.00', 0, 1, 0),
(19, 10, '.Lorem isum dolor amet elitr.', '<p><h1 align="center"><font color="#000099"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></font></h1><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre>  </p>', '20170536[1].jpg', '199.00', '30.00', 0, 1, 0),
(20, 10, '.Lorem isum dolor amet elitr.', '<p><h1 align="center"><font color="#000099"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></font></h1><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre>  </p>', '21887068[2].jpg', '500.00', '50.00', 0, 1, 0),
(21, 10, '.Lorem isum dolor amet elitr.', '<p> <h1 align="center"><font color="#000099"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></font></h1><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre> </p>', '22714925[1].jpg', '550.00', '44.00', 0, 1, 0),
(22, 10, '.Lorem isum dolor amet elitr.', '<p><h1 align="center"><font color="#000099"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></font></h1><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre>  </p>', '24503669[1].jpg', '560.00', '40.00', 0, 1, 0),
(23, 10, '.Lorem isum dolor amet elitr.', '<p><h1 align="center"><font color="#000099"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></font></h1><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre>  </p>', '22848269[1].jpg', '780.66', '40.00', 0, 1, 0),
(24, 11, '.Lorem isum dolor amet elitr.', '<p><h1 align="center"><font color="#000099"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></font></h1><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre>  </p>', '00000004[1].jpg', '100.00', '10.00', 0, 1, 0),
(25, 11, '.Lorem isum dolor amet elitr.', '<p><h1 align="center"><font color="#000099"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></font></h1><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre>  </p>', '00000004M.jpg', '140.00', '20.00', 0, 1, 0),
(26, 11, '.Lorem isum dolor amet elitr.', '<p><h1 align="center"><font color="#000099"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></font></h1><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre>  </p>', '24700247[1].jpg', '333.00', '20.00', 0, 1, 0),
(27, 11, '.Lorem isum dolor amet elitr.', '<p> <h1 align="center"><font color="#000099"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></font></h1><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre> </p>', '00000005M.jpg', '45.00', '10.00', 0, 1, 0),
(28, 12, '.Lorem isum dolor amet elitr.', '<p> <h1 align="center"><font color="#000099"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></font></h1><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre> </p>', '20253387[1].jpg', '50.00', '50.00', 0, 1, 0),
(29, 12, '.Lorem isum dolor amet elitr.', '<p><h1 align="center"><font color="#000099"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></font></h1><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre>  </p>', '20254082[2].jpg', '45.00', '10.00', 0, 1, 0),
(30, 12, '.Lorem isum dolor amet elitr.', '<p><h1 align="center"><font color="#000099"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></font></h1><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre>  </p>', '20262662[2].jpg', '55.00', '10.00', 0, 1, 0),
(31, 12, '.Lorem isum dolor amet elitr.', '<p><h1 align="center"><font color="#000099"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></font></h1><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre>  </p>', '20295797[1].jpg', '89.00', '20.00', 0, 1, 0),
(32, 12, '.Lorem isum dolor amet elitr.', '<p><h1 align="center"><font color="#000099"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></font></h1><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre>  </p>', '22689108[1].jpg', '79.00', '10.00', 0, 1, 0),
(33, 12, '.Lorem isum dolor amet elitr.', '<p><h1 align="center"><font color="#000099"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></font></h1><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre>  </p>', '21766008[1].jpg', '36.00', '10.00', 0, 1, 0),
(34, 13, '.Lorem isum dolor amet elitr.', '<p><h1 align="center"><font color="#000099"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></font></h1><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre>  </p>', '23794353[1].jpg', '1999.00', '100.00', 0, 1, 0),
(35, 13, '.Lorem isum dolor amet elitr.', '<p><h1 align="center"><font color="#000099"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></font></h1><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre>  </p>', '23975368[2].jpg', '2000.00', '100.00', 0, 1, 0),
(36, 13, '.Lorem isum dolor amet elitr.', '<p> <h1 align="center"><font color="#000099"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></font></h1><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre> </p>', '23915194[1].jpg', '2.500', '10.00', 0, 1, 0),
(37, 13, '.Lorem isum dolor amet elitr.', '<p><h1 align="center"><font color="#000099"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></font></h1><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre>  </p>', '23740668[1].jpg', '1999.00', '100.00', 0, 1, 0),
(38, 13, '.Lorem isum dolor amet elitr.', '<p><h1 align="center"><font color="#000099"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></font></h1><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre>  </p>', '999003.jpg', '1999.00', '100.00', 0, 1, 0),
(39, 13, '.Lorem isum dolor amet elitr.', '<p><h1 align="center"><font color="#000099"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></font></h1><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre>  </p>', '20658850[1].jpg', '1999.00', '100.00', 0, 1, 0),
(40, 13, '.Lorem isum dolor amet elitr.', '<p><h1 align="center"><font color="#000099"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></font></h1><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre>  </p>', '23740257[1].jpg', '1999.00', '100.00', 0, 1, 0),
(41, 14, '.Lorem isum dolor amet elitr.', '<p><h1 align="center"><font color="#000099"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></font></h1><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre>  </p>', '22599340[1].jpg', '19.00', '10.00', 0, 1, 0),
(42, 14, '.Lorem isum dolor amet elitr.', '<p><h1 align="center"><font color="#000099"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></font></h1><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre>  </p>', '22599339[1].jpg', '50.00', '10.00', 0, 1, 0),
(43, 14, '.Lorem isum dolor amet elitr.', '<p><h1 align="center"><font color="#000099"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></font></h1><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre>  </p>', '22041242[1].jpg', '50.00', '10.00', 0, 1, 0),
(44, 14, '.Lorem isum dolor amet elitr.', '<p><h1 align="center"><font color="#000099"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></font></h1><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre><pre id="line1"><span class="attribute-value">Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.</span></pre>  </p>', '21190521[1].jpg', '70.00', '10.00', 0, 1, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `qub3_queries_que`
--

CREATE TABLE IF NOT EXISTS `qub3_queries_que` (
  `name_que` varchar(50) NOT NULL,
  `query_que` longtext NOT NULL,
  `desc_que` longtext NOT NULL,
  `tables_que` longtext NOT NULL,
  `version_que` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `qub3_relations_rel`
--

CREATE TABLE IF NOT EXISTS `qub3_relations_rel` (
  `table1_rel` varchar(100) NOT NULL,
  `table2_rel` varchar(100) NOT NULL,
  `t1id_rel` varchar(100) NOT NULL,
  `t2id_rel` varchar(100) NOT NULL,
  `type_rel` varchar(10) NOT NULL,
  `restrict_rel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `qub3_settings_set`
--

CREATE TABLE IF NOT EXISTS `qub3_settings_set` (
  `setting_name_set` varchar(32) NOT NULL,
  `setting_value_set` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `qub3_settings_set`
--

INSERT INTO `qub3_settings_set` (`setting_name_set`, `setting_value_set`) VALUES
('dateseparator', ''''),
('notequals', '!='),
('use_asname', 'true');

-- --------------------------------------------------------

--
-- Estrutura da tabela `template`
--

CREATE TABLE IF NOT EXISTS `template` (
  `id` int(11) NOT NULL,
  `titulo` text NOT NULL,
  `palavras` text NOT NULL,
  `descricao` text NOT NULL,
  `header` text NOT NULL,
  `rodape` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `template`
--

INSERT INTO `template` (`id`, `titulo`, `palavras`, `descricao`, `header`, `rodape`) VALUES
(1, 'Lorem isum dolor amet elitr.', 'Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.', 'Lorem isum dolor amet elitr.Lorem isum dolor amet elitr.', '<img border="0" height="147" src="http://localhost/curso_loja/uploads/media/17336-rs.jpg" width="779"/>', '<div align="center"><img border="0" height="23" src="http://localhost/curso_loja/uploads/media/btn4_blue_m.gif" width="600"/></div>');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo_site`
--

CREATE TABLE IF NOT EXISTS `tipo_site` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_site` varchar(100) NOT NULL,
  `retorno` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Extraindo dados da tabela `tipo_site`
--

INSERT INTO `tipo_site` (`id`, `tipo_site`, `retorno`) VALUES
(4, 'Site e E-commerce', 'run-in'),
(5, 'Site', 'none');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo_site_atual`
--

CREATE TABLE IF NOT EXISTS `tipo_site_atual` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_tipo` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `tipo_site_atual`
--

INSERT INTO `tipo_site_atual` (`id`, `id_tipo`) VALUES
(0, 4);

--
-- Restrições para as tabelas dumpadas
--

--
-- Restrições para a tabela `conteudo`
--
ALTER TABLE `conteudo`
  ADD CONSTRAINT `conteudo_ibfk_1` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
