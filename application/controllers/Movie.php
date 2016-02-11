<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Movie extends CI_Controller {

	public function index($id="")
	{
		$movie_id = $this->uri->segment(3);
		$this->load->view('movie/movie_detail', array('movie_id' => $movie_id));
	}

	public function actor($id="")
	{
		$actor_id = $this->uri->segment(3);
		$this->load->view('movie/actor_detail', array('actor_id' => $actor_id));
	}

	/* AJAX */
	public function get_movie($idx=1)
	{
		$this->load->database();
		$page = 20;
		$start = ($idx - 1) * $page;
		$limit = ' LIMIT '.$start.', '.$page;

		$query = "SELECT  f.film_id,
							f.title,
							f.description,
							f.release_year,
							f.rental_duration,
							f.rental_rate,
							f.length as film_length,
							f.replacement_cost,
							f.rating,
							f.special_features,
							f.last_update,
							l.name as dubbed,
							cat.name as category,
							(select count(ac.actor_id) from actor ac join film_actor fa on ac.actor_id = fa.actor_id where fa.film_id=f.film_id) as total_actor
				  FROM film f join language l on l.language_id = f.language_id 
				  		join film_category fc on fc.film_id = f.film_id
				  		join category cat on cat.category_id = fc.category_id  order by f.title
				  ".$limit;

		$result = $this->db->query($query)->result();
		
		$data['error_code'] = "0";
		$data['error_msg'] = "Retrieving movie list is success";
		$data['data'] = $result;

		// header("Access-Control-Allow-Origin: *");
		// header("Access-Control-Allow-Methods: PUT, GET, POST");
		// header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
		header('Content-Type: application/json; charset=UTF-8');
		
		echo json_encode($data);
	}

	public function get_movie_all()
	{
		$this->load->database();
		$query = "SELECT  f.film_id,
							f.title,
							f.description,
							f.release_year,
							f.rental_duration,
							f.rental_rate,
							f.length as film_length,
							f.replacement_cost,
							f.rating,
							f.special_features,
							f.last_update,
							l.name as dubbed,
							cat.name as category,
							(select count(ac.actor_id) from actor ac join film_actor fa on ac.actor_id = fa.actor_id where fa.film_id=f.film_id) as total_actor
				  FROM film f join language l on l.language_id = f.language_id 
				  		join film_category fc on fc.film_id = f.film_id
				  		join category cat on cat.category_id = fc.category_id  order by f.title";

		$result = $this->db->query($query)->result();
		
		$data['error_code'] = "0";
		$data['error_msg'] = "Retrieving movie list is success";
		$data['data'] = $result;

		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Methods: PUT, GET, POST");
		header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
		header('Content-Type: application/json; charset=UTF-8');
		
		echo json_encode($data);
	}

	/* AJAX */
	public function get_movie_by($option="id", $id=0)
	{
		$this->load->database();

		if ($option == "film_id")
		{
			$query = "SELECT  f.film_id,
							f.title,
							f.description,
							f.release_year,
							f.rental_duration,
							f.rental_rate,
							f.length as film_length,
							f.replacement_cost,
							f.rating,
							f.special_features,
							f.last_update,
							l.name as dubbed,
							cat.name as category,
							(select count(ac.actor_id) from actor ac join film_actor fa on ac.actor_id = fa.actor_id where fa.film_id=f.film_id) as total_actor
				  FROM film f join language l on l.language_id = f.language_id 
				  		join film_category fc on fc.film_id = f.film_id
				  		join category cat on cat.category_id = fc.category_id  where f.film_id = ".$id;

			$result = $this->db->query($query)->row();
		}
		else if ($option == "actor_id")
		{
			$query = "SELECT  f.film_id,
							f.title,
							f.description,
							f.release_year,
							f.rental_duration,
							f.rental_rate,
							f.length as film_length,
							f.replacement_cost,
							f.rating,
							f.special_features,
							f.last_update,
							l.name as dubbed,
							cat.name as category,
							(select count(ac.actor_id) from actor ac join film_actor fa on ac.actor_id = fa.actor_id where fa.film_id=f.film_id) as total_actor
			  		FROM film f join language l on l.language_id = f.language_id 
				  		join film_category fc on fc.film_id = f.film_id
				  		join category cat on cat.category_id = fc.category_id  
				  		join film_actor fa on fa.film_id = f.film_id
				  		where fa.actor_id = ".$id;

			$result = $this->db->query($query)->result();
		}
		
		
		$data['error_code'] = "0";
		$data['error_msg'] = "Retrieving movie detail is success";
		$data['data'] = $result;

		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Methods: PUT, GET, POST");
		header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
		header('Content-Type: application/json; charset=UTF-8');
		
		echo json_encode($data);
	}

	/* AJAX */
	public function search_movie($idx=1)
	{
		$this->load->database();
		$page = 10;
		$start = ($idx - 1) * $page;
		$limit = ' LIMIT '.$start.', '.$page;

		$query = "SELECT  f.film_id,
							f.title,
							f.description,
							f.release_year,
							f.rental_duration,
							f.rental_rate,
							f.length as film_length,
							f.replacement_cost,
							f.rating,
							f.special_features,
							f.last_update,
							l.name as dubbed,
							cat.name as category,
							(select count(ac.actor_id) from actor ac join film_actor fa on ac.actor_id = fa.actor_id where fa.film_id=f.film_id) as total_actor
				  FROM film f join language l on l.language_id = f.language_id 
				  		join film_category fc on fc.film_id = f.film_id
				  		join category cat on cat.category_id = fc.category_id where f.title like '%".$_POST['keyword']."%'  
				  		having (f.rental_duration >= ".$_POST['rental_duration']['min']." and f.rental_duration <= ".$_POST['rental_duration']['max'].")
				  			and (f.rental_rate >= ".$_POST['rental_rate']['min']." and f.rental_rate <= ".$_POST['rental_rate']['max'].") 
				  			and (f.replacement_cost >= ".$_POST['replacement_cost']['min']." and f.replacement_cost <= ".$_POST['replacement_cost']['max'].") 
				  			and (f.length >= ".$_POST['video_length']['min']." and f.length <= ".$_POST['video_length']['max'].") 
				  ORDER by f.title
				  ".$limit;

		$result = $this->db->query($query)->result();
		
		$data['error_code'] = "0";
		$data['error_msg'] = "Retrieving movie list is success";
		$data['last_query'] = $this->db->last_query();
		$data['data'] = $result;

		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Methods: PUT, GET, POST");
		header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
		header('Content-Type: application/json; charset=UTF-8');
		
		echo json_encode($data);
	}

	/* AJAX */
	public function get_actor($idx=1)
	{
		$this->load->database();
		$page = 10;
		$start = ($idx - 1) * $page;
		$limit = ' LIMIT '.$start.', '.$page;

		$query = "select 
					    *,
					    (select 
					        count(f.film_id) as total_movie
					    FROM
					        film_actor fa
					    join film f ON f.film_id = fa.film_id where fa.actor_id = ac.actor_id) as total_movie,
					    (SELECT GROUP_CONCAT( distinct(cat.name) separator ',') as category 
						  FROM film f 
								join film_category fc on fc.film_id = f.film_id
								join category cat on cat.category_id = fc.category_id
					            join film_actor fa on fa.film_id = f.film_id where
					            fa.actor_id = ac.actor_id) as movie_genre,
						(SELECT count(distinct(fa.actor_id))
						  FROM film f 
								join film_actor fa on fa.film_id = f.film_id where
					            fa.film_id in (select fa2.film_id from film_actor fa2 where fa2.actor_id = ac.actor_id)) as total_partner
					from
					    actor ac
							 order by ac.first_name
				  ".$limit;

		$result = $this->db->query($query)->result();
		
		$data['error_code'] = "0";
		$data['error_msg'] = "Retrieving actor list is success";
		$data['data'] = $result;

		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Methods: PUT, GET, POST");
		header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
		header('Content-Type: application/json; charset=UTF-8');
		
		echo json_encode($data);
	}

	/* AJAX */
	public function get_actor_by($option="id", $id=0)
	{
		$this->load->database();
		$query = "";

		if ($option == "id")
		{
			$query = "select 
					    *,
						(select 
					        count(f.film_id) as total_movie
					    FROM
					        film_actor fa
					    join film f ON f.film_id = fa.film_id where fa.actor_id = ac.actor_id) as total_movie,
					    (SELECT GROUP_CONCAT( distinct(cat.name) separator ',') as category 
						  FROM film f 
								join film_category fc on fc.film_id = f.film_id
								join category cat on cat.category_id = fc.category_id
					            join film_actor fa on fa.film_id = f.film_id where
					            fa.actor_id = ac.actor_id) as movie_genre,
						(SELECT count(distinct(fa.actor_id))
						  FROM film f 
								join film_actor fa on fa.film_id = f.film_id where
					            fa.film_id in (select fa2.film_id from film_actor fa2 where fa2.actor_id = ac.actor_id)) as total_partner
					from
					    actor ac
					where
						ac.actor_id = ".$id;		
			$result = $this->db->query($query)->row();
		}
		else if ($option == "film_id")
		{
			$query = "select 
					    *
					from
					    actor ac join film_actor fa on fa.actor_id = ac.actor_id
					where
						fa.film_id = ".$id."
					order by ac.first_name
				  ";
			$result = $this->db->query($query)->result();
		}
		else if ($option == 'partner')
		{
			$query = "SELECT distinct(fa.actor_id), ac.first_name, ac.last_name
					  FROM film f 
							join film_actor fa on fa.film_id = f.film_id 
				            join actor ac on ac.actor_id = fa.actor_id where
				            fa.film_id in (select fa2.film_id from film_actor fa2 where fa2.actor_id = ".$id.") order by ac.first_name";
			$result = $this->db->query($query)->result();
		}
		
		$data['error_code'] = "0";
		$data['error_msg'] = "Retrieving actor list is success";
		$data['data'] = $result;

		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Methods: PUT, GET, POST");
		header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
		header('Content-Type: application/json; charset=UTF-8');
		
		echo json_encode($data);
	}
}
