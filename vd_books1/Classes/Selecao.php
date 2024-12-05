<?php
require_once 'Conexao.php';

class Selecao {
    private $pdo;

    private $db;

    public function __construct()
    {
      try {
        // Conexão com o banco de dados
        $this->db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->db->exec("set names 'utf8'");
      } catch (PDOException $e) {
        // Tratamento de erro
        echo 'Erro ao conectar ao banco de dados: ' . $e->getMessage();
      }
    }

    function selecionarGeneros() {
        try {
            if (!$this->db) {
                throw new Exception("Falha na conexão com o banco de dados.");
            }
    
            // Consulta para selecionar o nome e o ID dos gêneros
            $stmt = $this->db->prepare("SELECT id_gender, desc_gender FROM genders;");
    
            if ($stmt->execute()) {
                // Traz todos os resultados em vez de apenas um
                $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $res;
            } else {
                throw new Exception("Erro na execução da consulta.");
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }
    

    function selecionarMangasPorNota() {
        try {
            if (!$this->db) {
                throw new Exception("Falha na conexão com o banco de dados.");
            }
    
            $stmt = $this->db->prepare(
                "SELECT 
                    m.id_manga,
                    m.manga_name,
                    m.author,
                    m.year_publication,
                    m.synopsis,
                    m.manga_critic_note,
                    m.manga_link,
                    m.volumes,
                    m.classification,
                    img.name_img,
                    GROUP_CONCAT(DISTINCT g.desc_gender ORDER BY g.desc_gender ASC SEPARATOR ', ') AS genero,
                    AVG(r.note) AS media_nota -- Cálculo da média da nota dos reviews
                FROM mangas m
                LEFT JOIN manga_img img ON m.id_manga = img.manga_id
                LEFT JOIN manga_genders mg ON m.id_manga = mg.mangas_id
                LEFT JOIN genders g ON mg.genders_id = g.id_gender
                LEFT JOIN mangas_reviews r ON m.id_manga = r.manga_id -- Junção com a tabela de reviews
                GROUP BY m.id_manga
                ORDER BY m.manga_critic_note DESC"
            );
    
            if ($stmt->execute()) {
                $mangas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
                // Buscar as avaliações
                $stmtReviews = $this->db->prepare(
                    "SELECT 
                        r.manga_id,
                        u.name AS usuario,
                        r.note AS nota,
                        r.comment AS comentario
                    FROM mangas_reviews r
                    LEFT JOIN users u ON r.user_id = u.id_users"
                );
    
                if ($stmtReviews->execute()) {
                    $reviews = $stmtReviews->fetchAll(PDO::FETCH_ASSOC);
    
                    // Organizar avaliações por mangá
                    $reviewsByManga = [];
                    foreach ($reviews as $review) {
                        $reviewsByManga[$review['manga_id']][] = $review;
                    }
    
                    // Adicionar avaliações aos mangas
                    foreach ($mangas as &$manga) {
                        $manga['avaliacoes'] = isset($reviewsByManga[$manga['id_manga']]) ? $reviewsByManga[$manga['id_manga']] : [];
                    }
    
                    return $mangas;
                } else {
                    throw new PDOException("Erro: Não foi possível executar a declaração SQL para buscar avaliações.");
                }
            } else {
                throw new PDOException("Erro: Não foi possível executar a declaração SQL da função selecionarMangas.");
            }
        } catch (PDOException $erro) {
            echo "Erro: " . $erro->getMessage();
        }
    }    

    function selecionarLivrosPorNota() {
        try {
            if (!$this->db) {
                throw new Exception("Falha na conexão com o banco de dados.");
            }
    
            $stmt = $this->db->prepare(
                "SELECT 
                    b.id_book,
                    b.book_name,
                    b.synopsis,
                    b.pages_number,
                    b.author,
                    b.books_link,
                    b.critic_note,
                    b.classification,
                    img.name_img,
                    GROUP_CONCAT(DISTINCT g.desc_gender ORDER BY g.desc_gender ASC SEPARATOR ', ') AS genero,
                    AVG(r.note) AS media_nota -- Cálculo da média da nota dos reviews
                FROM books b
                LEFT JOIN books_img img ON b.id_book = img.book_id
                LEFT JOIN books_genders bg ON b.id_book = bg.book_id
                LEFT JOIN genders g ON bg.genders_id = g.id_gender
                LEFT JOIN books_reviews r ON b.id_book = r.book_id -- Junção com a tabela de reviews
                GROUP BY b.id_book
                ORDER BY b.critic_note DESC"
            );
    
            if ($stmt->execute()) {
                $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
                // Buscar as avaliações
                $stmtReviews = $this->db->prepare(
                    "SELECT 
                        r.book_id,
                        u.name AS usuario,
                        r.note AS nota,
                        r.comment AS comentario
                    FROM books_reviews r
                    LEFT JOIN users u ON r.user_id = u.id_users"
                );
    
                if ($stmtReviews->execute()) {
                    $reviews = $stmtReviews->fetchAll(PDO::FETCH_ASSOC);
    
                    // Organizar avaliações por livro
                    $reviewsByBooks = [];
                    foreach ($reviews as $review) {
                        $reviewsByBooks[$review['book_id']][] = $review;
                    }
    
                    // Adicionar avaliações aos livro
                    foreach ($books as &$book) {
                        $book['avaliacoes'] = isset($reviewsByBooks[$book['id_book']]) ? $reviewsByBooks[$book['id_book']] : [];
                    }
    
                    return $books;
                } else {
                    throw new PDOException("Erro: Não foi possível executar a declaração SQL para buscar avaliações.");
                }
            } else {
                throw new PDOException("Erro: Não foi possível executar a declaração SQL da função selecionarLivros.");
            }
        } catch (PDOException $erro) {
            echo "Erro: " . $erro->getMessage();
        }
    }   

    function selecionarHqPorNota() {
        try {
            if (!$this->db) {
                throw new Exception("Falha na conexão com o banco de dados.");
            }
    
            $stmt = $this->db->prepare(
                "SELECT 
                    h.id_hq,
                    h.hq_name,
                    h.synopsis,
                    h.pages_number,
                    h.author,
                    h.hq_link,
                    h.critic_note,
                    h.classification,
                    h.year_publication,
                    img.name_img,
                    GROUP_CONCAT(DISTINCT g.desc_gender ORDER BY g.desc_gender ASC SEPARATOR ', ') AS genero,
                    AVG(r.note) AS media_nota -- Cálculo da média da nota dos reviews
                FROM books b
                LEFT JOIN hq_img img ON h.id_hq = img.hq_id
                LEFT JOIN hq_genders hg ON h.id_hq = hg.hq_id
                LEFT JOIN genders g ON hg.genders_id = g.id_gender
                LEFT JOIN hq_reviews r ON h.id_hq = r.hq_id -- Junção com a tabela de reviews
                GROUP BY h.id_hq
                ORDER BY h.critic_note DESC"
            );
    
            if ($stmt->execute()) {
                $hqs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
                // Buscar as avaliações
                $stmtReviews = $this->db->prepare(
                    "SELECT 
                        r.hq_id,
                        u.name as user
                        r.note 
                        r.comment 
                    FROM hq_reviews r
                    LEFT JOIN users u ON r.user_id = u.id_users"
                );
    
                if ($stmtReviews->execute()) {
                    $reviews = $stmtReviews->fetchAll(PDO::FETCH_ASSOC);
    
                    // Organizar avaliações por livro
                    $reviewsByHq = [];
                    foreach ($reviews as $review) {
                        $reviewsByHq[$review['hq_id']][] = $review;
                    }
    
                    // Adicionar avaliações aos livro
                    foreach ($hqs as &$hq) {
                        $hq['avaliacoes'] = isset($reviewsByHq[$hq['id_hq']]) ? $reviewsByHq[$hq['id_hq']] : [];
                    }
    
                    return $hqs;
                } else {
                    throw new PDOException("Erro: Não foi possível executar a declaração SQL para buscar avaliações.");
                }
            } else {
                throw new PDOException("Erro: Não foi possível executar a declaração SQL da função selecionarLivros.");
            }
        } catch (PDOException $erro) {
            echo "Erro: " . $erro->getMessage();
        }
    }   
    
    function selecionarLogin($email, $pass){
        try {
            if (!$this->db) {
                throw new Exception("Falha na conexão com o banco de dados.");
            }
      
            // Modifique a consulta SQL para selecionar o nome e o ID do login
            $stmt = $this->db->prepare("SELECT id_users, email, name, pass, age, permission_id, COUNT(id_users) as qtd FROM users WHERE email = :email AND pass = :pass");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':pass', $pass);
      
            if ($stmt->execute()) {
                $res = $stmt->fetch(PDO::FETCH_OBJ);
                return $res;
            } else {
                throw new PDOException("Erro na execução da consulta.");
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return null;
        }
      }
      
}