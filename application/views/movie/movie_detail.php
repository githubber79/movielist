<!DOCTYPE html>
<html>
	<head>
		<title>Sakila's Movie Catalogue | Movie</title>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/libs/bootstrap/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/css/main.css" />
	</head>
	<body>
		<div id="wrap">
			<!-- navigation -->
			<?php $this->load->view('main/header'); ?>
			<!-- main content -->
			<div id="movie_detail" class="container">
			</div>
		</div>
		<!-- footer -->
		<?php $this->load->view('main/footer'); ?>
			
		<script src="<?php echo base_url(); ?>/assets/libs/reactjs/react.js"></script>
		<script src="<?php echo base_url(); ?>/assets/libs/reactjs/JSXTransformer.js"></script>
		<script src="<?php echo base_url(); ?>/assets/libs/jquery/jquery.min.js"></script>
		<script src="<?php echo base_url(); ?>/assets/libs/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/jsx">
		var movie_id = <?php echo $movie_id ?>;

		var Movie = React.createClass({
			render: function() {
				return(
					<div style={{margin:'0px 5px 10px 5px'}} className="list-group-item">
					    <span className="label label-success">{this.props.category}</span> <span className="label label-info"> release year: {this.props.release_year}</span> <span className="label label-danger"> rating: {this.props.rating}</span>
					    <hr />
					    <div className="row">
					    	<div className="col-md-3">
					    		<ul className="list-group">
								  <li className="list-group-item">
								    Rental Duration: 
								    <span className="badge">{this.props.rental_duration} days</span>
								  </li>
								  <li className="list-group-item">
								    Rental Rates: 
								    <span className="badge">${this.props.rental_rate} / days</span>
								  </li>
								  <li className="list-group-item">
								    Replacement Cost: 
								    <span className="badge">${this.props.replacement_cost}</span>
								  </li>
								</ul>
					    	</div>
					    	<div className="col-md-9">
							    <p className="list-group-item-text">
							    	{this.props.description}.
							    </p>
							    <br/>
							    <ul>
							    	<li>Dubbed: {this.props.dubbed}</li>
							    	<li>Length: {this.props.film_length} minutes</li>
							    	<li>Special Features: {this.props.special_features}</li>
							    	<li>Wellknown Actor who played in this film: {this.props.total_actor} persons</li>
							    </ul>
					    	</div>
					    </div>
					    
					 </div>
				);
			}
		});
		
		var MovieStarItem = React.createClass({
			render: function(){
				actor_url = ("http://localhost/movielist/index.php/movie/actor/"+this.props.actor_id);
				
				return (
					<li><a href={actor_url}>{this.props.first_name} {this.props.last_name}</a></li>
				);	
			}	
		});

		var MovieStar = React.createClass({
			getInitialState: function(){
				return {movie_star_list:[]};
			},
			componentDidMount: function() {
				this.loadMovieStar();    
			},
			loadMovieStar : function(){
				$.get('http://localhost/movielist/index.php/movie/get_actor_by/film_id/'+this.props.movie_id, function(result) {
					console.log(result);
			      	if (this.isMounted()) {
			        	this.setState({
			        		movie_star_list: result.data
			        	});
			      	}
			    }.bind(this));
			},
			createMovieStarItem: function(item){
				console.log(item);
				return <MovieStarItem actor_id={item.actor_id} first_name={item.first_name} last_name={item.last_name} />;
			},
			render: function() {
				return (
					<div style={{margin:'0px 5px 10px 5px'}} className="list-group-item">
					    <h4 className="list-group-item-heading">Actor/Actress who starred this movie: </h4>
					    <hr />
					    <div className="row">
					    	<div className="col-md-12">
							    <ul>
							    	{this.state.movie_star_list.map(this.createMovieStarItem)}
							    </ul>
					    	</div>
					    </div>
					 </div>
				);
			}
		});

		var MovieDetail = React.createClass({
			getInitialState: function()
			{
				return { movie_data:{}, movie_id: movie_id };
			},
			loadMovie : function(page){
				$.get('http://localhost/movielist/index.php/movie/get_movie_by/film_id/'+movie_id, function(result) {
					console.log(result);
			      	if (this.isMounted()) {
			        	this.setState({
			        		movie_data: result.data
			        	});
			      	}
			    }.bind(this));
			},
			createMovieItem: function(mov){
				console.log(mov);
				return <Movie title={mov.title} description={mov.description} rental_duration={mov.rental_duration} 
								rental_rate={mov.rental_rate} replacement_cost={mov.replacement_cost} 
								dubbed={mov.dubbed} film_length={mov.film_length} special_features={mov.special_features}
								release_year={mov.release_year} rating={mov.rating} category={mov.category} 
								total_actor={mov.total_actor} film_id={mov.film_id} />;
			},
			componentDidMount: function() {
				this.loadMovie(1);    
			},
			render: function() {
				return (
					<div>
						<div className="page-header">
							<h1>{this.state.movie_data.title}</h1>
						</div>
						<div className="list-group">
							{this.createMovieItem(this.state.movie_data)}
						</div>
						<div className="list-group">
							<MovieStar movie_id={this.state.movie_id} />
						</div>
					</div>
				);
			}
		});

		var MovieDetailApp = React.createClass({
			render: function(){
				return ( 
					<MovieDetail />
				);
			}
		});

		// render komponen utama
		React.render(<MovieDetailApp />, document.getElementById('movie_detail'));
		</script>
	</body>	
</html>