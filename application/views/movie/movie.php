<!DOCTYPE html>
<html>
	<head>
		<title>Sakila's Movie Catalogue | Movie List</title>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/libs/bootstrap/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/css/main.css" />
	</head>
	<body>
		<div id="wrap">
			<!-- navigation -->
			<?php $this->load->view('main/header'); ?>
			<!-- main content -->
			<div class="container">
				<div class="page-header">
					<h1>Movie List</h1>
				</div>
				<div id="movie_list">
				</div>
			</div>
		</div>
		<!-- footer -->
		<?php $this->load->view('main/footer'); ?>
			
		<script src="<?php echo base_url(); ?>/assets/libs/reactjs/react.min.js"></script>
		<script src="<?php echo base_url(); ?>/assets/libs/reactjs/JSXTransformer.js"></script>
		<script src="<?php echo base_url(); ?>/assets/libs/jquery/jquery.min.js"></script>
		<script src="<?php echo base_url(); ?>/assets/libs/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/jsx">
			var movie_page = 1;

			var MoviePager = React.createClass({

				render: function(){
					return (
						<ul className="pager">
						  <li onClick={this.props.prevEvent} className="previous"><a href="javascript:void(0);">&larr; Older</a></li>
						  <li onClick={this.props.nextEvent} className="next"><a href="javascript:void(0);">Newer &rarr;</a></li>
						</ul>
					);
				}
			});

			var Movie = React.createClass({
				render: function() {
					movie_url = ("http://localhost/movielist/index.php/movie/index/"+this.props.film_id);
					
					return(
						<div style={{margin:'0px 5px 10px 5px'}} className="list-group-item">
						    <h3 className="list-group-item-heading"><a href={movie_url}>{this.props.title}</a></h3>
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

			var MovieList = React.createClass({
				getInitialState: function()
				{
					return { movie_list:[], prev_btn_status: false };
				},
				handlePrev: function(){
					movie_page -= 1;
					this.loadMovie(movie_page);
				},
				handleNext: function(){
					movie_page += 1;
					this.loadMovie(movie_page);
				},
				loadMovie : function(page){
					$.get('http://localhost/movielist/index.php/movie/get_movie/'+movie_page, function(result) {
				      	if (this.isMounted()) {
				        	this.setState({
				        		movie_list: result.data
				        	});
				      	}
				    }.bind(this));
				},
				componentDidMount: function() {
					this.loadMovie(1);    
				},
				render: function() {
					function createMovieItem(mov) {
						console.log(mov);
						return <Movie title={mov.title} description={mov.description} rental_duration={mov.rental_duration} 
										rental_rate={mov.rental_rate} replacement_cost={mov.replacement_cost} 
										dubbed={mov.dubbed} film_length={mov.film_length} special_features={mov.special_features}
										release_year={mov.release_year} rating={mov.rating} category={mov.category} 
										total_actor={mov.total_actor} film_id={mov.film_id} />;
					}

					return (
						<div className="list-group">
							<MoviePager prevEvent={this.handlePrev} nextEvent={this.handleNext} /> 
							{this.state.movie_list.map(createMovieItem)}
							<MoviePager prevEvent={this.handlePrev} nextEvent={this.handleNext} /> 
						</div>

					);
				}
			});

			var MovieApp = React.createClass({
				
				render: function(){
					return ( 
						<MovieList />
					);
				}
			});

			// render komponen utama
			React.render(<MovieApp />, document.getElementById('movie_list'));
		</script>
	</body>	
</html>