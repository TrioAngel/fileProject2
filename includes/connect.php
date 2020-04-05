<?php
define('DSN', 'mysql:host=localhost;dbname=mydata');
define('USERNAME', 'root');
define('PASSWORD', '');

class Connect {
  public function __construct() {
    try{
      $this->DB = new PDO(DSN, USERNAME, PASSWORD);
    } catch (PDOException $e){
      $e->getMessage();
    }
  }

  public function count_table_row(){
    $sql = "SELECT * FROM tablepaginate";
    $statement = $this->DB->query($sql);
    $count_table_row = $statement->rowCount();
    if ($count_table_row){
      return $count_table_row;
    } else {
      return false;
    }
  }

  public function showpage($start_rec, $rec_per_page){
    $sql = "SELECT * FROM `tablepaginate` ORDER BY `ID` DESC LIMIT $start_rec, $rec_per_page ";
    try{
      $result = $this->DB->query($sql);
      if ($result->rowCount()){
        echo '<br>';
        while($row = $result->fetch()){
          echo $row['ID'] . '<br>';
        }
      } else {
        return false;
      }
    } catch (PDOException $e){
      $e->getMessage();
    }
  }

}