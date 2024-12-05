<?php
require_once 'conexao.php';
class Insercao
{
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

  function insertUsers(
    $email,
    $name,
    $pass,
    $age,
    $permissionId,
    $dateCadastre
  ) {
    try {
      if (!$this->db) {
        throw new Exception("Falha na conexão com o banco de dados.");
      }
  
      $this->db->beginTransaction();
  
      $stmt = $this->db->prepare("INSERT INTO users (email, name, pass, age, permission_id, dateofcadastre) VALUES (:email, :name, :pass,:age, :permission_id, :dateofcadastre)");
      $stmt->bindParam(':email', $email);
      $stmt->bindParam(':name', $name);
      $stmt->bindParam(':pass', $pass);
      $stmt->bindParam(':age', $age);
      $stmt->bindParam(':permission_id', $permissionId);
      $stmt->bindParam(':dateofcadastre', $dateCadastre);
  
      $stmt->execute();
  
      $this->db->commit();
  
      return "Ok";
  
    } catch (PDOException $erro) {
      $this->db->rollback();
      return "Erro: " . $erro->getMessage();
    }
  }
  
  function insertMangas(
    $mangaName,
    $synopsis,
    $volumes,
    $author,
    $mangaLink,
    $critictNote,
    $classification,
    $yearPublication,
    $dateCadastre,
    $nameImgmanga,
    $mangaGenders
  ) {
    try {
      if (!$this->db) {
        throw new Exception("Falha na conexão com o banco de dados.");
      }
  
      $this->db->beginTransaction();
  
      // Inserir na tabela mangas
      $stmt = $this->db->prepare("INSERT INTO mangas (manga_name, synopsis, volumes, author, manga_link, manga_critic_note, classification, year_publication, manga_dateofcadastre) VALUES (:manga_name, :synopsis, :volumes, :author, :manga_link, :manga_critic_note, :classification, :year_publication, :manga_dateofcadastre)");
      $stmt->bindParam(':manga_name', $mangaName);
      $stmt->bindParam(':synopsis', $synopsis);
      $stmt->bindParam(':volumes', $volumes);
      $stmt->bindParam(':author', $author);
      $stmt->bindParam(':manga_link', $mangaLink);
      $stmt->bindParam(':manga_critic_note', $critictNote);
      $stmt->bindParam(':classification', $classification);
      $stmt->bindParam(':year_publication', $yearPublication);
      $stmt->bindParam(':manga_dateofcadastre', $dateCadastre);
  
      $stmt->execute();
  
      // Obter o ID do manga inserido
      $idmanga = $this->db->lastInsertId();
  
      // Inserir na tabela manga_img
      $stmt = $this->db->prepare("INSERT INTO manga_img (manga_id, name_img, dateofcadastre) VALUES (:manga_id, :name_img, :dateofcadastre)");
      $stmt->bindParam(':manga_id', $idmanga);
      $stmt->bindParam(':name_img', $nameImgmanga);
      $stmt->bindParam(':dateofcadastre', $dateCadastre);
  
      $stmt->execute();
  
      // Inserir na tabela manga_genders
      $stmt = $this->db->prepare("INSERT INTO manga_genders (mangas_id, genders_id) VALUES (:mangas_id, :genders_id)");
  
      foreach ($mangaGenders as $genderId) {
        $stmt->bindParam(':mangas_id', $idmanga);
        $stmt->bindParam(':genders_id', $genderId);
        $stmt->execute();
      }
  
      $this->db->commit();
  
      return "Ok";
  
    } catch (PDOException $erro) {
      $this->db->rollback();
      return "Erro: " . $erro->getMessage();
    }
  }
  
  function insertBooks(
    $bookName,
    $synopsis,
    $pagesNumber,
    $author,
    $bookLink,
    $critictNote,
    $classification,
    $yearPublication,
    $dateCadastre,
    $nameImgBookNew,
    $bookGenders
  ) {
    try {
      if (!$this->db) {
        throw new Exception("Falha na conexão com o banco de dados.");
      }
  
      $this->db->beginTransaction();
  
      // Inserir na tabela books
      $stmt = $this->db->prepare("INSERT INTO books (book_name, synopsis, pages_number, author, books_link, critic_note, classification, year_publication, dateofcadastre) VALUES (:book_name, :synopsis, :pages_number, :author, :books_link, :critic_note, :classification, :year_publication, :dateofcadastre)");
      $stmt->bindParam(':book_name', $bookName);
      $stmt->bindParam(':synopsis', $synopsis);
      $stmt->bindParam(':pages_number', $pagesNumber);
      $stmt->bindParam(':author', $author);
      $stmt->bindParam(':books_link', $bookLink);
      $stmt->bindParam(':critic_note', $critictNote);
      $stmt->bindParam(':classification', $classification);
      $stmt->bindParam(':year_publication', $yearPublication);
      $stmt->bindParam(':dateofcadastre', $dateCadastre);
  
      $stmt->execute();
  
      // Obter o ID do livro inserido
      $idbook = $this->db->lastInsertId();
  
      // Inserir na tabela books_img
      $stmt = $this->db->prepare("INSERT INTO books_img (book_id, name_img, dateofcadastre) VALUES (:book_id, :name_img, :dateofcadastre)");
      $stmt->bindParam(':book_id', $idbook);
      $stmt->bindParam(':name_img', $nameImgBookNew);
      $stmt->bindParam(':dateofcadastre', $dateCadastre);
  
      $stmt->execute();
  
      // Inserir na tabela books_genders
      $stmt = $this->db->prepare("INSERT INTO books_genders (books_id, genders_id) VALUES (:books_id, :genders_id)");
  
      foreach ($bookGenders as $genderId) {
        $stmt->bindParam(':books_id', $idbook);
        $stmt->bindParam(':genders_id', $genderId);
        $stmt->execute();
      }
  
      $this->db->commit();
  
      return "Ok";
  
    } catch (PDOException $erro) {
      $this->db->rollback();
      return "Erro: " . $erro->getMessage();
    }

  } 
  
  function insertHq(
    $hqName,
    $synopsis,
    $pagesNumber,
    $author,
    $hqLink,
    $critictNote,
    $classification,
    $yearPublication,
    $dateCadastre,
    $nameImgHqNew,
    $hqGenders
  ) {
    try {
      if (!$this->db) {
        throw new Exception("Falha na conexão com o banco de dados.");
      }
  
      $this->db->beginTransaction();
  
      // Inserir na tabela hq
      $stmt = $this->db->prepare("INSERT INTO hq (hq_name, synopsis, pages_number, author, hq_link, critic_note, classification, year_publication, dateofcadastre) VALUES (:hq_name, :synopsis, :pages_number, :author, :hq_link, :critic_note, :classification, :year_publication, :dateofcadastre)");
      $stmt->bindParam(':hq_name', $hqName);
      $stmt->bindParam(':synopsis', $synopsis);
      $stmt->bindParam(':pages_number', $pagesNumber);
      $stmt->bindParam(':author', $author);
      $stmt->bindParam(':hq_link', $hqLink);
      $stmt->bindParam(':critic_note', $critictNote);
      $stmt->bindParam(':classification', $classification);
      $stmt->bindParam(':year_publication', $yearPublication);
      $stmt->bindParam(':dateofcadastre', $dateCadastre);
  
      $stmt->execute();
  
      // Obter o ID da hq inserida
      $idhq = $this->db->lastInsertId();
  
      // Inserir na tabela hq_img
      $stmt = $this->db->prepare("INSERT INTO hq_img (hq_id, name_img, dateofcadastre) VALUES (:hq_id, :name_img, :dateofcadastre)");
      $stmt->bindParam(':hq_id', $idhq);
      $stmt->bindParam(':name_img', $nameImgHqNew);
      $stmt->bindParam(':dateofcadastre', $dateCadastre);
  
      $stmt->execute();
  
      // Inserir na tabela hq_genders
      $stmt = $this->db->prepare("INSERT INTO hq_genders (hq_id, genders_id) VALUES (:hq_id, :genders_id)");
  
      foreach ($hqGenders as $genderId) {
        $stmt->bindParam(':hq_id', $idhq);
        $stmt->bindParam(':genders_id', $genderId);
        $stmt->execute();
      }
  
      $this->db->commit();
  
      return "Ok";
  
    } catch (PDOException $erro) {
      $this->db->rollback();
      return "Erro: " . $erro->getMessage();
    }
  }
}