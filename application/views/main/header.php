<div class="navbar navbar-default navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">Sakila's Movie Catalogue</a>
      </div>
      <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
          <li class="<?php echo ( ($this->uri->segment(2) == "" ) ? "active" : "" ) ?>"><a href="<?php echo site_url('main'); ?>">Movie</a></li>
          <li class="<?php echo ( ($this->uri->segment(2) == "actor" ) ? "active" : "" ) ?>"><a href="<?php echo site_url('main/actor'); ?>">Actor</a></li>
          <!-- <li class="<?php echo ( ($this->uri->segment(2) == "search" ) ? "active" : "" ) ?>"><a href="<?php echo site_url('main/search'); ?>">Search</a></li> -->
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Help <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="<?php echo site_url('main/about'); ?>">About</a></li>
              <li><a href="<?php echo site_url('main/credit'); ?>">Credits</a></li>
            </ul>
          </li>
        </ul>
      </div><!--/.nav-collapse -->
    </div>
</div>