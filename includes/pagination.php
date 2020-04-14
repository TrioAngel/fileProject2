<?php

class Pagination {
  private $directory;
  public $sort = [];

  public function pagination_display($data) {
    if(isset($data['page_url']) && !empty($data['page_url'])){
      $page_url = $data['page_url'];
    } else {
      echo "no pagination Url mentioned.";
      return false;
    }
    if(isset($data['total_rec']) && !empty($data['total_rec'])){
      $total_rec = $data['total_rec'];
    } else {
      echo "No total records mentioned.";
      return false;
    }
    if(isset($data['rec_per_page']) && !empty($data['rec_per_page'])){
      $rec_per_page = $data['rec_per_page'];
    } else {
      echo "no record for per page mentioned.";
      return false;
    }

    $total_pages = $this->total_pages($data);
    if(isset($_GET['page'])){
      $current_page = $_GET['page'];
    } else {
      $current_page = '';
    }
    if($current_page = '' || $current_page < 1 || $current_page > $total_pages){
      $current_page = 1;
      $start_rec = 0;
    } else {
      $start_rec = ($current_page * $rec_per_page) - $rec_per_page;
    }
    $this->pagination_control($current_page, $total_pages, $page_url);

    return 0;
  }

  public function __construct($directory, $sort) {
    $this->directory = $directory;
    $this->sort = $sort;
  }

  private function total_pages($data){
    $total_rec = $data['total_rec'];
    $rec_per_page = $data['rec_per_page'];
    $total_pages = ceil($total_rec / $rec_per_page);
    return $total_pages;
  }

  private function pagination_control($current_page, $total_pages, $page_url){
    echo "<ul class='pagination'>";
    $prev = $current_page - 1;
    $next = $current_page + 1;
    echo '<li><a href="'. $page_url .'?page=1&directory='. $this->directory .'&sort_flag='. $this->sort['flag'] .'&sorted_by='. $this->sort['name'] .'"> <<< </a></li>';
    if($current_page >= 2){
      echo '<li><a href="'. $page_url .'?page='. $prev .'&directory='. $this->directory .'&sort_flag='. $this->sort['flag'] .'&sorted_by='. $this->sort['name'] .'"> << </a>></li>';
    }

    $start_page = 1;
    if ($current_page <= $total_pages && $current_page > ($start_page + 2)){
      $start_page = $current_page - 2;
    }
    if ($current_page <= $total_pages && $current_page > ($start_page + 2)){
      $end_page = $current_page + 2;
    } else {
      $end_page = $total_pages;
    }

    for($start_page; $start_page <= $end_page; $start_page++){
      if ($current_page == $start_page){
        echo '<li class="active"><a href="#">'. $start_page .'</a></li>';
      } else {
        echo '<li><a href="'. $page_url .'?page='. $start_page .'&directory='. $this->directory .'&sort_flag='. $this->sort['flag'] .'&sorted_by='. $this->sort['name'] .'">'. $start_page .' </a></li>';
      }
    }

    if ($current_page < $total_pages){
      echo '<li><a href="'. $page_url .'?page='. $next . '&directory='. $this->directory .'&sort_flag='. $this->sort['flag'] .'&sorted_by='. $this->sort{'name'} .'"> >> </a></li>';
    }
    echo '<li><a href="'. $page_url .'?page='. $total_pages . '&directory='. $this->directory .'&sort_flag='. $this->sort['flag'] .'&sorted_by='. $this->sort{'name'} .'"> >>> </a></li>';
    echo '</ul>';
  }

  public function start_rec($data) {
    if (isset($_GET['page'])) {
      $current_page = $_GET['page'];
    } else {
      $current_page = '';
    }
    $total_pages = $this -> total_pages($data);
    if (isset($data['rec_per_page']) && !empty($data['rec_per_page'])) {
      $rec_per_page = $data['rec_per_page'];
    } else {
      echo 'No records per page mentioned here...';
      return false;
    }
    if ($current_page == '' || $current_page < 1 || $current_page > $total_pages) {
      $start_rec = 0;
      return $start_rec;
    } else {
      $start_rec = ($current_page * $rec_per_page) - $rec_per_page;
      return $start_rec;
    }
  }


}